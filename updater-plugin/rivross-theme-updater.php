<?php
/**
 * Plugin Name: RIVROSS Theme Updates
 * Description: Adds GitHub Releases update notifications for the RIVROSS Corporate theme.
 * Version: 1.0.1
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: RIVROSS Company Limited
 * License: GPL-2.0-or-later
 * Text Domain: rivross-corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RIVROSS_GITHUB_UPDATER_REPO', 'leonislam81/rivross-corporate' );

/** Clear stale release/theme data when the bootstrap plugin is first enabled. */
function rivross_github_updater_activate() {
	delete_transient( 'rivross_github_updater_release' );
	delete_site_transient( 'update_themes' );
}
register_activation_hook( __FILE__, 'rivross_github_updater_activate' );

/**
 * Read the optional least-privilege GitHub token used for private release checks and downloads.
 * A wp-config.php constant takes precedence over the admin-stored option.
 *
 * @return string
 */
function rivross_github_updater_token() {
	if ( defined( 'RIVROSS_GITHUB_TOKEN' ) && RIVROSS_GITHUB_TOKEN ) {
		return trim( (string) RIVROSS_GITHUB_TOKEN );
	}

	return trim( (string) get_option( 'rivross_github_updater_token', '' ) );
}

/**
 * Fetch and cache the latest stable GitHub release and its installable ZIP.
 *
 * @return array|WP_Error
 */
function rivross_github_updater_latest_release() {
	$cache_key = 'rivross_github_updater_release';
	$cached    = get_transient( $cache_key );
	if ( is_array( $cached ) ) {
		return $cached;
	}

	$token   = rivross_github_updater_token();
	$headers = array(
		'Accept'               => 'application/vnd.github+json',
		'User-Agent'           => 'RIVROSS-Corporate-Theme-Updater',
		'X-GitHub-Api-Version' => '2022-11-28',
	);
	if ( '' !== $token ) {
		$headers['Authorization'] = 'Bearer ' . $token;
	}

	$response = wp_remote_get(
		'https://api.github.com/repos/' . RIVROSS_GITHUB_UPDATER_REPO . '/releases/latest',
		array(
			'timeout' => 15,
			'headers' => $headers,
		)
	);

	if ( is_wp_error( $response ) ) {
		return new WP_Error( 'rivross_github_connection_failed', __( 'WordPress could not connect to GitHub. Check the server connection and try again.', 'rivross-corporate' ) );
	}

	$status_code = (int) wp_remote_retrieve_response_code( $response );
	$release     = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( 200 !== $status_code || ! is_array( $release ) ) {
		return new WP_Error( 'rivross_github_release_unavailable', __( 'GitHub could not return the latest release. Check repository visibility or token access, and confirm a release has been published.', 'rivross-corporate' ) );
	}

	if ( empty( $release['tag_name'] ) || empty( $release['html_url'] ) || empty( $release['assets'] ) || ! is_array( $release['assets'] ) ) {
		return new WP_Error( 'rivross_github_release_incomplete', __( 'The latest GitHub release is missing its version or installable theme ZIP.', 'rivross-corporate' ) );
	}

	if ( ! preg_match( '/^v?(\d+\.\d+\.\d+)$/i', (string) $release['tag_name'], $version_match ) ) {
		return new WP_Error( 'rivross_github_release_bad_version', __( 'The latest release tag must use a version like v1.2.3.', 'rivross-corporate' ) );
	}

	$asset_id = 0;
	foreach ( $release['assets'] as $asset ) {
		if ( isset( $asset['name'], $asset['id'] ) && 'rivross-corporate.zip' === $asset['name'] && 'uploaded' === ( $asset['state'] ?? '' ) ) {
			$asset_id = absint( $asset['id'] );
			break;
		}
	}

	if ( ! $asset_id ) {
		return new WP_Error( 'rivross_github_release_zip_missing', __( 'The latest GitHub release does not include rivross-corporate.zip yet. Wait for the release packaging action to finish, then check again.', 'rivross-corporate' ) );
	}

	$data = array(
		'version' => $version_match[1],
		'tag'     => (string) $release['tag_name'],
		'url'     => esc_url_raw( $release['html_url'] ),
		'package' => 'https://api.github.com/repos/' . RIVROSS_GITHUB_UPDATER_REPO . '/releases/assets/' . $asset_id,
	);
	set_transient( $cache_key, $data, 15 * MINUTE_IN_SECONDS );

	return $data;
}

