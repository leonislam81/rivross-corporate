<?php
/**
 * Single property details page.
 *
 * @package Rivross_Corporate
 */

get_header();
while ( have_posts() ) :
	the_post();
	$property_id = get_the_ID();
	$image       = rivross_property_meta( $property_id, 'hero_image' );
	$image       = $image ? $image : rivross_property_image_url( $property_id );
	$type_terms  = get_the_terms( $property_id, 'rivross_property_type' );
	$type_label  = ! empty( $type_terms ) && ! is_wp_error( $type_terms ) ? $type_terms[0]->name : rivross_property_meta( $property_id, 'type', __( 'Property', 'rivross-corporate' ) );
	$location    = rivross_property_meta( $property_id, 'location' );
	$map_url     = rivross_property_meta( $property_id, 'map_url' );
	$map_url     = $map_url ? $map_url : 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $location );
	$brochure    = rivross_property_meta( $property_id, 'brochure_url' );
	$inquiry     = rivross_property_meta( $property_id, 'inquiry_url' );
	$inquiry     = $inquiry ? $inquiry : home_url( '/contact-us/#contact-form' );
	$gallery     = preg_split( '/\r?\n|,/', (string) rivross_property_meta( $property_id, 'gallery' ) );
	$gallery     = array_values( array_filter( array_map( 'trim', $gallery ) ) );
	if ( empty( $gallery ) ) { $gallery = array( $image ); }
	$glance_lines = preg_split( '/\r?\n/', (string) rivross_property_meta( $property_id, 'at_a_glance' ) );
	$facts = array();
	foreach ( $glance_lines as $glance_line ) {
		$parts = explode( '||', $glance_line, 2 );
		if ( count( $parts ) < 2 || '' === trim( $parts[1] ) ) { continue; }
		$label = trim( $parts[0] );
		$icon = 'grid';
		if ( false !== stripos( $label, 'location' ) || false !== stripos( $label, 'address' ) || false !== stripos( $label, 'facing' ) ) { $icon = 'pin'; }
		elseif ( false !== stripos( $label, 'area' ) || false !== stripos( $label, 'size' ) || false !== stripos( $label, 'road' ) ) { $icon = 'ruler'; }
		elseif ( false !== stripos( $label, 'parking' ) ) { $icon = 'car'; }
		elseif ( false !== stripos( $label, 'bed' ) ) { $icon = 'bed'; }
		elseif ( false !== stripos( $label, 'toilet' ) || false !== stripos( $label, 'bath' ) ) { $icon = 'bath'; }
		elseif ( false !== stripos( $label, 'floor' ) || false !== stripos( $label, 'consultant' ) ) { $icon = 'building'; }
		elseif ( false !== stripos( $label, 'status' ) ) { $icon = 'shield'; }
		$facts[] = array( $icon, $label, trim( $parts[1] ) );
	}
	if ( empty( $facts ) ) {
		$facts = array(
			array( 'building', __( 'Developer', 'rivross-corporate' ), rivross_property_meta( $property_id, 'developer' ) ),
			array( 'grid', __( 'Property Type', 'rivross-corporate' ), $type_label ),
			array( 'ruler', __( 'Size / Area', 'rivross-corporate' ), rivross_property_meta( $property_id, 'size' ) ),
			array( 'bed', __( 'Bedrooms', 'rivross-corporate' ), rivross_property_meta( $property_id, 'bedrooms' ) ),
			array( 'bath', __( 'Bathrooms', 'rivross-corporate' ), rivross_property_meta( $property_id, 'bathrooms' ) ),
			array( 'car', __( 'Parking', 'rivross-corporate' ), rivross_property_meta( $property_id, 'parking' ) ),
			array( 'shield', __( 'Project Status', 'rivross-corporate' ), rivross_property_meta( $property_id, 'status' ) ),
			array( 'money', __( 'Price', 'rivross-corporate' ), rivross_property_meta( $property_id, 'price' ) ),
			array( 'calendar', __( 'Handover', 'rivross-corporate' ), rivross_property_meta( $property_id, 'handover' ) ),
		);
	}
	$amenities = preg_split( '/\r?\n/', (string) rivross_property_meta( $property_id, 'amenities' ) );
	$amenities = array_values( array_filter( array_map( 'trim', $amenities ) ) );
	$floor_plan = rivross_property_meta( $property_id, 'floor_plan' );
	$at_a_glance_image = rivross_property_meta( $property_id, 'at_a_glance_image' );
	$video_url  = rivross_property_meta( $property_id, 'video_url' );
	$related    = new WP_Query( array( 'post_type' => 'rivross_property', 'post_status' => 'publish', 'posts_per_page' => 3, 'post__not_in' => array( $property_id ), 'tax_query' => array( array( 'taxonomy' => 'rivross_property_type', 'field' => 'slug', 'terms' => ! empty( $type_terms ) && ! is_wp_error( $type_terms ) ? $type_terms[0]->slug : '' ) ) ) );
