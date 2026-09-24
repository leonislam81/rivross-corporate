<?php
/**
 * RIVROSS Properties custom post type and property data helpers.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rivross_register_property_content() {
	register_post_type(
		'rivross_property',
		array(
			'labels' => array(
				'name' => __( 'Properties', 'rivross-corporate' ),
				'singular_name' => __( 'Property', 'rivross-corporate' ),
				'add_new_item' => __( 'Add New Property', 'rivross-corporate' ),
				'edit_item' => __( 'Edit Property', 'rivross-corporate' ),
				'new_item' => __( 'New Property', 'rivross-corporate' ),
				'view_item' => __( 'View Property', 'rivross-corporate' ),
				'search_items' => __( 'Search Properties', 'rivross-corporate' ),
			),
			'public' => true,
			'show_ui' => true,
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-building',
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'properties', 'with_front' => false ),
			'publicly_queryable' => true,
		)
	);

	register_taxonomy(
		'rivross_property_type',
		'rivross_property',
		array(
			'labels' => array( 'name' => __( 'Property Types', 'rivross-corporate' ), 'singular_name' => __( 'Property Type', 'rivross-corporate' ) ),
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_rest' => true,
			'public' => false,
		)
	);
}
add_action( 'init', 'rivross_register_property_content' );

function rivross_property_fields() {
	return array(
		'location' => array( 'label' => __( 'Location', 'rivross-corporate' ), 'type' => 'text' ),
		'developer' => array( 'label' => __( 'Developer', 'rivross-corporate' ), 'type' => 'text' ),
		'type' => array( 'label' => __( 'Property Type Label', 'rivross-corporate' ), 'type' => 'text' ),
		'size' => array( 'label' => __( 'Size / Area', 'rivross-corporate' ), 'type' => 'text' ),
		'bedrooms' => array( 'label' => __( 'Bedrooms', 'rivross-corporate' ), 'type' => 'text' ),
		'bathrooms' => array( 'label' => __( 'Bathrooms', 'rivross-corporate' ), 'type' => 'text' ),
		'parking' => array( 'label' => __( 'Parking', 'rivross-corporate' ), 'type' => 'text' ),
		'status' => array( 'label' => __( 'Project Status', 'rivross-corporate' ), 'type' => 'select', 'options' => array( 'Ongoing', 'Upcoming', 'Completed', 'Ready' ) ),
		'price' => array( 'label' => __( 'Price', 'rivross-corporate' ), 'type' => 'text' ),
		'price_value' => array( 'label' => __( 'Price Numeric Value (for sorting)', 'rivross-corporate' ), 'type' => 'number' ),
		'handover' => array( 'label' => __( 'Handover', 'rivross-corporate' ), 'type' => 'text' ),
		'image' => array( 'label' => __( 'Property Image', 'rivross-corporate' ), 'type' => 'url' ),
		'gallery' => array( 'label' => __( 'Gallery Images', 'rivross-corporate' ), 'type' => 'textarea' ),
		'map_url' => array( 'label' => __( 'Map Location URL', 'rivross-corporate' ), 'type' => 'url' ),
		'brochure_url' => array( 'label' => __( 'Brochure Download URL', 'rivross-corporate' ), 'type' => 'url' ),
		'inquiry_url' => array( 'label' => __( 'Contact / Inquiry URL', 'rivross-corporate' ), 'type' => 'url' ),
	);
}

function rivross_property_meta( $property_id, $field, $default = '' ) {
	$value = get_post_meta( $property_id, '_rivross_property_' . $field, true );
	return '' !== $value ? $value : $default;
}

function rivross_property_image_url( $property_id ) {
	$image = get_the_post_thumbnail_url( $property_id, 'large' );
	if ( $image ) { return $image; }
	$image = rivross_property_meta( $property_id, 'image' );
	return $image ? esc_url( $image ) : get_theme_file_uri( '/assets/images/real-estate/real-estate-hero.png' );
}

function rivross_property_meta_box() {
	add_meta_box( 'rivross_property_details', __( 'Property Details', 'rivross-corporate' ), 'rivross_render_property_meta_box', 'rivross_property', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'rivross_property_meta_box' );

function rivross_render_property_meta_box( $post ) {
	wp_nonce_field( 'rivross_save_property', 'rivross_property_nonce' );
	$fields = rivross_property_fields();
	echo '<p class="description">' . esc_html__( 'These fields power the property cards, filters and individual details page. Use the Featured Image panel for the primary image, or use the image buttons below to choose from the Media Library or upload new images. Gallery images stay one URL per line.', 'rivross-corporate' ) . '</p>';
	echo '<table class="form-table"><tbody>';
	foreach ( $fields as $key => $field ) {
		$value = rivross_property_meta( $post->ID, $key );
		echo '<tr><th><label for="rivross_property_' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label></th><td>';
		if ( 'select' === $field['type'] ) {
			echo '<select class="regular-text" id="rivross_property_' . esc_attr( $key ) . '" name="rivross_property_' . esc_attr( $key ) . '">';
			foreach ( $field['options'] as $option ) {
				echo '<option value="' . esc_attr( $option ) . '" ' . selected( $value, $option, false ) . '>' . esc_html( $option ) . '</option>';
			}
			echo '</select>';
		} elseif ( 'textarea' === $field['type'] ) {
			if ( 'gallery' === $key ) {
				echo '<textarea class="large-text rivross-media-input rivross-media-gallery" rows="3" id="rivross_property_' . esc_attr( $key ) . '" name="rivross_property_' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea><p><button type="button" class="button rivross-media-button" data-target="rivross_property_' . esc_attr( $key ) . '" data-multiple="1">' . esc_html__( 'Choose / Upload Images', 'rivross-corporate' ) . '</button> <button type="button" class="button rivross-media-clear" data-target="rivross_property_' . esc_attr( $key ) . '">' . esc_html__( 'Clear Gallery', 'rivross-corporate' ) . '</button></p><div class="rivross-media-preview" data-preview-for="rivross_property_' . esc_attr( $key ) . '" style="display:none;max-width:600px;margin-top:8px;"></div><p class="description">' . esc_html__( 'Select multiple images from the Media Library or upload new ones. A thumbnail preview appears here, and one image URL is kept per line.', 'rivross-corporate' ) . '</p>';
			} else {
				echo '<textarea class="large-text" rows="3" id="rivross_property_' . esc_attr( $key ) . '" name="rivross_property_' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea>';
			}
		} else {
			if ( 'image' === $key ) {
				echo '<input class="regular-text rivross-media-input" type="url" id="rivross_property_' . esc_attr( $key ) . '" name="rivross_property_' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"> <button type="button" class="button rivross-media-button" data-target="rivross_property_' . esc_attr( $key ) . '">' . esc_html__( 'Choose / Upload Image', 'rivross-corporate' ) . '</button> <button type="button" class="button rivross-media-clear" data-target="rivross_property_' . esc_attr( $key ) . '">' . esc_html__( 'Clear', 'rivross-corporate' ) . '</button><div class="rivross-media-preview" data-preview-for="rivross_property_' . esc_attr( $key ) . '" style="display:none;max-width:180px;margin-top:8px;"></div>';
			} else {
				$number_attrs = 'number' === $field['type'] ? ' min="0" step="any" inputmode="decimal"' : '';
				echo '<input class="regular-text" type="' . esc_attr( $field['type'] ) . '" id="rivross_property_' . esc_attr( $key ) . '" name="rivross_property_' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"' . $number_attrs . '>';
			}
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

function rivross_save_property_meta( $post_id ) {
	if ( ! isset( $_POST['rivross_property_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rivross_property_nonce'] ) ), 'rivross_save_property' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
	foreach ( rivross_property_fields() as $key => $field ) {
		if ( ! isset( $_POST['rivross_property_' . $key] ) ) { continue; }
		$raw = wp_unslash( $_POST['rivross_property_' . $key] );
		if ( 'number' === $field['type'] ) {
			$value = is_numeric( $raw ) ? max( 0, (float) $raw ) : '';
			$value = '' !== $value ? (string) $value : '';
		} elseif ( 'select' === $field['type'] ) {
			$value = in_array( $raw, $field['options'], true ) ? $raw : '';
		} else {
			$value = 'url' === $field['type'] ? esc_url_raw( $raw ) : ( 'textarea' === $field['type'] ? ( 'gallery' === $key ? rivross_sanitize_gallery_urls( $raw ) : sanitize_textarea_field( $raw ) ) : sanitize_text_field( $raw ) );
		}
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_rivross_property_' . $key );
		} else {
			update_post_meta( $post_id, '_rivross_property_' . $key, $value );
		}
	}
}
add_action( 'save_post_rivross_property', 'rivross_save_property_meta' );

/** Add the most useful property fields to the dashboard list view. */
function rivross_property_admin_columns( $columns ) {
	$columns['property_location'] = __( 'Location', 'rivross-corporate' );
	$columns['property_status']   = __( 'Status', 'rivross-corporate' );
	$columns['property_price']    = __( 'Price', 'rivross-corporate' );
	return $columns;
}
add_filter( 'manage_rivross_property_posts_columns', 'rivross_property_admin_columns' );

