<?php
/**
 * RIVROSS Services custom post type, fields and starter catalogue.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Register the editable services catalogue. */
function rivross_register_service_content() {
	register_post_type(
		'rivross_service',
		array(
			'labels' => array(
				'name'          => __( 'Services', 'rivross-corporate' ),
				'singular_name' => __( 'Service', 'rivross-corporate' ),
				'add_new_item'  => __( 'Add New Service', 'rivross-corporate' ),
				'edit_item'     => __( 'Edit Service', 'rivross-corporate' ),
				'new_item'      => __( 'New Service', 'rivross-corporate' ),
				'view_item'     => __( 'View Service', 'rivross-corporate' ),
				'search_items'  => __( 'Search Services', 'rivross-corporate' ),
			),
			'public'             => true,
			'show_ui'            => true,
			'show_in_rest'       => true,
			'menu_position'      => 21,
			'menu_icon'          => 'dashicons-admin-tools',
			'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'services', 'with_front' => false ),
			'publicly_queryable' => true,
		)
	);

	register_taxonomy(
		'rivross_service_category',
		'rivross_service',
		array(
			'labels'            => array( 'name' => __( 'Service Categories', 'rivross-corporate' ), 'singular_name' => __( 'Service Category', 'rivross-corporate' ) ),
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'public'            => false,
			'show_admin_column' => true,
		)
	);
}
add_action( 'init', 'rivross_register_service_content' );

