<?php
/** Single RIVROSS service page. */

get_header();
while ( have_posts() ) :
	the_post();
	$id       = get_the_ID();
	$image    = rivross_service_image_url( $id );
	$terms    = get_the_terms( $id, 'rivross_service_category' );
	$category = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0]->name : __( 'RIVROSS Service', 'rivross-corporate' );
	$tagline  = rivross_service_meta( $id, 'tagline' );
	$intro    = rivross_service_meta( $id, 'intro', get_the_excerpt() );
	$gallery  = preg_split( '/\r?\n|,/', (string) rivross_service_meta( $id, 'gallery' ) );
	$gallery  = array_values( array_filter( array_map( 'trim', $gallery ) ) );
	if ( empty( $gallery ) ) {
		$gallery = array( $image );
	}
	$highlights = array_values( array_filter( array_map( 'trim', preg_split( '/\r?\n/', (string) rivross_service_meta( $id, 'highlights' ) ) ) ) );
	$process    = array_values( array_filter( array_map( 'trim', preg_split( '/\r?\n/', (string) rivross_service_meta( $id, 'process' ) ) ) ) );
	$inquiry    = rivross_service_meta( $id, 'inquiry_url', home_url( '/contact-us/#contact-form' ) );
?>
<section class="services-hero services-single-hero" style="--services-hero-image:url('<?php echo esc_url( $image ); ?>');">
	<div class="rivross-container rivross-container--wide services-hero__inner">
		<nav class="services-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rivross-corporate' ); ?></a><span>›</span><a href="<?php echo esc_url( get_post_type_archive_link( 'rivross_service' ) ); ?>"><?php esc_html_e( 'Services', 'rivross-corporate' ); ?></a><span>›</span><span><?php the_title(); ?></span></nav>
		<div class="services-hero__copy"><span class="rivross-eyebrow"><?php echo esc_html( $category ); ?></span><h1><span><?php echo esc_html( $tagline ? $tagline : __( 'Trusted expertise,', 'rivross-corporate' ) ); ?></span><strong><?php the_title(); ?></strong></h1><i></i><p><?php echo esc_html( wp_trim_words( $intro, 30, '…' ) ); ?></p></div>
	</div>
</section>

<main class="services-single-main"><div class="rivross-container rivross-container--wide"><div class="services-single-grid"><div class="services-single-content"><figure class="services-single-feature"><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"></figure><div class="services-single-heading"><span class="service-card__category"><?php echo esc_html( $category ); ?></span><h2><?php the_title(); ?></h2><p><?php echo esc_html( $intro ); ?></p></div><div class="services-single-copy"><?php the_content(); ?></div><?php if ( ! empty( $highlights ) ) : ?><section class="services-detail-section"><span class="rivross-eyebrow"><?php esc_html_e( 'What We Deliver', 'rivross-corporate' ); ?></span><h2><?php esc_html_e( 'A complete service, shaped around your brief.', 'rivross-corporate' ); ?></h2><ul class="services-check-list"><?php foreach ( $highlights as $item ) : ?><li><?php echo rivross_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $item ); ?></li><?php endforeach; ?></ul></section><?php endif; ?><?php if ( ! empty( $process ) ) : ?><section class="services-detail-section services-process"><span class="rivross-eyebrow"><?php esc_html_e( 'How We Work', 'rivross-corporate' ); ?></span><h2><?php esc_html_e( 'Clear steps. Considered decisions.', 'rivross-corporate' ); ?></h2><ol><?php foreach ( $process as $index => $item ) : ?><li><span><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span><strong><?php echo esc_html( $item ); ?></strong></li><?php endforeach; ?></ol></section><?php endif; ?><section class="services-single-gallery"><span class="rivross-eyebrow"><?php esc_html_e( 'Service Gallery', 'rivross-corporate' ); ?></span><h2><?php esc_html_e( 'See the quality in every detail.', 'rivross-corporate' ); ?></h2><div><?php foreach ( $gallery as $gallery_image ) : ?><img src="<?php echo esc_url( $gallery_image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy"><?php endforeach; ?></div></section></div><aside class="services-single-aside"><div class="services-single-aside__icon"><?php echo rivross_icon( rivross_service_icon( $id ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div><span class="rivross-eyebrow"><?php esc_html_e( 'Start with RIVROSS', 'rivross-corporate' ); ?></span><h2><?php esc_html_e( 'Let’s plan your next step.', 'rivross-corporate' ); ?></h2><p><?php esc_html_e( 'Tell us about your space, timeline and priorities. Our team will come back with a practical direction.', 'rivross-corporate' ); ?></p><a class="rivross-button" href="<?php echo esc_url( $inquiry ); ?>"><?php esc_html_e( 'Discuss This Service', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><a class="rivross-button services-single-aside__outline" href="<?php echo esc_url( get_post_type_archive_link( 'rivross_service' ) ); ?>"><?php esc_html_e( 'View All Services', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'grid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></aside></div></div></main>
<?php endwhile; get_footer(); ?>