function rivross_property_admin_column_content( $column, $post_id ) {
	if ( 'property_location' === $column ) {
		echo esc_html( rivross_property_meta( $post_id, 'location' ) );
	} elseif ( 'property_status' === $column ) {
		echo esc_html( rivross_property_meta( $post_id, 'status' ) );
	} elseif ( 'property_price' === $column ) {
		echo esc_html( rivross_property_meta( $post_id, 'price' ) );
	}
}
add_action( 'manage_rivross_property_posts_custom_column', 'rivross_property_admin_column_content', 10, 2 );

function rivross_seed_properties() {
	if ( get_option( 'rivross_properties_seeded' ) ) { return; }
	$terms = array( 'Apartment', 'Commercial', 'Land / Plot' );
	foreach ( $terms as $term ) {
		if ( ! term_exists( $term, 'rivross_property_type' ) ) { wp_insert_term( $term, 'rivross_property_type' ); }
	}
	$asset = get_theme_file_uri( '/assets/images/' );
	$properties = array(
		array( 'slug' => 'rivross-lake-view-residence', 'title' => 'Rivross Lake View Residence', 'type' => 'Apartment', 'location' => 'Uttara, Dhaka', 'developer' => 'RIVROSS Developments', 'size' => '1450 sq.ft', 'bedrooms' => '3', 'bathrooms' => '3', 'parking' => '1 Parking', 'status' => 'Ongoing', 'price' => 'BDT 6,500 /sqft', 'price_value' => 6500, 'handover' => 'December 2026', 'image' => $asset . 'home/business-real-estate.png', 'excerpt' => 'Contemporary waterfront residences designed for comfortable family living in Uttara.', 'content' => 'Rivross Lake View Residence brings thoughtful planning, open views and dependable construction together in one of Uttara\'s most connected neighbourhoods.' ),
		array( 'slug' => 'rivross-green-heights', 'title' => 'Rivross Green Heights', 'type' => 'Apartment', 'location' => 'Bashundhara, Dhaka', 'developer' => 'RIVROSS Developments', 'size' => '1320 sq.ft', 'bedrooms' => '3', 'bathrooms' => '2', 'parking' => '1 Parking', 'status' => 'Ongoing', 'price' => 'BDT 7,200 /sqft', 'price_value' => 7200, 'handover' => 'June 2027', 'image' => $asset . 'real-estate/green-heights.png', 'excerpt' => 'A light-filled residential address with landscaped amenities and practical family layouts.', 'content' => 'Green Heights is planned around quiet courtyards, efficient apartment layouts and a community-first living experience in Bashundhara.' ),
		array( 'slug' => 'rivross-corporate-tower', 'title' => 'Rivross Corporate Tower', 'type' => 'Commercial', 'location' => 'Gulshan, Dhaka', 'developer' => 'RIVROSS Commercial', 'size' => '2500 sq.ft', 'bedrooms' => 'Office', 'bathrooms' => 'N/A', 'parking' => '2 Parking', 'status' => 'Completed', 'price' => 'BDT 18,000 /sqft', 'price_value' => 18000, 'handover' => 'Completed 2025', 'image' => $asset . 'real-estate/corporate-tower.png', 'excerpt' => 'A premium commercial destination for ambitious businesses in Gulshan.', 'content' => 'Rivross Corporate Tower offers a polished business address, flexible floor plates and strong access to Dhaka\'s commercial core.' ),
		array( 'slug' => 'rivross-heights', 'title' => 'Rivross Heights', 'type' => 'Apartment', 'location' => 'Bashundhara, Dhaka', 'developer' => 'RIVROSS Developments', 'size' => '1600 sq.ft', 'bedrooms' => '3', 'bathrooms' => '3', 'parking' => '1 Parking', 'status' => 'Ongoing', 'price' => 'BDT 8,400 /sqft', 'price_value' => 8400, 'handover' => 'December 2026', 'image' => $asset . 'companies/business-real-estate.png', 'excerpt' => 'Spacious residences with refined finishes and a strong sense of place.', 'content' => 'Rivross Heights combines generous living spaces, modern amenities and a carefully managed handover journey.' ),
		array( 'slug' => 'rivross-city-center', 'title' => 'Rivross City Center', 'type' => 'Commercial', 'location' => 'Mirpur, Dhaka', 'developer' => 'RIVROSS Commercial', 'size' => '1800 sq.ft', 'bedrooms' => 'Office', 'bathrooms' => 'N/A', 'parking' => '2 Parking', 'status' => 'Ongoing', 'price' => 'BDT 12,500 /sqft', 'price_value' => 12500, 'handover' => 'June 2027', 'image' => $asset . 'companies/companies-hero.png', 'excerpt' => 'A connected mixed-use commercial address for growing enterprises.', 'content' => 'Rivross City Center creates a practical, visible and well-connected base for businesses in Mirpur.' ),
		array( 'slug' => 'rivross-premium-plots', 'title' => 'Rivross Premium Plots', 'type' => 'Land / Plot', 'location' => 'Purbachal, Dhaka', 'developer' => 'RIVROSS Land & Development', 'size' => '5 katha', 'bedrooms' => 'N/A', 'bathrooms' => 'N/A', 'parking' => '30 ft Road', 'status' => 'Ready', 'price' => 'BDT 4,500 /sqft', 'price_value' => 4500, 'handover' => 'Ready for registration', 'image' => $asset . 'real-estate/premium-plots.png', 'excerpt' => 'Ready plots in a planned neighbourhood with wide roads and green surroundings.', 'content' => 'Rivross Premium Plots gives families and investors a clear path to land ownership in the growing Purbachal corridor.' ),
	);
	foreach ( $properties as $property ) {
		$existing = get_page_by_path( $property['slug'], OBJECT, 'rivross_property' );
		if ( $existing ) { continue; }
		$post_id = wp_insert_post( array( 'post_type' => 'rivross_property', 'post_status' => 'publish', 'post_title' => $property['title'], 'post_name' => $property['slug'], 'post_excerpt' => $property['excerpt'], 'post_content' => $property['content'] ) );
		if ( ! $post_id || is_wp_error( $post_id ) ) { continue; }
		wp_set_object_terms( $post_id, $property['type'], 'rivross_property_type' );
		foreach ( $property as $key => $value ) {
			if ( in_array( $key, array( 'slug', 'title', 'type', 'excerpt', 'content' ), true ) ) { continue; }
			update_post_meta( $post_id, '_rivross_property_' . $key, $value );
		}
		update_post_meta( $post_id, '_rivross_property_gallery', implode( "\n", array( $property['image'], $property['image'] ) ) );
	}
	if ( ! get_page_by_path( 'real-estate' ) ) {
		wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Real Estate', 'post_name' => 'real-estate' ) );
	}
	update_option( 'rivross_properties_seeded', 1 );
}
add_action( 'init', 'rivross_seed_properties', 30 );

function rivross_property_flush_rewrite_rules() {
	rivross_register_property_content();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'rivross_property_flush_rewrite_rules' );
