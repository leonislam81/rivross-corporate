<?php
/**
 * Shared Leadership content and custom fields.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Register the shared Leadership content type. */
function rivross_register_leadership_post_type() {
	$labels = array(
		'name'               => __( 'Leadership', 'rivross-corporate' ),
		'singular_name'      => __( 'Leader', 'rivross-corporate' ),
		'menu_name'          => __( 'Leadership', 'rivross-corporate' ),
		'add_new'            => __( 'Add Leader', 'rivross-corporate' ),
		'add_new_item'       => __( 'Add New Leader', 'rivross-corporate' ),
		'edit_item'          => __( 'Edit Leader', 'rivross-corporate' ),
		'new_item'           => __( 'New Leader', 'rivross-corporate' ),
		'view_item'          => __( 'View Leader', 'rivross-corporate' ),
		'search_items'       => __( 'Search Leadership', 'rivross-corporate' ),
		'not_found'          => __( 'No leaders found.', 'rivross-corporate' ),
		'not_found_in_trash' => __( 'No leaders found in Trash.', 'rivross-corporate' ),
	);
	register_post_type(
		'rivross_leader',
		array(
			'labels'             => $labels,
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-groups',
			'supports'           => array( 'title', 'thumbnail' ),
			'capability_type'    => 'post',
			'map_meta_cap'       => true,
			'has_archive'       => false,
			'rewrite'            => false,
			'query_var'          => false,
		)
	);
}
add_action( 'init', 'rivross_register_leadership_post_type' );