/**
 * Add download headers only to this repository's release ZIP request.
 *
 * @param array  $args Request arguments.
 * @param string $url  Request URL.
 * @return array
 */
function rivross_github_updater_authorize_package_download( $args, $url ) {
	$token = rivross_github_updater_token();
	$host  = wp_parse_url( $url, PHP_URL_HOST );
	$path  = wp_parse_url( $url, PHP_URL_PATH );

	if (
		'api.github.com' === $host &&
		is_string( $path ) &&
		preg_match( '#^/repos/leonislam81/rivross-corporate/releases/assets/[0-9]+$#', $path )
	) {
		if ( empty( $args['headers'] ) || ! is_array( $args['headers'] ) ) {
			$args['headers'] = array();
		}
		$args['headers']['Accept']               = 'application/octet-stream';
		$args['headers']['User-Agent']           = 'RIVROSS-Corporate-Theme-Updater';
		$args['headers']['X-GitHub-Api-Version'] = '2022-11-28';
		if ( '' !== $token ) {
			$args['headers']['Authorization'] = 'Bearer ' . $token;
		}
	}

	return $args;
}
add_filter( 'http_request_args', 'rivross_github_updater_authorize_package_download', 10, 2 );

/**
 * Add a newer private GitHub release to WordPress's theme update transient.
 *
 * @param object $transient Existing update data.
 * @return object
 */
function rivross_github_updater_add_theme_update( $transient ) {
	if ( ! is_object( $transient ) ) {
		$transient = new stdClass();
	}
	if ( empty( $transient->response ) || ! is_array( $transient->response ) ) {
		$transient->response = array();
	}
	if ( empty( $transient->no_update ) || ! is_array( $transient->no_update ) ) {
		$transient->no_update = array();
	}

	$theme   = wp_get_theme( 'rivross-corporate' );
	$release = rivross_github_updater_latest_release();
	if ( ! $theme->exists() || is_wp_error( $release ) ) {
		return $transient;
	}

	$update_data = array(
		'theme'        => 'rivross-corporate',
		'new_version'  => $release['version'],
		'url'          => $release['url'],
		'package'      => $release['package'],
		'requires'     => $theme->get( 'RequiresWP' ) ? $theme->get( 'RequiresWP' ) : '6.0',
		'requires_php' => $theme->get( 'RequiresPHP' ) ? $theme->get( 'RequiresPHP' ) : '7.4',
	);

	if ( version_compare( $release['version'], $theme->get( 'Version' ), '>' ) ) {
		$transient->response['rivross-corporate'] = $update_data;
		unset( $transient->no_update['rivross-corporate'] );
	} else {
		unset( $transient->response['rivross-corporate'] );
		$transient->no_update['rivross-corporate'] = $update_data;
	}

	return $transient;
}
add_filter( 'pre_set_site_transient_update_themes', 'rivross_github_updater_add_theme_update', 20 );

/** Add an administrator-only settings screen under Settings. */
function rivross_github_updater_add_admin_page() {
	add_options_page(
		__( 'RIVROSS Theme Updates', 'rivross-corporate' ),
		__( 'RIVROSS Theme Updates', 'rivross-corporate' ),
		'manage_options',
		'rivross-theme-updates',
		'rivross_github_updater_render_admin_page'
	);
}
add_action( 'admin_menu', 'rivross_github_updater_add_admin_page' );