/** Flush once after a theme update so /services/ works without a manual permalink save. */
function rivross_maybe_flush_service_rewrites() {
	$version = defined( 'RIVROSS_THEME_VERSION' ) ? RIVROSS_THEME_VERSION : '1';
	if ( get_option( 'rivross_services_rewrite_version' ) === $version ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( 'rivross_services_rewrite_version', $version );
}
add_action( 'init', 'rivross_maybe_flush_service_rewrites', 99 );

/** The fields displayed in the service editor. */
function rivross_service_fields() {
	return array(
		'icon'         => array( 'label' => __( 'Service Icon', 'rivross-corporate' ), 'type' => 'text' ),
		'tagline'      => array( 'label' => __( 'Short Tagline', 'rivross-corporate' ), 'type' => 'text' ),
		'intro'        => array( 'label' => __( 'Short Introduction', 'rivross-corporate' ), 'type' => 'textarea' ),
		'highlights'   => array( 'label' => __( 'What We Deliver', 'rivross-corporate' ), 'type' => 'textarea' ),
		'process'      => array( 'label' => __( 'Our Process', 'rivross-corporate' ), 'type' => 'textarea' ),
		'image'        => array( 'label' => __( 'Service Image', 'rivross-corporate' ), 'type' => 'url' ),
		'gallery'      => array( 'label' => __( 'Gallery Images', 'rivross-corporate' ), 'type' => 'textarea' ),
		'inquiry_url'  => array( 'label' => __( 'Contact / Inquiry URL', 'rivross-corporate' ), 'type' => 'url' ),
		'order'        => array( 'label' => __( 'Display Order', 'rivross-corporate' ), 'type' => 'number' ),
	);
}

function rivross_service_meta( $service_id, $field, $default = '' ) {
	$value = get_post_meta( $service_id, '_rivross_service_' . $field, true );
	return '' !== $value ? $value : $default;
}

function rivross_service_image_url( $service_id ) {
	$image = get_the_post_thumbnail_url( $service_id, 'large' );
	if ( $image ) {
		return $image;
	}
	$image = rivross_service_meta( $service_id, 'image' );
	return $image ? esc_url( $image ) : get_theme_file_uri( '/assets/images/projects/projects-hero.png' );
}

function rivross_service_allowed_icons() {
	return array( 'building', 'grid', 'gear', 'shield', 'briefcase', 'ruler', 'lightbulb', 'hotel', 'sprout', 'folder', 'check' );
}

function rivross_service_icon( $service_id ) {
	$icon = sanitize_key( rivross_service_meta( $service_id, 'icon', 'gear' ) );
	return in_array( $icon, rivross_service_allowed_icons(), true ) ? $icon : 'gear';
}

function rivross_service_add_meta_box() {
	add_meta_box( 'rivross_service_details', __( 'Service Details', 'rivross-corporate' ), 'rivross_service_meta_box_html', 'rivross_service', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'rivross_service_add_meta_box' );

function rivross_service_meta_box_html( $post ) {
	wp_nonce_field( 'rivross_save_service', 'rivross_service_nonce' );
	echo '<p class="description">' . esc_html__( 'These fields power the Services cards and individual service page. Use the Featured Image panel for the primary image, or choose an image from the Media Library below. Use one item per line for highlights, process steps and gallery images.', 'rivross-corporate' ) . '</p><table class="form-table"><tbody>';
	foreach ( rivross_service_fields() as $key => $field ) {
		$value = rivross_service_meta( $post->ID, $key );
		echo '<tr><th><label for="rivross_service_' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label></th><td>';
		if ( 'textarea' === $field['type'] ) {
			if ( 'gallery' === $key ) {
				echo '<textarea class="large-text rivross-media-input rivross-media-gallery" rows="4" id="rivross_service_' . esc_attr( $key ) . '" name="rivross_service_' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea><p><button type="button" class="button rivross-media-button" data-target="rivross_service_' . esc_attr( $key ) . '" data-multiple="1">' . esc_html__( 'Choose / Upload Images', 'rivross-corporate' ) . '</button> <button type="button" class="button rivross-media-clear" data-target="rivross_service_' . esc_attr( $key ) . '">' . esc_html__( 'Clear Gallery', 'rivross-corporate' ) . '</button></p><div class="rivross-media-preview" data-preview-for="rivross_service_' . esc_attr( $key ) . '" style="display:none;max-width:600px;margin-top:8px;"></div>';
			} else {
				echo '<textarea class="large-text" rows="4" id="rivross_service_' . esc_attr( $key ) . '" name="rivross_service_' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea>';
			}
		} elseif ( 'image' === $key ) {
			echo '<input class="regular-text rivross-media-input" type="url" id="rivross_service_' . esc_attr( $key ) . '" name="rivross_service_' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"> <button type="button" class="button rivross-media-button" data-target="rivross_service_' . esc_attr( $key ) . '">' . esc_html__( 'Choose / Upload Image', 'rivross-corporate' ) . '</button> <button type="button" class="button rivross-media-clear" data-target="rivross_service_' . esc_attr( $key ) . '">' . esc_html__( 'Clear', 'rivross-corporate' ) . '</button><div class="rivross-media-preview" data-preview-for="rivross_service_' . esc_attr( $key ) . '" style="display:none;max-width:180px;margin-top:8px;"></div>';
		} elseif ( 'number' === $field['type'] ) {
			echo '<input class="small-text" type="number" min="0" step="1" id="rivross_service_' . esc_attr( $key ) . '" name="rivross_service_' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">';
		} else {
			echo '<input class="regular-text" type="text" id="rivross_service_' . esc_attr( $key ) . '" name="rivross_service_' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">';
			if ( 'icon' === $key ) {
				echo '<p class="description">' . esc_html__( 'Use an icon name such as building, grid, gear, shield, briefcase, ruler, lightbulb, hotel, sprout, folder or check.', 'rivross-corporate' ) . '</p>';
			}
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

function rivross_save_service_meta( $post_id ) {
	if ( ! isset( $_POST['rivross_service_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rivross_service_nonce'] ) ), 'rivross_save_service' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( rivross_service_fields() as $key => $field ) {
		$name = 'rivross_service_' . $key;
		if ( ! isset( $_POST[ $name ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $name ] );
		if ( 'number' === $field['type'] ) {
			$value = is_numeric( $raw ) ? max( 0, absint( $raw ) ) : '';
		} elseif ( 'url' === $field['type'] ) {
			$value = esc_url_raw( $raw );
		} elseif ( 'textarea' === $field['type'] ) {
			$value = 'gallery' === $key ? rivross_sanitize_gallery_urls( $raw ) : sanitize_textarea_field( $raw );
		} elseif ( 'icon' === $key ) {
			$value = in_array( sanitize_key( $raw ), rivross_service_allowed_icons(), true ) ? sanitize_key( $raw ) : 'gear';
		} else {
			$value = sanitize_text_field( $raw );
		}
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_rivross_service_' . $key );
		} else {
			update_post_meta( $post_id, '_rivross_service_' . $key, $value );
		}
	}
}
add_action( 'save_post_rivross_service', 'rivross_save_service_meta' );

function rivross_service_admin_columns( $columns ) {
	$columns['service_category'] = __( 'Category', 'rivross-corporate' );
	$columns['service_order']    = __( 'Order', 'rivross-corporate' );
	return $columns;
}
add_filter( 'manage_rivross_service_posts_columns', 'rivross_service_admin_columns' );

function rivross_service_admin_column_content( $column, $post_id ) {
	if ( 'service_category' === $column ) {
		$terms = get_the_terms( $post_id, 'rivross_service_category' );
		echo esc_html( ! empty( $terms ) && ! is_wp_error( $terms ) ? implode( ', ', wp_list_pluck( $terms, 'name' ) ) : '—' );
	} elseif ( 'service_order' === $column ) {
		echo esc_html( rivross_service_meta( $post_id, 'order', '0' ) );
	}
}
add_action( 'manage_rivross_service_posts_custom_column', 'rivross_service_admin_column_content', 10, 2 );

/** Add a starter catalogue once, leaving later editor changes untouched. */
function rivross_seed_services() {
	if ( get_option( 'rivross_services_seeded' ) ) {
		return;
	}
	$asset = get_theme_file_uri( '/assets/images/' );
	$catalogue = array(
		array( 'slug' => 'doors-architectural-hardware', 'title' => 'Doors & Architectural Hardware', 'category' => 'Building Finishes', 'icon' => 'building', 'tagline' => 'First impressions, engineered beautifully.', 'image' => $asset . 'projects/projects-hero.png', 'excerpt' => 'Premium doors, frames and architectural hardware selected for lasting performance and a refined finish.', 'content' => 'We help homeowners, developers and commercial teams choose, supply and install dependable door systems that look right and perform for years.', 'highlights' => "Main entrance and internal doors\nFire-rated and acoustic door systems\nLocks, handles and architectural hardware\nMeasurement, supply and installation", 'process' => "Understand the brief\nRecommend the right system\nCoordinate measurement and delivery\nComplete installation and handover" ),
		array( 'slug' => 'tiles-ceramics', 'title' => 'Tiles & Ceramics', 'category' => 'Building Finishes', 'icon' => 'grid', 'tagline' => 'Surfaces that shape the character of a space.', 'image' => $asset . 'real-estate/green-heights.png', 'excerpt' => 'Curated tiles and ceramics for residential, hospitality and commercial environments.', 'content' => 'From statement surfaces to reliable everyday finishes, our team helps you select tile formats, textures and specifications that balance design with performance.', 'highlights' => "Wall and floor tiles\nBathroom and kitchen ceramics\nOutdoor and anti-slip solutions\nSupply coordination and installation support", 'process' => "Review the space and usage\nShortlist styles and specifications\nConfirm quantities and samples\nDeliver with installation guidance" ),
		array( 'slug' => 'interior-design-fit-out', 'title' => 'Interior Design & Fit-Out', 'category' => 'Design & Fit-Out', 'icon' => 'ruler', 'tagline' => 'Thoughtful interiors, delivered end to end.', 'image' => $asset . 'companies/business-real-estate.png', 'excerpt' => 'Practical, elegant interior solutions for homes, offices, retail and hospitality spaces.', 'content' => 'RIVROSS brings concept, material selection and site coordination together to create interiors that are comfortable, functional and unmistakably yours.', 'highlights' => "Space planning and concept design\nMaterial and colour direction\nCustom joinery and furniture\nComplete fit-out coordination", 'process' => "Discover your needs\nDevelop the design direction\nApprove drawings and finishes\nCoordinate execution and quality checks" ),
		array( 'slug' => 'plumbing-sanitary-solutions', 'title' => 'Plumbing & Sanitary Solutions', 'category' => 'Building Systems', 'icon' => 'gear', 'tagline' => 'Reliable systems behind every comfortable space.', 'image' => $asset . 'travel/service-hotel-booking.png', 'excerpt' => 'Plumbing fixtures, sanitaryware and installation support for dependable everyday performance.', 'content' => 'We source practical, quality-assured plumbing and sanitary products for new builds, renovations and managed properties.', 'highlights' => "Sanitaryware and bathroom fittings\nWater supply and drainage fixtures\nPumps, valves and accessories\nInstallation and maintenance support", 'process' => "Assess the requirement\nMatch products to specification\nCoordinate delivery\nSupport installation and aftercare" ),
		array( 'slug' => 'electrical-lighting', 'title' => 'Electrical & Lighting', 'category' => 'Building Systems', 'icon' => 'lightbulb', 'tagline' => 'Better light. Smarter, safer spaces.', 'image' => $asset . 'real-estate/corporate-tower.png', 'excerpt' => 'Lighting, electrical accessories and practical solutions for modern spaces.', 'content' => 'Our electrical and lighting offering combines dependable products with a clear understanding of how people use a space.', 'highlights' => "Decorative and architectural lighting\nSwitches, sockets and accessories\nEnergy-conscious solutions\nSupply coordination and technical support", 'process' => "Understand the layout\nRecommend suitable products\nCoordinate quantities and delivery\nSupport installation and final checks" ),
		array( 'slug' => 'glass-aluminium-facade', 'title' => 'Glass, Aluminium & Facade', 'category' => 'Building Finishes', 'icon' => 'shield', 'tagline' => 'Clean lines, strong performance.', 'image' => $asset . 'companies/companies-hero.png', 'excerpt' => 'Glass, aluminium and facade solutions that bring light, durability and a polished exterior.', 'content' => 'We support projects with carefully specified glass and aluminium products for entrances, partitions, windows and facade applications.', 'highlights' => "Aluminium doors and windows\nGlass partitions and shower enclosures\nFacade and screen elements\nMeasurement and installation coordination", 'process' => "Review the design intent\nConfirm measurements and specification\nCoordinate fabrication\nInstall and inspect the finished work" ),
		array( 'slug' => 'paint-finishing-waterproofing', 'title' => 'Paint, Finishing & Waterproofing', 'category' => 'Care & Maintenance', 'icon' => 'sprout', 'tagline' => 'Protection and polish that lasts.', 'image' => $asset . 'tea/tea-commitment.png', 'excerpt' => 'Finishing, protective coatings and waterproofing support for long-lasting spaces.', 'content' => 'The right preparation and finish protect an asset while giving every room a confident, complete appearance.', 'highlights' => "Interior and exterior paint systems\nProtective coatings\nWaterproofing and sealing\nSurface preparation and repair", 'process' => "Inspect the surface\nRecommend the right system\nPrepare and protect the area\nApply, cure and review the finish" ),
		array( 'slug' => 'civil-works-maintenance', 'title' => 'Civil Works & Maintenance', 'category' => 'Care & Maintenance', 'icon' => 'briefcase', 'tagline' => 'Practical support from first fix to final care.', 'image' => $asset . 'home/property-tower.png', 'excerpt' => 'Responsive civil works, repair and maintenance support for properties and workplaces.', 'content' => 'We coordinate the practical work that keeps a property safe, presentable and ready for the people who use it.', 'highlights' => "Minor civil and repair works\nRenovation and refurbishment\nPlanned maintenance coordination\nSnagging and handover support", 'process' => "Inspect and scope the work\nShare a clear plan and estimate\nCoordinate trusted execution\nClose out with a quality review" ),
	);
	foreach ( $catalogue as $service ) {
		if ( get_page_by_path( $service['slug'], OBJECT, 'rivross_service' ) ) {
			continue;
		}
		if ( ! term_exists( $service['category'], 'rivross_service_category' ) ) {
			wp_insert_term( $service['category'], 'rivross_service_category' );
		}
		$post_id = wp_insert_post( array( 'post_type' => 'rivross_service', 'post_status' => 'publish', 'post_title' => $service['title'], 'post_name' => $service['slug'], 'post_excerpt' => $service['excerpt'], 'post_content' => $service['content'] ) );
		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}
		wp_set_object_terms( $post_id, $service['category'], 'rivross_service_category' );
		foreach ( $service as $key => $value ) {
			if ( in_array( $key, array( 'slug', 'title', 'category', 'excerpt', 'content' ), true ) ) {
				continue;
			}
			update_post_meta( $post_id, '_rivross_service_' . $key, $value );
		}
		update_post_meta( $post_id, '_rivross_service_order', count( get_posts( array( 'post_type' => 'rivross_service', 'post_status' => 'publish', 'fields' => 'ids', 'numberposts' => -1 ) ) ) );
	}
	update_option( 'rivross_services_seeded', 1 );
}
add_action( 'init', 'rivross_seed_services', 30 );

function rivross_service_flush_rewrites() {
	rivross_register_service_content();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'rivross_service_flush_rewrites' );

/** Old project archive URLs remain safe while the public navigation moves to Services. */
function rivross_redirect_projects_to_services() {
	if ( is_page( 'projects' ) && ! is_admin() ) {
		wp_safe_redirect( get_post_type_archive_link( 'rivross_service' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'rivross_redirect_projects_to_services', 2 );