?>
<section class="property-hero property-single-hero" style="--property-hero-image:url('<?php echo esc_url( $image ); ?>');">
	<div class="rivross-container rivross-container--wide property-hero__inner">
		<nav class="property-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rivross-corporate' ); ?></a><span>›</span><a href="<?php echo esc_url( home_url( '/real-estate/' ) ); ?>"><?php esc_html_e( 'Real Estate', 'rivross-corporate' ); ?></a><span>›</span><span><?php the_title(); ?></span></nav>
		<div class="property-hero__copy"><h1><span><?php echo esc_html( $type_label ); ?></span><strong><?php the_title(); ?></strong></h1><i></i><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26, '…' ) ); ?></p></div>
	</div>
</section>
<main class="property-single-main">
	<div class="rivross-container rivross-container--wide">
		<div class="property-single-grid">
			<div>
				<figure class="property-single-feature"><button class="property-image-trigger" type="button" data-property-lightbox aria-label="<?php echo esc_attr( sprintf( __( 'View %s image', 'rivross-corporate' ), get_the_title() ) ); ?>"><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"></button></figure>
				<h2 class="property-single-title"><?php the_title(); ?></h2>
				<p class="property-single-location"><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $location ); ?></p>
				<div class="property-facts">
					<?php foreach ( $facts as $fact ) : ?><div class="property-fact"><span><?php echo rivross_icon( $fact[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><div><small><?php echo esc_html( $fact[1] ); ?></small><strong><?php echo esc_html( $fact[2] ); ?></strong></div></div><?php endforeach; ?>
				</div>
				<?php if ( $at_a_glance_image ) : ?><section class="property-glance"><h2><?php esc_html_e( 'Project At a Glance', 'rivross-corporate' ); ?></h2><button class="property-image-trigger" type="button" data-property-lightbox aria-label="<?php echo esc_attr( sprintf( __( 'View %s at a glance', 'rivross-corporate' ), get_the_title() ) ); ?>"><img src="<?php echo esc_url( $at_a_glance_image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> at a glance"></button></section><?php endif; ?>
				<div class="property-single-copy"><h2><?php esc_html_e( 'About This Property', 'rivross-corporate' ); ?></h2><?php the_content(); ?></div>
				<?php if ( ! empty( $amenities ) ) : ?><section class="property-amenities"><h2><?php esc_html_e( 'Features & Amenities', 'rivross-corporate' ); ?></h2><div class="property-amenities__grid"><?php foreach ( $amenities as $amenity ) : ?><div><span><?php echo rivross_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><strong><?php echo esc_html( $amenity ); ?></strong></div><?php endforeach; ?></div></section><?php endif; ?>
				<?php if ( $floor_plan ) : ?><section class="property-floor-plan"><h2><?php esc_html_e( 'Floor Plan', 'rivross-corporate' ); ?></h2><button class="property-image-trigger" type="button" data-property-lightbox aria-label="<?php echo esc_attr( sprintf( __( 'View %s floor plan', 'rivross-corporate' ), get_the_title() ) ); ?>"><img src="<?php echo esc_url( $floor_plan ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> floor plan"></button></section><?php endif; ?>
				<section class="property-gallery"><h2><?php esc_html_e( 'Property Gallery', 'rivross-corporate' ); ?></h2><div class="property-gallery__grid"><?php foreach ( $gallery as $gallery_image ) : ?><button class="property-gallery__item" type="button" data-property-lightbox aria-label="<?php echo esc_attr( sprintf( __( 'View %s gallery image', 'rivross-corporate' ), get_the_title() ) ); ?>"><img src="<?php echo esc_url( $gallery_image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"></button><?php endforeach; ?></div></section>
			</div>
			<aside class="property-single-aside"><h2><?php esc_html_e( 'Interested in this property?', 'rivross-corporate' ); ?></h2><p><?php esc_html_e( 'Speak with our property experts for availability, pricing and a private consultation.', 'rivross-corporate' ); ?></p><a class="rivross-button" href="<?php echo esc_url( $inquiry ); ?>"><?php esc_html_e( 'Contact / Inquiry', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><a class="rivross-button property-single-aside__outline" href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'View Map Location', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'map' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><?php if ( $video_url ) : ?><a class="rivross-button property-single-aside__outline" href="<?php echo esc_url( $video_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Watch Video Tour', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'play' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><?php endif; ?><?php if ( $brochure ) : ?><a class="rivross-button property-single-aside__outline" href="<?php echo esc_url( $brochure ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Download Brochure', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'download' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><?php endif; ?></aside>
		</div>
	</div>
</main>
<?php if ( $related->have_posts() ) : ?><section class="property-related"><div class="rivross-container rivross-container--wide"><h2><?php esc_html_e( 'Explore More Properties', 'rivross-corporate' ); ?></h2><div class="property-related__grid"><?php while ( $related->have_posts() ) : $related->the_post(); $related_id = get_the_ID(); ?><article class="property-card"><a class="property-card__media" href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( rivross_property_image_url( $related_id ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"></a><div class="property-card__body"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p class="property-card__location"><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( rivross_property_meta( $related_id, 'location' ) ); ?></p><strong class="property-card__price"><?php echo esc_html( rivross_property_meta( $related_id, 'price' ) ); ?></strong><a class="property-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View Details', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div></article><?php endwhile; wp_reset_postdata(); ?></div></div></section><?php endif; ?>
<?php endwhile; get_footer(); ?>