/** Enqueue the WordPress media picker on Leader edit screens. */
function rivross_leadership_admin_assets( $hook ) {
	$screen = get_current_screen();
	if ( ( 'post.php' === $hook || 'post-new.php' === $hook ) && $screen && 'rivross_leader' === $screen->post_type ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'rivross_leadership_admin_assets' );

/** Add the editable Leader details panel. */
function rivross_add_leadership_meta_box() {
	add_meta_box(
		'rivross_leader_details',
		__( 'Leadership Details', 'rivross-corporate' ),
		'rivross_render_leadership_meta_box',
		'rivross_leader',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_rivross_leader', 'rivross_add_leadership_meta_box' );

/** Render custom Leader fields. */
function rivross_render_leadership_meta_box( $post ) {
	wp_nonce_field( 'rivross_save_leader', 'rivross_leader_nonce' );
	$fields = array(
		'role'        => get_post_meta( $post->ID, '_rivross_leader_role', true ),
		'department'  => get_post_meta( $post->ID, '_rivross_leader_department', true ),
		'bio'         => get_post_meta( $post->ID, '_rivross_leader_bio', true ),
		'linkedin'    => get_post_meta( $post->ID, '_rivross_leader_linkedin', true ),
		'facebook'    => get_post_meta( $post->ID, '_rivross_leader_facebook', true ),
		'email'       => get_post_meta( $post->ID, '_rivross_leader_email', true ),
		'whatsapp'    => get_post_meta( $post->ID, '_rivross_leader_whatsapp', true ),
		'image'       => get_post_meta( $post->ID, '_rivross_leader_image', true ),
		'order'       => get_post_meta( $post->ID, '_rivross_leader_order', true ),
		'home'        => get_post_meta( $post->ID, '_rivross_leader_home', true ),
		'about'       => get_post_meta( $post->ID, '_rivross_leader_about', true ),
		'management'  => get_post_meta( $post->ID, '_rivross_leader_management', true ),
	);
	?>
	<p class="description"><?php esc_html_e( 'The same leader data can appear on Home, About Us and Management. Use the visibility checkboxes to control each page.', 'rivross-corporate' ); ?></p>
	<table class="form-table" role="presentation">
		<tr><th><label for="rivross_leader_role"><?php esc_html_e( 'Primary Role', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_leader_role" name="rivross_leader_role" value="<?php echo esc_attr( $fields['role'] ); ?>"><p class="description"><?php esc_html_e( 'For example: Chairman or Managing Director.', 'rivross-corporate' ); ?></p></td></tr>
		<tr><th><label for="rivross_leader_department"><?php esc_html_e( 'Department / Role Line 2', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_leader_department" name="rivross_leader_department" value="<?php echo esc_attr( $fields['department'] ); ?>"></td></tr>
		<tr><th><label for="rivross_leader_bio"><?php esc_html_e( 'Short Biography', 'rivross-corporate' ); ?></label></th><td><textarea class="large-text" rows="4" id="rivross_leader_bio" name="rivross_leader_bio"><?php echo esc_textarea( $fields['bio'] ); ?></textarea></td></tr>
		<tr><th><label for="rivross_leader_linkedin"><?php esc_html_e( 'LinkedIn URL', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_leader_linkedin" name="rivross_leader_linkedin" value="<?php echo esc_attr( $fields['linkedin'] ); ?>" placeholder="linkedin.com/in/username"></td></tr>
		<tr><th><label for="rivross_leader_facebook"><?php esc_html_e( 'Facebook URL', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_leader_facebook" name="rivross_leader_facebook" value="<?php echo esc_attr( $fields['facebook'] ); ?>" placeholder="facebook.com/username"></td></tr>
		<tr><th><label for="rivross_leader_email"><?php esc_html_e( 'Email Address', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="email" id="rivross_leader_email" name="rivross_leader_email" value="<?php echo esc_attr( $fields['email'] ); ?>"></td></tr>
		<tr><th><label for="rivross_leader_whatsapp"><?php esc_html_e( 'WhatsApp URL', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_leader_whatsapp" name="rivross_leader_whatsapp" value="<?php echo esc_attr( $fields['whatsapp'] ); ?>" placeholder="wa.me/8801XXXXXXXXX"><p class="description"><?php esc_html_e( 'https:// is optional. Use a direct link such as wa.me/8801XXXXXXXXX, or use # as a placeholder.', 'rivross-corporate' ); ?></p></td></tr>
		<tr><th><label for="rivross_leader_image"><?php esc_html_e( 'Portrait Image', 'rivross-corporate' ); ?></label></th><td><input class="regular-text rivross-media-input" type="url" id="rivross_leader_image" name="rivross_leader_image" value="<?php echo esc_attr( $fields['image'] ); ?>"> <button type="button" class="button rivross-media-button" data-target="rivross_leader_image"><?php esc_html_e( 'Choose / Upload Image', 'rivross-corporate' ); ?></button> <button type="button" class="button rivross-media-clear" data-target="rivross_leader_image"><?php esc_html_e( 'Clear', 'rivross-corporate' ); ?></button><div class="rivross-media-preview" data-preview-for="rivross_leader_image" style="display:none;max-width:180px;margin-top:8px;"></div><p class="description"><?php esc_html_e( 'Choose a portrait from the Media Library or upload a new one. The Featured Image is also supported as a fallback.', 'rivross-corporate' ); ?></p></td></tr>
		<tr><th><label for="rivross_leader_order"><?php esc_html_e( 'Display Order', 'rivross-corporate' ); ?></label></th><td><input class="small-text" type="number" min="0" step="1" id="rivross_leader_order" name="rivross_leader_order" value="<?php echo esc_attr( $fields['order'] ); ?>"></td></tr>
	</table>
	<fieldset><legend class="screen-reader-text"><?php esc_html_e( 'Page visibility', 'rivross-corporate' ); ?></legend>
		<p><strong><?php esc_html_e( 'Show this leader on:', 'rivross-corporate' ); ?></strong></p>
		<label><input type="checkbox" name="rivross_leader_home" value="1" <?php checked( '1', $fields['home'] ); ?>> <?php esc_html_e( 'Home leadership section', 'rivross-corporate' ); ?></label><br>
		<label><input type="checkbox" name="rivross_leader_about" value="1" <?php checked( '1', $fields['about'] ); ?>> <?php esc_html_e( 'About Us leadership section', 'rivross-corporate' ); ?></label><br>
		<label><input type="checkbox" name="rivross_leader_management" value="1" <?php checked( '1', $fields['management'] ); ?>> <?php esc_html_e( 'Management page', 'rivross-corporate' ); ?></label>
	</fieldset>
	<?php
}

/** Save Leader custom fields. */
function rivross_save_leadership_meta( $post_id ) {
	if ( ! isset( $_POST['rivross_leader_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rivross_leader_nonce'] ) ), 'rivross_save_leader' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$text_fields = array( 'role' => 'sanitize_text_field', 'department' => 'sanitize_text_field', 'bio' => 'sanitize_textarea_field' );
	foreach ( $text_fields as $key => $sanitize ) {
		$value = isset( $_POST['rivross_leader_' . $key] ) ? call_user_func( $sanitize, wp_unslash( $_POST['rivross_leader_' . $key] ) ) : '';
		update_post_meta( $post_id, '_rivross_leader_' . $key, $value );
	}
	$url = isset( $_POST['rivross_leader_linkedin'] ) ? rivross_normalize_social_url( wp_unslash( $_POST['rivross_leader_linkedin'] ) ) : '';
	$facebook = isset( $_POST['rivross_leader_facebook'] ) ? rivross_normalize_social_url( wp_unslash( $_POST['rivross_leader_facebook'] ) ) : '';
	$email = isset( $_POST['rivross_leader_email'] ) ? sanitize_email( wp_unslash( $_POST['rivross_leader_email'] ) ) : '';
	$whatsapp = isset( $_POST['rivross_leader_whatsapp'] ) ? rivross_normalize_social_url( wp_unslash( $_POST['rivross_leader_whatsapp'] ) ) : '';
	$image = isset( $_POST['rivross_leader_image'] ) ? esc_url_raw( wp_unslash( $_POST['rivross_leader_image'] ) ) : '';
	$order = isset( $_POST['rivross_leader_order'] ) ? absint( $_POST['rivross_leader_order'] ) : 0;
	update_post_meta( $post_id, '_rivross_leader_linkedin', $url );
	update_post_meta( $post_id, '_rivross_leader_facebook', $facebook );
	update_post_meta( $post_id, '_rivross_leader_email', $email );
	update_post_meta( $post_id, '_rivross_leader_whatsapp', $whatsapp );
	update_post_meta( $post_id, '_rivross_leader_image', $image );
	update_post_meta( $post_id, '_rivross_leader_order', $order );
	foreach ( array( 'home', 'about', 'management' ) as $context ) {
		update_post_meta( $post_id, '_rivross_leader_' . $context, isset( $_POST['rivross_leader_' . $context] ) ? '1' : '0' );
	}
}
add_action( 'save_post_rivross_leader', 'rivross_save_leadership_meta' );

/** Accept a complete URL, a domain/path, or # as a harmless placeholder. */
function rivross_normalize_social_url( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value || '#' === $value ) {
		return $value;
	}
	if ( 0 === strpos( $value, '//' ) ) {
		$value = 'https:' . $value;
	} elseif ( ! preg_match( '#^[a-z][a-z0-9+.-]*://#i', $value ) ) {
		$value = 'https://' . $value;
	}
	return esc_url_raw( $value );
}

/** Return whether the site has published shared Leadership entries. */
function rivross_leadership_has_published_entries() {
	$counts = wp_count_posts( 'rivross_leader' );
	return $counts && isset( $counts->publish ) && (int) $counts->publish > 0;
}

/** Return a shared, ordered set of Leaders for a page context. */
function rivross_get_leaders( $context = 'management', $limit = 0 ) {
	$meta_key = '_rivross_leader_' . sanitize_key( $context );
	$args = array(
		'post_type'      => 'rivross_leader',
		'post_status'    => 'publish',
		'posts_per_page' => $limit > 0 ? absint( $limit ) : -1,
		'orderby'        => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),
		'meta_key'       => '_rivross_leader_order',
		'meta_query'     => array( array( 'key' => $meta_key, 'value' => '1', 'compare' => '=' ) ),
	);
	$posts = get_posts( $args );
	$leaders = array();
	foreach ( $posts as $post ) {
		$image = get_post_meta( $post->ID, '_rivross_leader_image', true );
		if ( ! $image && has_post_thumbnail( $post ) ) {
			$image = get_the_post_thumbnail_url( $post, 'large' );
		}
		$linkedin = rivross_normalize_social_url( get_post_meta( $post->ID, '_rivross_leader_linkedin', true ) );
		$facebook = rivross_normalize_social_url( get_post_meta( $post->ID, '_rivross_leader_facebook', true ) );
		$whatsapp = rivross_normalize_social_url( get_post_meta( $post->ID, '_rivross_leader_whatsapp', true ) );
		$leaders[] = array(
			'id'          => $post->ID,
			'name'        => get_the_title( $post ),
			'role'        => get_post_meta( $post->ID, '_rivross_leader_role', true ),
			'department'  => get_post_meta( $post->ID, '_rivross_leader_department', true ),
			'bio'         => get_post_meta( $post->ID, '_rivross_leader_bio', true ),
			'image'       => $image,
			'url'         => $linkedin,
			'socials'     => array(
				'linkedin' => $linkedin,
				'facebook' => $facebook,
				'email'    => get_post_meta( $post->ID, '_rivross_leader_email', true ),
				'whatsapp' => $whatsapp,
			),
		);
	}
	return $leaders;
}

/** Render only the social links that have been filled in for a Leader. */
function rivross_leadership_social_links( $socials, $name = '' ) {
	if ( ! is_array( $socials ) ) {
		return '';
	}
	$icons = array(
		'linkedin' => 'linkedin',
		'facebook' => 'facebook',
		'email'    => 'mail',
		'whatsapp' => 'whatsapp',
	);
	$labels = array(
		'linkedin' => __( 'LinkedIn', 'rivross-corporate' ),
		'facebook' => __( 'Facebook', 'rivross-corporate' ),
		'email'    => __( 'Email', 'rivross-corporate' ),
		'whatsapp' => __( 'WhatsApp', 'rivross-corporate' ),
	);
	$output = '';
	foreach ( $icons as $network => $icon ) {
		$value = isset( $socials[ $network ] ) ? trim( (string) $socials[ $network ] ) : '';
		if ( '' === $value ) {
			continue;
		}
		$is_email = 'email' === $network;
		if ( '#' === $value ) {
			$href = '#';
		} elseif ( $is_email ) {
			$value = sanitize_email( $value );
			if ( ! is_email( $value ) ) {
				continue;
			}
			$href = 'mailto:' . $value;
		} else {
			$href = esc_url( $value );
			if ( '' === $href ) {
				continue;
			}
		}
		$aria = $name ? sprintf( __( '%1$s on %2$s', 'rivross-corporate' ), $name, $labels[ $network ] ) : $labels[ $network ];
		$external = '#' !== $href && ! $is_email;
		$output .= '<a class="rivross-leader-social" href="' . esc_url( $href ) . '" aria-label="' . esc_attr( $aria ) . '"' . ( $external ? ' target="_blank" rel="noopener noreferrer"' : '' ) . '>' . rivross_icon( $icon ) . '</a>';
	}
	return '' !== $output ? '<div class="rivross-leader-socials">' . $output . '</div>' : '';
}

/** Add a useful image column to the Leadership list. */
function rivross_leadership_columns( $columns ) {
	$columns['leader_portrait'] = __( 'Portrait', 'rivross-corporate' );
	$columns['leader_role']     = __( 'Role', 'rivross-corporate' );
	$columns['leader_pages']    = __( 'Page Visibility', 'rivross-corporate' );
	return $columns;
}
add_filter( 'manage_rivross_leader_posts_columns', 'rivross_leadership_columns' );

function rivross_leadership_column_content( $column, $post_id ) {
	if ( 'leader_portrait' === $column ) {
		$url = get_post_meta( $post_id, '_rivross_leader_image', true );
		if ( $url ) {
			echo '<img src="' . esc_url( $url ) . '" alt="" style="width:42px;height:42px;object-fit:cover;border-radius:3px;">';
		}
	} elseif ( 'leader_role' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_rivross_leader_role', true ) );
	} elseif ( 'leader_pages' === $column ) {
		$pages = array();
		foreach ( array( 'home' => 'Home', 'about' => 'About', 'management' => 'Management' ) as $key => $label ) {
			if ( '1' === get_post_meta( $post_id, '_rivross_leader_' . $key, true ) ) {
				$pages[] = $label;
			}
		}
		echo esc_html( implode( ', ', $pages ) );
	}
}
add_action( 'manage_rivross_leader_posts_custom_column', 'rivross_leadership_column_content', 10, 2 );