/** Save or remove the GitHub token without ever rendering its saved value. */
function rivross_github_updater_handle_token_save() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to manage theme update settings.', 'rivross-corporate' ) );
	}

	check_admin_referer( 'rivross_github_updater_settings' );
	if ( isset( $_POST['remove_token'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		delete_option( 'rivross_github_updater_token' );
		$status = 'removed';
	} else {
		$token = isset( $_POST['github_token'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['github_token'] ) ) ) : '';
		if ( '' === $token ) {
			$status = 'unchanged';
		} else {
			update_option( 'rivross_github_updater_token', $token, false );
			$status = 'saved';
		}
	}

	delete_transient( 'rivross_github_updater_release' );
	delete_site_transient( 'update_themes' );
	wp_safe_redirect( add_query_arg( 'rivross_updater_status', $status, admin_url( 'options-general.php?page=rivross-theme-updates' ) ) );
	exit;
}
add_action( 'admin_post_rivross_github_updater_save_token', 'rivross_github_updater_handle_token_save' );

/** Render token setup and release status. */
function rivross_github_updater_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$has_token = '' !== rivross_github_updater_token();
	$release   = rivross_github_updater_latest_release();
	$status    = isset( $_GET['rivross_updater_status'] ) ? sanitize_key( wp_unslash( $_GET['rivross_updater_status'] ) ) : '';
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'RIVROSS Theme Updates', 'rivross-corporate' ); ?></h1>
		<p><?php esc_html_e( 'Connect this site to the RIVROSS GitHub repository. When a newer release is published, it will appear in Dashboard → Updates for an administrator to install.', 'rivross-corporate' ); ?></p>

		<?php if ( 'saved' === $status ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'The GitHub token was saved. Check Dashboard → Updates for the latest release.', 'rivross-corporate' ); ?></p></div>
		<?php elseif ( 'removed' === $status ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'The GitHub token was removed. Private theme update checks are now disabled.', 'rivross-corporate' ); ?></p></div>
		<?php elseif ( 'unchanged' === $status ) : ?>
			<div class="notice notice-info is-dismissible"><p><?php esc_html_e( 'No token was entered, so the saved token was left unchanged.', 'rivross-corporate' ); ?></p></div>
		<?php endif; ?>

		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><?php esc_html_e( 'Repository access', 'rivross-corporate' ); ?></th>
				<td>
					<?php if ( is_wp_error( $release ) ) : ?>
						<p><?php esc_html_e( 'GitHub could not return a published release. For a public repository, no token is needed; for a private repository, add a fine-grained token limited to this repository with Contents: Read-only.', 'rivross-corporate' ); ?></p>
					<?php else : ?>
						<p><?php echo esc_html( sprintf( __( 'Connected. Latest published release: %s', 'rivross-corporate' ), $release['tag'] ) ); ?></p>
					<?php endif; ?>
					<p><a href="https://github.com/settings/personal-access-tokens/new" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Create an optional fine-grained token for private repository access', 'rivross-corporate' ); ?></a></p>
				</td>
			</tr>
		</table>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="rivross_github_updater_save_token">
			<?php wp_nonce_field( 'rivross_github_updater_settings' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="rivross-github-token"><?php esc_html_e( 'Optional fine-grained token', 'rivross-corporate' ); ?></label></th>
					<td>
						<input id="rivross-github-token" name="github_token" type="password" class="regular-text" value="" autocomplete="new-password" spellcheck="false">
						<p class="description"><?php esc_html_e( 'The saved token is never displayed. Leave this field blank to keep the current token. Do not paste the token into chat or publish it in the theme repository.', 'rivross-corporate' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button( __( 'Save token', 'rivross-corporate' ), 'primary', 'save_token', false ); ?>
			<?php if ( $has_token && ! defined( 'RIVROSS_GITHUB_TOKEN' ) ) : ?>
				<button type="submit" name="remove_token" value="1" class="button button-secondary"><?php esc_html_e( 'Remove saved token', 'rivross-corporate' ); ?></button>
			<?php endif; ?>
		</form>

		<hr>
		<p><?php esc_html_e( 'Release process: push changes to main, update the theme version, then publish a GitHub Release with a matching vX.Y.Z tag. The release packaging action attaches rivross-corporate.zip; live content and the database are not part of the update package.', 'rivross-corporate' ); ?></p>
	</div>
	<?php
}
