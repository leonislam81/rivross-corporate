<?php
/**
 * RIVROSS Projects custom post type and seeded showcase content.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rivross_register_project_content() {
	register_post_type( 'rivross_project', array(
		'labels' => array(
			'name' => __( 'Projects', 'rivross-corporate' ),
			'singular_name' => __( 'Project', 'rivross-corporate' ),
			'add_new_item' => __( 'Add New Project', 'rivross-corporate' ),
			'edit_item' => __( 'Edit Project', 'rivross-corporate' ),
			'new_item' => __( 'New Project', 'rivross-corporate' ),
			'view_item' => __( 'View Project', 'rivross-corporate' ),
			'search_items' => __( 'Search Projects', 'rivross-corporate' ),
		),
		'public' => true,
		'show_ui' => true,
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-admin-multisite',
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'has_archive' => false,
		'rewrite' => array( 'slug' => 'projects', 'with_front' => false ),
		'publicly_queryable' => true,
	) );
	register_taxonomy( 'rivross_project_type', 'rivross_project', array(
		'labels' => array( 'name' => __( 'Project Types', 'rivross-corporate' ), 'singular_name' => __( 'Project Type', 'rivross-corporate' ) ),
		'hierarchical' => true,
		'show_ui' => true,
		'show_in_rest' => true,
		'public' => false,
	) );
}
add_action( 'init', 'rivross_register_project_content' );

function rivross_project_fields() {
	return array(
		'location' => array( 'label' => __( 'Location', 'rivross-corporate' ), 'type' => 'text' ),
		'developer' => array( 'label' => __( 'Developer / Partner', 'rivross-corporate' ), 'type' => 'text' ),
		'type' => array( 'label' => __( 'Project Type Label', 'rivross-corporate' ), 'type' => 'text' ),
		'size' => array( 'label' => __( 'Size / Area', 'rivross-corporate' ), 'type' => 'text' ),
		'bedrooms' => array( 'label' => __( 'Bedrooms / Space', 'rivross-corporate' ), 'type' => 'text' ),
		'parking' => array( 'label' => __( 'Parking / Road', 'rivross-corporate' ), 'type' => 'text' ),
		'status' => array( 'label' => __( 'Project Status', 'rivross-corporate' ), 'type' => 'select', 'options' => array( 'Ongoing', 'Upcoming', 'Completed' ) ),
		'price' => array( 'label' => __( 'Price', 'rivross-corporate' ), 'type' => 'text' ),
		'timeline' => array( 'label' => __( 'Launch / Completion', 'rivross-corporate' ), 'type' => 'text' ),
		'image' => array( 'label' => __( 'Project Image', 'rivross-corporate' ), 'type' => 'url' ),
		'gallery' => array( 'label' => __( 'Gallery Images', 'rivross-corporate' ), 'type' => 'textarea' ),
		'map_url' => array( 'label' => __( 'Map Location URL', 'rivross-corporate' ), 'type' => 'url' ),
		'brochure_url' => array( 'label' => __( 'Brochure Download URL', 'rivross-corporate' ), 'type' => 'url' ),
		'inquiry_url' => array( 'label' => __( 'Contact / Inquiry URL', 'rivross-corporate' ), 'type' => 'url' ),
	);
}

function rivross_project_meta( $project_id, $field, $default = '' ) {
	$value = get_post_meta( $project_id, '_rivross_project_' . $field, true );
	return '' !== $value ? $value : $default;
}

function rivross_project_image_url( $project_id ) {
	$image = get_the_post_thumbnail_url( $project_id, 'large' );
	if ( $image ) { return $image; }
	$image = rivross_project_meta( $project_id, 'image' );
	return $image ? esc_url( $image ) : get_theme_file_uri( '/assets/images/projects/projects-hero.png' );
}

function rivross_project_add_meta_box() {
	add_meta_box( 'rivross_project_details', __( 'Project Details', 'rivross-corporate' ), 'rivross_project_meta_box_html', 'rivross_project', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'rivross_project_add_meta_box' );

function rivross_project_meta_box_html( $post ) {
	wp_nonce_field( 'rivross_save_project', 'rivross_project_nonce' );
	echo '<p class="description">' . esc_html__( 'These fields power the project status sections, cards and details page. Use the Featured Image panel for the primary image, or use the image buttons below to choose from the Media Library or upload new images. Gallery images stay one URL per line.', 'rivross-corporate' ) . '</p><table class="form-table"><tbody>';
	foreach ( rivross_project_fields() as $key => $field ) {
		$value = rivross_project_meta( $post->ID, $key );
		echo '<tr><th><label for="rivross_project_' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label></th><td>';
		if ( 'select' === $field['type'] ) {
			echo '<select class="regular-text" id="rivross_project_' . esc_attr( $key ) . '" name="rivross_project_' . esc_attr( $key ) . '">';
			foreach ( $field['options'] as $option ) { echo '<option value="' . esc_attr( $option ) . '" ' . selected( $value, $option, false ) . '>' . esc_html( $option ) . '</option>'; }
			echo '</select>';
		} elseif ( 'textarea' === $field['type'] ) {
			if ( 'gallery' === $key ) {
				echo '<textarea class="large-text rivross-media-input rivross-media-gallery" rows="3" id="rivross_project_' . esc_attr( $key ) . '" name="rivross_project_' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea><p><button type="button" class="button rivross-media-button" data-target="rivross_project_' . esc_attr( $key ) . '" data-multiple="1">' . esc_html__( 'Choose / Upload Images', 'rivross-corporate' ) . '</button> <button type="button" class="button rivross-media-clear" data-target="rivross_project_' . esc_attr( $key ) . '">' . esc_html__( 'Clear Gallery', 'rivross-corporate' ) . '</button></p><div class="rivross-media-preview" data-preview-for="rivross_project_' . esc_attr( $key ) . '" style="display:none;max-width:600px;margin-top:8px;"></div><p class="description">' . esc_html__( 'Select multiple images from the Media Library or upload new ones. A thumbnail preview appears here, and one image URL is kept per line.', 'rivross-corporate' ) . '</p>';
			} else {
				echo '<textarea class="large-text" rows="3" id="rivross_project_' . esc_attr( $key ) . '" name="rivross_project_' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea>';
			}
		} else {
			if ( 'image' === $key ) {
				echo '<input class="regular-text rivross-media-input" type="url" id="rivross_project_' . esc_attr( $key ) . '" name="rivross_project_' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"> <button type="button" class="button rivross-media-button" data-target="rivross_project_' . esc_attr( $key ) . '">' . esc_html__( 'Choose / Upload Image', 'rivross-corporate' ) . '</button> <button type="button" class="button rivross-media-clear" data-target="rivross_project_' . esc_attr( $key ) . '">' . esc_html__( 'Clear', 'rivross-corporate' ) . '</button><div class="rivross-media-preview" data-preview-for="rivross_project_' . esc_attr( $key ) . '" style="display:none;max-width:180px;margin-top:8px;"></div>';
			} else {
				$number_attrs = 'number' === $field['type'] ? ' min="0" step="any" inputmode="decimal"' : '';
				echo '<input class="regular-text" type="' . esc_attr( $field['type'] ) . '" id="rivross_project_' . esc_attr( $key ) . '" name="rivross_project_' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"' . $number_attrs . '>';
			}
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

function rivross_project_save_meta( $post_id ) {
	if ( ! isset( $_POST['rivross_project_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rivross_project_nonce'] ) ), 'rivross_save_project' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
	foreach ( rivross_project_fields() as $key => $field ) {
		$name = 'rivross_project_' . $key;
		if ( ! isset( $_POST[ $name ] ) ) { continue; }
		$raw = wp_unslash( $_POST[ $name ] );
		if ( 'select' === $field['type'] ) {
			$value = in_array( $raw, $field['options'], true ) ? $raw : '';
		} else {
			$value = 'url' === $field['type'] ? esc_url_raw( $raw ) : ( 'textarea' === $field['type'] ? ( 'gallery' === $key ? rivross_sanitize_gallery_urls( $raw ) : sanitize_textarea_field( $raw ) ) : sanitize_text_field( $raw ) );
		}
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_rivross_project_' . $key );
		} else {
			update_post_meta( $post_id, '_rivross_project_' . $key, $value );
		}
	}
}
add_action( 'save_post_rivross_project', 'rivross_project_save_meta' );

/** Add the most useful project fields to the dashboard list view. */
function rivross_project_admin_columns( $columns ) {
	$columns['project_location'] = __( 'Location', 'rivross-corporate' );
	$columns['project_status']   = __( 'Status', 'rivross-corporate' );
	$columns['project_type']     = __( 'Type', 'rivross-corporate' );
	return $columns;
}
add_filter( 'manage_rivross_project_posts_columns', 'rivross_project_admin_columns' );

