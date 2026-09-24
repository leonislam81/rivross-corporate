<?php
/**
 * Template Name: Tea Business
 *
 * @package Rivross_Corporate
 */

get_header();

$tea_image_uri = get_theme_file_uri( '/assets/images/tea/' );
$hero_image    = get_theme_mod( 'rivross_tea_hero_image', $tea_image_uri . 'tea-hero.png' );
$why_image     = get_theme_mod( 'rivross_tea_why_image', $tea_image_uri . 'tea-commitment.png' );
$inquiry_image = get_theme_mod( 'rivross_tea_inquiry_image', $tea_image_uri . 'service-corporate-supply.png' );
$hero_button   = trim( (string) get_theme_mod( 'rivross_tea_hero_button_url', '#tea-inquiry' ) );
$cta_button    = trim( (string) get_theme_mod( 'rivross_tea_cta_button_url', '#tea-inquiry' ) );
$hero_url      = 0 === strpos( $hero_button, '#' ) ? $hero_button : rivross_theme_link( $hero_button );
$cta_url       = 0 === strpos( $cta_button, '#' ) ? $cta_button : rivross_theme_link( $cta_button );

$benefits = array(
	array( 'leaf', 'Premium Quality', 'Carefully selected finest tea leaves' ),
	array( 'sprout', 'Sustainable Sourcing', 'Ethical practices for a better tomorrow' ),
	array( 'suitcase', 'Wholesale Supply', 'Bulk supply with consistent quality' ),
	array( 'briefcase', 'Timely Delivery', 'Reliable logistics you can trust' ),
	array( 'users', 'Customer Focused', 'Dedicated support for your needs' ),
	array( 'shield', 'Global Standards', 'International quality and safety assured' ),
);
foreach ( $benefits as $index => $benefit ) {
	$number = $index + 1;
	$benefit[0] = get_theme_mod( 'rivross_tea_benefit_' . $number . '_icon', $benefit[0] );
	$benefit[1] = get_theme_mod( 'rivross_tea_benefit_' . $number . '_title', $benefit[1] );
	$benefit[2] = get_theme_mod( 'rivross_tea_benefit_' . $number . '_description', $benefit[2] );
	$benefits[ $index ] = $benefit;
}

$services = array(
	array( 'leaf', 'service-tea-sourcing.png', 'Tea Sourcing', 'We source the finest tea directly from trusted gardens across Bangladesh.' ),
	array( 'building', 'service-wholesale-supply.png', 'Wholesale Supply', 'Bulk supply for distributors, retailers and tea importers worldwide.' ),
	array( 'sprout', 'service-blending-packing.png', 'Blending & Packing', 'Expert blending and hygienic packing to preserve freshness and flavor.' ),
	array( 'globe', 'service-distribution.png', 'Distribution', 'Efficient distribution network ensuring on-time delivery every time.' ),
	array( 'users', 'service-corporate-supply.png', 'Corporate Supply', 'Tailored tea solutions for hotels, cafes and corporate clients.' ),
);
foreach ( $services as $index => $service ) {
	$number = $index + 1;
	$service[0] = get_theme_mod( 'rivross_tea_service_' . $number . '_icon', $service[0] );
	$service[1] = get_theme_mod( 'rivross_tea_service_' . $number . '_image', $tea_image_uri . $service[1] );
	$service[2] = get_theme_mod( 'rivross_tea_service_' . $number . '_title', $service[2] );
	$service[3] = get_theme_mod( 'rivross_tea_service_' . $number . '_description', $service[3] );
	$services[ $index ] = $service;
}

$why_points = array(
	'100% authentic Bangladeshi tea',
	'Consistent quality, taste and aroma',
	'Competitive wholesale prices',
	'Flexible supply for all business sizes',
	'Reliable service and long-term partnership',
);
foreach ( $why_points as $index => $point ) {
	$why_points[ $index ] = get_theme_mod( 'rivross_tea_why_point_' . ( $index + 1 ), $point );
}

$tea_form = '';
if ( class_exists( 'WPCF7_ContactForm' ) ) {
	$forms = WPCF7_ContactForm::find( array( 'title' => 'RIVROSS Tea Inquiry', 'posts_per_page' => 1 ) );
	if ( ! empty( $forms ) && is_object( $forms[0] ) ) {
		$tea_form = do_shortcode( $forms[0]->shortcode() );
	}
}
?>

