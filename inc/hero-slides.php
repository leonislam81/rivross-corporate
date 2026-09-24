<?php
/**
 * Homepage Hero Slides content type and fields.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Register the editable homepage Hero Slides content type. */
function rivross_register_hero_slide_post_type() {
	$labels = array(
		'name'               => __( 'Hero Slides', 'rivross-corporate' ),
		'singular_name'      => __( 'Hero Slide', 'rivross-corporate' ),
		'menu_name'          => __( 'Hero Slides', 'rivross-corporate' ),
		'add_new'            => __( 'Add Hero Slide', 'rivross-corporate' ),
		'add_new_item'       => __( 'Add New Hero Slide', 'rivross-corporate' ),
		'edit_item'          => __( 'Edit Hero Slide', 'rivross-corporate' ),
		'new_item'           => __( 'New Hero Slide', 'rivross-corporate' ),
		'view_item'          => __( 'View Hero Slide', 'rivross-corporate' ),
		'search_items'      => __( 'Search Hero Slides', 'rivross-corporate' ),
		'not_found'          => __( 'No hero slides found.', 'rivross-corporate' ),
		'not_found_in_trash' => __( 'No hero slides found in Trash.', 'rivross-corporate' ),
	);
	register_post_type(
		'rivross_hero_slide',
		array(
			'labels'          => $labels,
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => true,
			'menu_icon'       => 'dashicons-images-alt2',
			'supports'        => array( 'title' ),
			'capability_type' => 'post',
			'map_meta_cap'    => true,
			'has_archive'     => false,
			'rewrite'         => false,
			'query_var'       => false,
		)
	);
}
add_action( 'init', 'rivross_register_hero_slide_post_type' );