function rivross_project_admin_column_content( $column, $post_id ) {
	if ( 'project_location' === $column ) {
		echo esc_html( rivross_project_meta( $post_id, 'location' ) );
	} elseif ( 'project_status' === $column ) {
		echo esc_html( rivross_project_meta( $post_id, 'status' ) );
	} elseif ( 'project_type' === $column ) {
		echo esc_html( rivross_project_meta( $post_id, 'type' ) );
	}
}
add_action( 'manage_rivross_project_posts_custom_column', 'rivross_project_admin_column_content', 10, 2 );

function rivross_seed_projects() {
	if ( get_option( 'rivross_projects_seeded' ) ) { return; }
	foreach ( array( 'Residential', 'Commercial', 'Land / Plot', 'Resort' ) as $term ) {
		if ( ! term_exists( $term, 'rivross_project_type' ) ) { wp_insert_term( $term, 'rivross_project_type' ); }
	}
	$asset = get_theme_file_uri( '/assets/images/' );
	$projects = array(
		array( 'slug' => 'rivross-lake-view-residence-project', 'title' => 'Rivross Lake View Residence', 'type' => 'Residential', 'location' => 'Uttara, Dhaka', 'developer' => 'RIVROSS Developments', 'size' => '1450 sq.ft', 'bedrooms' => '3 Bed', 'parking' => '1 Parking', 'status' => 'Ongoing', 'price' => 'BDT 6,500 /sqft', 'timeline' => 'Handover: Dec 2026', 'image' => $asset . 'home/business-real-estate.png', 'excerpt' => 'Contemporary waterfront residences designed for comfortable family living.', 'content' => 'Rivross Lake View Residence brings thoughtful planning, open views and dependable construction together in Uttara.' ),
		array( 'slug' => 'rivross-green-heights-project', 'title' => 'Rivross Green Heights', 'type' => 'Residential', 'location' => 'Bashundhara, Dhaka', 'developer' => 'RIVROSS Developments', 'size' => '1320 sq.ft', 'bedrooms' => '3 Bed', 'parking' => '1 Parking', 'status' => 'Ongoing', 'price' => 'BDT 7,200 /sqft', 'timeline' => 'Handover: Jun 2027', 'image' => $asset . 'real-estate/green-heights.png', 'excerpt' => 'A light-filled residential address with landscaped amenities.', 'content' => 'Green Heights is planned around quiet courtyards, efficient apartment layouts and a community-first living experience.' ),
		array( 'slug' => 'rivross-corporate-tower-project', 'title' => 'Rivross Corporate Tower', 'type' => 'Commercial', 'location' => 'Gulshan, Dhaka', 'developer' => 'RIVROSS Commercial', 'size' => '2500 sq.ft', 'bedrooms' => 'Office Space', 'parking' => '2 Parking', 'status' => 'Ongoing', 'price' => 'BDT 18,000 /sqft', 'timeline' => 'Handover: Dec 2026', 'image' => $asset . 'real-estate/corporate-tower.png', 'excerpt' => 'A premium commercial destination for ambitious businesses.', 'content' => 'Rivross Corporate Tower offers a polished business address, flexible floor plates and strong access to Dhaka\'s commercial core.' ),
		array( 'slug' => 'rivross-premium-plots-project', 'title' => 'Rivross Premium Plots', 'type' => 'Land / Plot', 'location' => 'Purbachal, Dhaka', 'developer' => 'RIVROSS Land & Development', 'size' => '5 Katha', 'bedrooms' => 'Road: 30 ft', 'parking' => 'Ready', 'status' => 'Ongoing', 'price' => 'BDT 4,500 /sqft', 'timeline' => 'Ready for registration', 'image' => $asset . 'real-estate/premium-plots.png', 'excerpt' => 'Ready plots in a planned neighbourhood with wide roads and green surroundings.', 'content' => 'Rivross Premium Plots gives families and investors a clear path to land ownership in Purbachal.' ),
		array( 'slug' => 'rivross-city-view-project', 'title' => 'Rivross City View', 'type' => 'Residential', 'location' => 'Mirpur, Dhaka', 'developer' => 'RIVROSS Developments', 'size' => '1500 sq.ft', 'bedrooms' => '3 Bed', 'parking' => '1 Parking', 'status' => 'Upcoming', 'price' => 'Price on request', 'timeline' => 'Launch: Q4 2026', 'image' => $asset . 'home/property-tower.png', 'excerpt' => 'A connected city address planned around practical modern living.', 'content' => 'Rivross City View will bring efficient residences and connected amenities to Mirpur.' ),
		array( 'slug' => 'rivross-business-hub-project', 'title' => 'Rivross Business Hub', 'type' => 'Commercial', 'location' => 'Banani, Dhaka', 'developer' => 'RIVROSS Commercial', 'size' => '3000 sq.ft', 'bedrooms' => 'Office Space', 'parking' => '2 Parking', 'status' => 'Upcoming', 'price' => 'Price on request', 'timeline' => 'Launch: Q1 2027', 'image' => $asset . 'real-estate/corporate-tower.png', 'excerpt' => 'Flexible office floors for ambitious companies in Banani.', 'content' => 'Rivross Business Hub is planned as a high-quality workplace destination with flexible commercial space.' ),
		array( 'slug' => 'rivross-garden-villas-project', 'title' => 'Rivross Garden Villas', 'type' => 'Residential', 'location' => 'Gazipur, Dhaka', 'developer' => 'RIVROSS Developments', 'size' => '2200 sq.ft', 'bedrooms' => '4 Bed', 'parking' => '2 Parking', 'status' => 'Upcoming', 'price' => 'Price on request', 'timeline' => 'Launch: Q2 2027', 'image' => $asset . 'companies/business-real-estate.png', 'excerpt' => 'Private garden villas with generous space and green surroundings.', 'content' => 'Rivross Garden Villas offers a calm, private setting for families who value space and nature.' ),
		array( 'slug' => 'rivross-tea-resort-project', 'title' => 'Rivross Tea Resort', 'type' => 'Resort', 'location' => 'Sylhet', 'developer' => 'RIVROSS Hospitality', 'size' => 'Custom Size', 'bedrooms' => 'Resort Villa', 'parking' => 'On site', 'status' => 'Upcoming', 'price' => 'Price on request', 'timeline' => 'Launch: Q3 2027', 'image' => $asset . 'home/business-tea.png', 'excerpt' => 'A nature-led resort concept surrounded by Sylhet tea gardens.', 'content' => 'Rivross Tea Resort will pair warm hospitality with the calm beauty of Sylhet\'s tea country.' ),
		array( 'slug' => 'rivross-heights-completed-project', 'title' => 'Rivross Heights', 'type' => 'Residential', 'location' => 'Bashundhara, Dhaka', 'developer' => 'RIVROSS Developments', 'size' => '1600 sq.ft', 'bedrooms' => '3 Bed', 'parking' => '1 Parking', 'status' => 'Completed', 'price' => 'BDT 8,400 /sqft', 'timeline' => 'Completed: 2023', 'image' => $asset . 'companies/business-real-estate.png', 'excerpt' => 'Spacious residences delivered with refined finishes.', 'content' => 'Rivross Heights is a completed residential community with generous living spaces and dependable service.' ),
		array( 'slug' => 'rivross-city-center-completed-project', 'title' => 'Rivross City Center', 'type' => 'Commercial', 'location' => 'Motijheel, Dhaka', 'developer' => 'RIVROSS Commercial', 'size' => '1800 sq.ft', 'bedrooms' => 'Office Space', 'parking' => '2 Parking', 'status' => 'Completed', 'price' => 'BDT 12,500 /sqft', 'timeline' => 'Completed: 2022', 'image' => $asset . 'real-estate/corporate-tower.png', 'excerpt' => 'A trusted commercial address in Dhaka\'s business district.', 'content' => 'Rivross City Center gives established businesses a central and well-connected office address.' ),
		array( 'slug' => 'rivross-lake-side-completed-project', 'title' => 'Rivross Lake Side', 'type' => 'Residential', 'location' => 'Uttara, Dhaka', 'developer' => 'RIVROSS Developments', 'size' => '1400 sq.ft', 'bedrooms' => '3 Bed', 'parking' => '1 Parking', 'status' => 'Completed', 'price' => 'BDT 6,900 /sqft', 'timeline' => 'Completed: 2021', 'image' => $asset . 'home/business-real-estate.png', 'excerpt' => 'A calm lakeside community shaped around everyday comfort.', 'content' => 'Rivross Lake Side is a completed community that balances accessible location with a peaceful setting.' ),
		array( 'slug' => 'rivross-green-valley-plots-project', 'title' => 'Rivross Green Valley Plots', 'type' => 'Land / Plot', 'location' => 'Keraniganj, Dhaka', 'developer' => 'RIVROSS Land & Development', 'size' => '5 Katha', 'bedrooms' => 'Road: 25 ft', 'parking' => 'Sold Out', 'status' => 'Completed', 'price' => 'Sold Out', 'timeline' => 'Completed: 2020', 'image' => $asset . 'real-estate/premium-plots.png', 'excerpt' => 'A completed plotted community with green surroundings.', 'content' => 'Rivross Green Valley Plots is a completed land development delivered with planned access and clear documentation.' ),
	);
	foreach ( $projects as $project ) {
		if ( get_page_by_path( $project['slug'], OBJECT, 'rivross_project' ) ) { continue; }
		$post_id = wp_insert_post( array( 'post_type' => 'rivross_project', 'post_status' => 'publish', 'post_title' => $project['title'], 'post_name' => $project['slug'], 'post_excerpt' => $project['excerpt'], 'post_content' => $project['content'] ) );
		if ( ! $post_id || is_wp_error( $post_id ) ) { continue; }
		wp_set_object_terms( $post_id, $project['type'], 'rivross_project_type' );
		foreach ( $project as $key => $value ) {
			if ( in_array( $key, array( 'slug', 'title', 'type', 'excerpt', 'content' ), true ) ) { continue; }
			update_post_meta( $post_id, '_rivross_project_' . $key, $value );
		}
		update_post_meta( $post_id, '_rivross_project_gallery', implode( "\n", array( $project['image'], $project['image'] ) ) );
	}
	if ( ! get_page_by_path( 'projects' ) ) { wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Projects', 'post_name' => 'projects' ) ); }
	update_option( 'rivross_projects_seeded', 1 );
}
add_action( 'init', 'rivross_seed_projects', 30 );

function rivross_flush_project_rewrites() {
	rivross_register_project_content();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'rivross_flush_project_rewrites' );
