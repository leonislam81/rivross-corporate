<?php
/**
 * Seed the bundled partner marks into the WordPress Media Library.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the bundled partner-logo files and their stable media identifiers.
 *
 * @return array<int,array<string,string>>
 */
function rivross_partner_logo_demo_files() {
	$files = array();
	for ( $index = 1; $index <= 5; $index++ ) {
		$filename        = sprintf( 'partner-logo-%02d.png', $index );
		$files[ $index ] = array(
			'filename' => $filename,
			'path'     => get_theme_file_path( '/assets/images/home/' . $filename ),
			'title'    => sprintf( __( 'RIVROSS Partner Logo %d', 'rivross-corporate' ), $index ),
		);
	}

	return $files;
}

/**
 * Find an already-seeded demo attachment by its stable filename marker.
 *
 * @param string $filename Demo filename.
 * @return int
 */
function rivross_find_partner_logo_attachment( $filename ) {
	$attachments = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'meta_key'       => '_rivross_partner_logo_demo',
			'meta_value'     => $filename,
		)
	);

	return ! empty( $attachments ) ? absint( $attachments[0] ) : 0;
}

/**
 * Import bundled demo logos into uploads once per theme version.
 *
 * The admin-init hook also covers sites where the theme files are updated
 * without switching themes, which is common during local development.
 *
 * @return void
 */
function rivross_seed_partner_logo_media() {
	if ( ! current_user_can( 'upload_files' ) ) {
		return;
	}

	$stored_ids    = get_option( 'rivross_partner_logo_attachment_ids', array() );
	$stored_ids    = is_array( $stored_ids ) ? $stored_ids : array();
	$seeded_version = (string) get_option( 'rivross_partner_logo_media_version', '' );
	if ( RIVROSS_THEME_VERSION === $seeded_version && count( $stored_ids ) >= 5 ) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$changed = false;
	$complete = true;
	foreach ( rivross_partner_logo_demo_files() as $index => $demo ) {
		$attachment_id = isset( $stored_ids[ $index ] ) ? absint( $stored_ids[ $index ] ) : 0;
		if ( $attachment_id && 'attachment' !== get_post_type( $attachment_id ) ) {
			$attachment_id = 0;
		}
		if ( ! $attachment_id ) {
			$attachment_id = rivross_find_partner_logo_attachment( $demo['filename'] );
		}

		if ( ! $attachment_id && file_exists( $demo['path'] ) ) {
			$tmp_file = wp_tempnam( $demo['filename'] );
			if ( $tmp_file && copy( $demo['path'], $tmp_file ) ) {
				$attachment_id = media_handle_sideload(
					array(
						'name'     => $demo['filename'],
						'type'     => 'image/png',
						'tmp_name' => $tmp_file,
						'error'    => 0,
						'size'     => filesize( $tmp_file ),
					),
					0,
					$demo['title'],
					array(
						'post_title'   => $demo['title'],
						'post_excerpt' => __( 'Bundled RIVROSS partner logo demo mark.', 'rivross-corporate' ),
					)
				);
				if ( is_wp_error( $attachment_id ) ) {
					$attachment_id = 0;
				}
			}
		}

		if ( $attachment_id ) {
			update_post_meta( $attachment_id, '_rivross_partner_logo_demo', $demo['filename'] );
			if ( ! isset( $stored_ids[ $index ] ) || absint( $stored_ids[ $index ] ) !== $attachment_id ) {
				$stored_ids[ $index ] = $attachment_id;
				$changed              = true;
			}
		} else {
			$complete = false;
		}
	}

	if ( $changed ) {
		ksort( $stored_ids );
		update_option( 'rivross_partner_logo_attachment_ids', $stored_ids, false );
	}
	if ( $complete ) {
		update_option( 'rivross_partner_logo_media_version', RIVROSS_THEME_VERSION, false );
	}
}
add_action( 'after_switch_theme', 'rivross_seed_partner_logo_media', 25 );
add_action( 'admin_init', 'rivross_seed_partner_logo_media', 30 );

/**
 * Return default partner-logo URLs, preferring Media Library attachments.
 *
 * @return array<int,string>
 */
function rivross_get_partner_logo_default_urls() {
	static $urls = null;
	if ( null !== $urls ) {
		return $urls;
	}

	$urls       = array();
	$stored_ids = get_option( 'rivross_partner_logo_attachment_ids', array() );
	$stored_ids = is_array( $stored_ids ) ? $stored_ids : array();
	foreach ( rivross_partner_logo_demo_files() as $index => $demo ) {
		$attachment_id = isset( $stored_ids[ $index ] ) ? absint( $stored_ids[ $index ] ) : 0;
		$url           = $attachment_id ? wp_get_attachment_image_url( $attachment_id, 'full' ) : '';
		if ( ! $url ) {
			$url = get_theme_file_uri( '/assets/images/home/' . $demo['filename'] );
		}
		if ( $url ) {
			$urls[ $index ] = $url;
		}
	}

	return $urls;
}