/** Enqueue the WordPress media picker on Hero Slide edit screens. */
function rivross_hero_slide_admin_assets( $hook ) {
	$screen = get_current_screen();
	if ( ( 'post.php' === $hook || 'post-new.php' === $hook ) && $screen && 'rivross_hero_slide' === $screen->post_type ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'rivross_hero_slide_admin_assets' );

/** Add the editable Hero Slide fields panel. */
function rivross_add_hero_slide_meta_box() {
	add_meta_box(
		'rivross_hero_slide_details',
		__( 'Hero Slide Content', 'rivross-corporate' ),
		'rivross_render_hero_slide_meta_box',
		'rivross_hero_slide',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_rivross_hero_slide', 'rivross_add_hero_slide_meta_box' );

/** Render Hero Slide custom fields. */
function rivross_render_hero_slide_meta_box( $post ) {
	wp_nonce_field( 'rivross_save_hero_slide', 'rivross_hero_slide_nonce' );
	$fields = array(
		'kicker'          => get_post_meta( $post->ID, '_rivross_hero_kicker', true ),
		'line_1'          => get_post_meta( $post->ID, '_rivross_hero_line_1', true ),
		'line_2'          => get_post_meta( $post->ID, '_rivross_hero_line_2', true ),
		'description'     => get_post_meta( $post->ID, '_rivross_hero_description', true ),
		'primary_label'   => get_post_meta( $post->ID, '_rivross_hero_primary_label', true ),
		'primary_url'     => get_post_meta( $post->ID, '_rivross_hero_primary_url', true ),
		'secondary_label' => get_post_meta( $post->ID, '_rivross_hero_secondary_label', true ),
		'secondary_url'   => get_post_meta( $post->ID, '_rivross_hero_secondary_url', true ),
		'image'           => get_post_meta( $post->ID, '_rivross_hero_image', true ),
		'order'           => get_post_meta( $post->ID, '_rivross_hero_order', true ),
		'active'          => get_post_meta( $post->ID, '_rivross_hero_active', true ),
	);
	?>
	<p class="description"><?php esc_html_e( 'Each published slide appears on the homepage in Display Order. Keep the copy concise so it stays readable over the background image on mobile and desktop.', 'rivross-corporate' ); ?></p>
	<table class="form-table" role="presentation">
		<tr><th><label for="rivross_hero_kicker"><?php esc_html_e( 'Kicker / Eyebrow', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_hero_kicker" name="rivross_hero_kicker" value="<?php echo esc_attr( $fields['kicker'] ); ?>"></td></tr>
		<tr><th><label for="rivross_hero_line_1"><?php esc_html_e( 'Heading Line 1', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_hero_line_1" name="rivross_hero_line_1" value="<?php echo esc_attr( $fields['line_1'] ); ?>"></td></tr>
		<tr><th><label for="rivross_hero_line_2"><?php esc_html_e( 'Heading Line 2', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_hero_line_2" name="rivross_hero_line_2" value="<?php echo esc_attr( $fields['line_2'] ); ?>"></td></tr>
		<tr><th><label for="rivross_hero_description"><?php esc_html_e( 'Description', 'rivross-corporate' ); ?></label></th><td><textarea class="large-text" rows="4" id="rivross_hero_description" name="rivross_hero_description"><?php echo esc_textarea( $fields['description'] ); ?></textarea></td></tr>
		<tr><th><label for="rivross_hero_primary_label"><?php esc_html_e( 'Primary Button Label', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_hero_primary_label" name="rivross_hero_primary_label" value="<?php echo esc_attr( $fields['primary_label'] ); ?>"></td></tr>
		<tr><th><label for="rivross_hero_primary_url"><?php esc_html_e( 'Primary Button URL', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_hero_primary_url" name="rivross_hero_primary_url" value="<?php echo esc_attr( $fields['primary_url'] ); ?>" placeholder="#businesses or https://example.com"></td></tr>
		<tr><th><label for="rivross_hero_secondary_label"><?php esc_html_e( 'Secondary Button Label', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_hero_secondary_label" name="rivross_hero_secondary_label" value="<?php echo esc_attr( $fields['secondary_label'] ); ?>"></td></tr>
		<tr><th><label for="rivross_hero_secondary_url"><?php esc_html_e( 'Secondary Button URL', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_hero_secondary_url" name="rivross_hero_secondary_url" value="<?php echo esc_attr( $fields['secondary_url'] ); ?>" placeholder="#contact or https://example.com"></td></tr>
		<tr><th><label for="rivross_hero_image"><?php esc_html_e( 'Background Image', 'rivross-corporate' ); ?></label></th><td><input class="regular-text rivross-media-input" type="url" id="rivross_hero_image" name="rivross_hero_image" value="<?php echo esc_attr( $fields['image'] ); ?>"> <button type="button" class="button rivross-media-button" data-target="rivross_hero_image"><?php esc_html_e( 'Choose / Upload Image', 'rivross-corporate' ); ?></button> <button type="button" class="button rivross-media-clear" data-target="rivross_hero_image"><?php esc_html_e( 'Clear', 'rivross-corporate' ); ?></button><div class="rivross-media-preview" data-preview-for="rivross_hero_image" style="display:none;max-width:260px;margin-top:8px;"></div><p class="description"><?php esc_html_e( 'Choose a wide image from the Media Library or upload a new one.', 'rivross-corporate' ); ?></p></td></tr>
		<tr><th><label for="rivross_hero_order"><?php esc_html_e( 'Display Order', 'rivross-corporate' ); ?></label></th><td><input class="small-text" type="number" min="0" step="1" id="rivross_hero_order" name="rivross_hero_order" value="<?php echo esc_attr( $fields['order'] ); ?>"></td></tr>
	</table>
	<p><label><input type="checkbox" name="rivross_hero_active" value="1" <?php checked( '0' !== $fields['active'] ); ?>> <?php esc_html_e( 'Show this slide on the homepage', 'rivross-corporate' ); ?></label></p>
	<?php
}

/** Save Hero Slide custom fields. */
function rivross_save_hero_slide_meta( $post_id ) {
	if ( ! isset( $_POST['rivross_hero_slide_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rivross_hero_slide_nonce'] ) ), 'rivross_save_hero_slide' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$text_fields = array( 'kicker', 'line_1', 'line_2', 'primary_label', 'secondary_label' );
	foreach ( $text_fields as $key ) {
		$value = isset( $_POST['rivross_hero_' . $key] ) ? sanitize_text_field( wp_unslash( $_POST['rivross_hero_' . $key] ) ) : '';
		update_post_meta( $post_id, '_rivross_hero_' . $key, $value );
	}
	$description = isset( $_POST['rivross_hero_description'] ) ? sanitize_textarea_field( wp_unslash( $_POST['rivross_hero_description'] ) ) : '';
	$primary_url = isset( $_POST['rivross_hero_primary_url'] ) ? esc_url_raw( wp_unslash( $_POST['rivross_hero_primary_url'] ) ) : '';
	$secondary_url = isset( $_POST['rivross_hero_secondary_url'] ) ? esc_url_raw( wp_unslash( $_POST['rivross_hero_secondary_url'] ) ) : '';
	$image = isset( $_POST['rivross_hero_image'] ) ? esc_url_raw( wp_unslash( $_POST['rivross_hero_image'] ) ) : '';
	$order = isset( $_POST['rivross_hero_order'] ) ? absint( $_POST['rivross_hero_order'] ) : 0;
	$active = isset( $_POST['rivross_hero_active'] ) ? '1' : '0';
	update_post_meta( $post_id, '_rivross_hero_description', $description );
	update_post_meta( $post_id, '_rivross_hero_primary_url', $primary_url );
	update_post_meta( $post_id, '_rivross_hero_secondary_url', $secondary_url );
	update_post_meta( $post_id, '_rivross_hero_image', $image );
	update_post_meta( $post_id, '_rivross_hero_order', $order );
	update_post_meta( $post_id, '_rivross_hero_active', $active );
}
add_action( 'save_post_rivross_hero_slide', 'rivross_save_hero_slide_meta' );

/** Return published, active, ordered Hero Slides for the homepage. */
function rivross_get_hero_slides() {
	$posts = get_posts(
		array(
			'post_type'      => 'rivross_hero_slide',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array( 'meta_value_num' => 'ASC', 'date' => 'ASC' ),
			'meta_key'       => '_rivross_hero_order',
		)
	);
	$slides = array();
	foreach ( $posts as $post ) {
		if ( '0' === get_post_meta( $post->ID, '_rivross_hero_active', true ) ) {
			continue;
		}
		$image = get_post_meta( $post->ID, '_rivross_hero_image', true );
		if ( ! $image && has_post_thumbnail( $post ) ) {
			$image = get_the_post_thumbnail_url( $post, 'full' );
		}
		$slides[] = array(
			'id'              => $post->ID,
			'kicker'          => get_post_meta( $post->ID, '_rivross_hero_kicker', true ),
			'line_1'          => get_post_meta( $post->ID, '_rivross_hero_line_1', true ),
			'line_2'          => get_post_meta( $post->ID, '_rivross_hero_line_2', true ),
			'description'     => get_post_meta( $post->ID, '_rivross_hero_description', true ),
			'primary_label'   => get_post_meta( $post->ID, '_rivross_hero_primary_label', true ),
			'primary_url'     => get_post_meta( $post->ID, '_rivross_hero_primary_url', true ),
			'secondary_label' => get_post_meta( $post->ID, '_rivross_hero_secondary_label', true ),
			'secondary_url'   => get_post_meta( $post->ID, '_rivross_hero_secondary_url', true ),
			'image'           => $image,
		);
	}
	return $slides;
}

/** Seed a polished three-slide starting set once, without overwriting existing content. */
function rivross_seed_default_hero_slides() {
	if ( get_option( 'rivross_hero_slides_seeded' ) ) {
		return;
	}
	$count = wp_count_posts( 'rivross_hero_slide' );
	if ( $count && ( (int) $count->publish > 0 || (int) $count->draft > 0 || (int) $count->pending > 0 ) ) {
		update_option( 'rivross_hero_slides_seeded', 1 );
		return;
	}
	$image_uri = get_theme_file_uri( '/assets/images/' );
	$first_image = get_theme_mod( 'rivross_home_hero_image', $image_uri . 'home/hero-city.png' );
	if ( false !== strpos( (string) $first_image, 'hero-city-v2' ) ) {
		$first_image = $image_uri . 'home/hero-city.png';
	}
	$slides = array(
		array(
			'title'           => 'Building Businesses — Slide 1',
			'kicker'          => get_theme_mod( 'rivross_home_hero_kicker', __( 'RIVROSS Company Limited', 'rivross-corporate' ) ),
			'line_1'          => get_theme_mod( 'rivross_home_hero_line_1', __( 'Building Businesses.', 'rivross-corporate' ) ),
			'line_2'          => get_theme_mod( 'rivross_home_hero_line_2', __( 'Creating Opportunities.', 'rivross-corporate' ) ),
			'description'     => get_theme_mod( 'rivross_home_hero_description', __( 'RIVROSS Company Limited is a diversified business organization operating across Real Estate, Travel & Tourism, Tea Business and future business ventures.', 'rivross-corporate' ) ),
			'primary_label'   => get_theme_mod( 'rivross_home_hero_primary_label', __( 'Explore Our Businesses', 'rivross-corporate' ) ),
			'primary_url'     => get_theme_mod( 'rivross_home_hero_primary_url', '#businesses' ),
			'secondary_label' => get_theme_mod( 'rivross_home_hero_secondary_label', __( 'Contact Us', 'rivross-corporate' ) ),
			'secondary_url'   => get_theme_mod( 'rivross_home_hero_secondary_url', '#contact' ),
			'image'           => $first_image,
		),
		array(
			'title'           => 'One Vision — Slide 2',
			'kicker'          => 'RIVROSS Company Limited',
			'line_1'          => 'ONE VISION.',
			'line_2'          => 'MULTIPLE BUSINESSES.',
			'description'     => 'A growing business portfolio creating value across Real Estate, Travel & Tourism, Tea Business and future ventures.',
			'primary_label'   => 'Explore Our Companies',
			'primary_url'     => home_url( '/our-companies/' ),
			'secondary_label' => 'Contact Us',
			'secondary_url'   => '#contact',
			'image'           => $image_uri . 'companies/companies-hero.png',
		),
		array(
			'title'           => 'Create Opportunities — Slide 3',
			'kicker'          => 'RIVROSS Company Limited',
			'line_1'          => 'CREATE OPPORTUNITIES.',
			'line_2'          => 'GROW WITH CONFIDENCE.',
			'description'     => 'Partner with a professional team for dependable service, long-term relationships and sustainable growth.',
			'primary_label'   => 'Start a Conversation',
			'primary_url'     => '#contact',
			'secondary_label' => 'Our Services',
			'secondary_url'   => '#services',
			'image'           => $image_uri . 'contact/contact-hero.png',
		),
	);
	foreach ( $slides as $index => $slide ) {
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'rivross_hero_slide',
				'post_status' => 'publish',
				'post_title'  => $slide['title'],
			),
			true
		);
		if ( is_wp_error( $post_id ) ) {
			continue;
		}
		foreach ( array( 'kicker', 'line_1', 'line_2', 'description', 'primary_label', 'primary_url', 'secondary_label', 'secondary_url', 'image' ) as $key ) {
			update_post_meta( $post_id, '_rivross_hero_' . $key, $slide[ $key ] );
		}
		update_post_meta( $post_id, '_rivross_hero_order', $index + 1 );
		update_post_meta( $post_id, '_rivross_hero_active', '1' );
	}
	update_option( 'rivross_hero_slides_seeded', 1 );
}
add_action( 'init', 'rivross_seed_default_hero_slides', 30 );

/** Add a useful status column to the Hero Slides list. */
function rivross_hero_slide_columns( $columns ) {
	$columns['hero_order'] = __( 'Display Order', 'rivross-corporate' );
	$columns['hero_status'] = __( 'Homepage', 'rivross-corporate' );
	return $columns;
}
add_filter( 'manage_rivross_hero_slide_posts_columns', 'rivross_hero_slide_columns' );

function rivross_hero_slide_column_content( $column, $post_id ) {
	if ( 'hero_order' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_rivross_hero_order', true ) );
	} elseif ( 'hero_status' === $column ) {
		echo '0' === get_post_meta( $post_id, '_rivross_hero_active', true ) ? esc_html__( 'Hidden', 'rivross-corporate' ) : esc_html__( 'Visible', 'rivross-corporate' );
	}
}
add_action( 'manage_rivross_hero_slide_posts_custom_column', 'rivross_hero_slide_column_content', 10, 2 );