<section class="tea-hero" style="--tea-hero-image:url('<?php echo esc_url( $hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide tea-hero__inner">
		<nav class="tea-breadcrumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_tea_breadcrumb_home', __( 'Home', 'rivross-corporate' ) ) ); ?></a><span aria-hidden="true">›</span><span><?php echo esc_html( get_theme_mod( 'rivross_tea_breadcrumb_page', __( 'Tea Business', 'rivross-corporate' ) ) ); ?></span></nav>
		<div class="tea-hero__copy"><p class="tea-kicker"><span></span><?php echo esc_html( get_theme_mod( 'rivross_tea_hero_kicker', __( 'RIVROSS Tea Business', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'leaf' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p><h1><span><?php echo esc_html( get_theme_mod( 'rivross_tea_hero_line_1', __( 'Finest Tea,', 'rivross-corporate' ) ) ); ?></span><strong><?php echo esc_html( get_theme_mod( 'rivross_tea_hero_line_2', __( 'Sourced with Care', 'rivross-corporate' ) ) ); ?></strong></h1><p class="tea-hero__description"><?php echo esc_html( get_theme_mod( 'rivross_tea_hero_description', __( 'Delivering premium quality tea from the lush gardens of Bangladesh to homes and businesses around the world.', 'rivross-corporate' ) ) ); ?></p><a class="rivross-button" href="<?php echo esc_url( $hero_url ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_tea_hero_button_label', __( 'Discover Our Tea Solutions', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div>
	</div>
</section>

<section class="tea-benefits" aria-label="Tea business benefits"><div class="rivross-container rivross-container--wide tea-benefits__grid"><?php foreach ( $benefits as $benefit ) : ?><article class="tea-benefit"><div class="tea-benefit__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $benefit[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div><h2><?php echo esc_html( $benefit[1] ); ?></h2><p><?php echo esc_html( $benefit[2] ); ?></p></article><?php endforeach; ?></div></section>

<section class="tea-services tea-section"><div class="rivross-container rivross-container--wide"><div class="tea-section__heading"><span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_tea_services_eyebrow', __( 'Our Tea Solutions', 'rivross-corporate' ) ) ); ?></span><h2><?php echo esc_html( get_theme_mod( 'rivross_tea_services_title', __( 'Quality Tea for Every Need', 'rivross-corporate' ) ) ); ?></h2><span class="tea-heading-rule"></span></div><div class="tea-service-grid"><?php foreach ( $services as $service ) : ?><article class="tea-service-card"><div class="tea-service-card__media" style="--tea-service-image:url('<?php echo esc_url( $service[1] ); ?>');"><div class="tea-service-card__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $service[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div></div><div class="tea-service-card__body"><h3><?php echo esc_html( $service[2] ); ?></h3><p><?php echo esc_html( $service[3] ); ?></p></div></article><?php endforeach; ?></div></div></section>

<section class="tea-commitment tea-section"><div class="rivross-container rivross-container--wide tea-commitment__inner" style="--tea-why-image:url('<?php echo esc_url( $why_image ); ?>');"><div class="tea-commitment__copy"><p class="tea-kicker"><span></span><?php echo esc_html( get_theme_mod( 'rivross_tea_why_eyebrow', __( 'Why Choose RIVROSS Tea?', 'rivross-corporate' ) ) ); ?></p><h2><?php echo esc_html( get_theme_mod( 'rivross_tea_why_title', __( 'A Commitment to Excellence', 'rivross-corporate' ) ) ); ?></h2><ul><?php foreach ( $why_points as $point ) : ?><li><?php echo rivross_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $point ); ?></span></li><?php endforeach; ?></ul></div></div></section>

<section class="tea-cta"><div class="rivross-container rivross-container--wide tea-cta__inner"><div class="tea-cta__icon"><?php echo rivross_icon( 'leaf' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div><div><h2><?php echo esc_html( get_theme_mod( 'rivross_tea_cta_title', __( 'Let’s Grow Together', 'rivross-corporate' ) ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'rivross_tea_cta_description', __( 'Partner with RIVROSS Tea for premium quality, reliable supply and business growth.', 'rivross-corporate' ) ) ); ?></p></div><a class="rivross-button" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_tea_cta_button_label', __( 'Business Inquiry', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div></section>

<section id="tea-inquiry" class="tea-inquiry tea-section"><div class="rivross-container rivross-container--wide"><div class="tea-section__heading"><span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_tea_inquiry_eyebrow', __( 'Let’s Do Business Together', 'rivross-corporate' ) ) ); ?></span><h2><?php echo esc_html( get_theme_mod( 'rivross_tea_inquiry_title', __( 'Tell Us What You Need', 'rivross-corporate' ) ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'rivross_tea_inquiry_description', __( 'Tell us about your requirement and we’ll get back to you soon.', 'rivross-corporate' ) ) ); ?></p></div><div class="tea-inquiry__grid"><div class="tea-inquiry__form"><?php if ( $tea_form ) : ?><?php echo $tea_form; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php else : ?><p><?php esc_html_e( 'Our tea inquiry form will be available shortly.', 'rivross-corporate' ); ?></p><?php endif; ?></div><figure class="tea-inquiry__image"><img src="<?php echo esc_url( $inquiry_image ); ?>" alt="<?php esc_attr_e( 'RIVROSS tea service', 'rivross-corporate' ); ?>"></figure></div></div></section>

<?php get_footer(); ?>
