<?php
/**
 * Template Name: Travel & Tourism
 *
 * @package Rivross_Corporate
 */

get_header();

$travel_image_uri = get_theme_file_uri( '/assets/images/travel/' );
$hero_image       = get_theme_mod( 'rivross_travel_hero_image', $travel_image_uri . 'travel-hero.png' );
$why_image        = get_theme_mod( 'rivross_travel_why_image', $travel_image_uri . 'travel-journey.png' );
$hero_button      = trim( (string) get_theme_mod( 'rivross_travel_hero_button_url', '#travel-inquiry' ) );
$cta_button       = trim( (string) get_theme_mod( 'rivross_travel_cta_button_url', '#travel-inquiry' ) );
$hero_url         = 0 === strpos( $hero_button, '#' ) ? $hero_button : rivross_theme_link( $hero_button );
$cta_url          = 0 === strpos( $cta_button, '#' ) ? $cta_button : rivross_theme_link( $cta_button );

$benefits = array(
	array( 'award', 'Best Prices', 'Competitive fares and best value' ),
	array( 'headset', 'Trusted Support', '24/7 assistance every step of the way' ),
	array( 'globe', 'Global Network', 'Partners worldwide to serve you better' ),
	array( 'shield', 'Safe & Secure', 'Your journey is our priority' ),
	array( 'target', 'Customized Trips', 'Tailored solutions for every traveler' ),
);
foreach ( $benefits as $index => $benefit ) {
	$number         = $index + 1;
	$benefit[0]     = get_theme_mod( 'rivross_travel_benefit_' . $number . '_icon', $benefit[0] );
	$benefit[1]     = get_theme_mod( 'rivross_travel_benefit_' . $number . '_title', $benefit[1] );
	$benefit[2]     = get_theme_mod( 'rivross_travel_benefit_' . $number . '_description', $benefit[2] );
	$benefits[ $index ] = $benefit;
}

$services = array(
	array( 'plane', 'service-air-ticketing.png', 'Air Ticketing', 'Domestic & international flight tickets with best prices and offers.' ),
	array( 'hotel', 'service-hotel-booking.png', 'Hotel Booking', 'Comfortable stays worldwide at exclusive rates.' ),
	array( 'suitcase', 'service-tour-packages.png', 'Tour Packages', 'Handpicked packages for leisure, adventure and group tours.' ),
	array( 'kaaba', 'service-hajj-umrah.png', 'Hajj & Umrah', 'Complete Hajj & Umrah services with care and guidance.' ),
	array( 'briefcase', 'service-corporate-travel.png', 'Corporate Travel', 'Business travel solutions designed for your corporate needs.' ),
);
foreach ( $services as $index => $service ) {
	$number        = $index + 1;
	$service[0]    = get_theme_mod( 'rivross_travel_service_' . $number . '_icon', $service[0] );
	$service[1]    = get_theme_mod( 'rivross_travel_service_' . $number . '_image', $travel_image_uri . $service[1] );
	$service[2]    = get_theme_mod( 'rivross_travel_service_' . $number . '_title', $service[2] );
	$service[3]    = get_theme_mod( 'rivross_travel_service_' . $number . '_description', $service[3] );
	$services[ $index ] = $service;
}

$why_points = array(
	'Transparent pricing with no hidden charges',
	'Experienced team and 24/7 support',
	'Reliable partners worldwide',
	'Safe, secure and comfortable travel',
	'Thousands of happy travelers',
);
foreach ( $why_points as $index => $point ) {
	$why_points[ $index ] = get_theme_mod( 'rivross_travel_why_point_' . ( $index + 1 ), $point );
}

$travel_form = '';
if ( class_exists( 'WPCF7_ContactForm' ) ) {
	$forms = WPCF7_ContactForm::find( array( 'title' => 'RIVROSS Travel Inquiry', 'posts_per_page' => 1 ) );
	if ( ! empty( $forms ) && is_object( $forms[0] ) ) {
		$travel_form = do_shortcode( $forms[0]->shortcode() );
	}
}
?>

<section class="travel-hero" style="--travel-hero-image:url('<?php echo esc_url( $hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide travel-hero__inner">
		<nav class="travel-breadcrumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_travel_breadcrumb_home', __( 'Home', 'rivross-corporate' ) ) ); ?></a><span aria-hidden="true">›</span><span><?php echo esc_html( get_theme_mod( 'rivross_travel_breadcrumb_page', __( 'Travel & Tourism', 'rivross-corporate' ) ) ); ?></span></nav>
		<div class="travel-hero__copy">
			<p class="travel-kicker"><span></span><?php echo esc_html( get_theme_mod( 'rivross_travel_hero_kicker', __( 'RIVROSS Travel & Tourism', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'plane' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<h1><span><?php echo esc_html( get_theme_mod( 'rivross_travel_hero_line_1', __( 'Travel Beyond Limits,', 'rivross-corporate' ) ) ); ?></span><strong><?php echo esc_html( get_theme_mod( 'rivross_travel_hero_line_2', __( 'Experience the World', 'rivross-corporate' ) ) ); ?></strong></h1>
			<p class="travel-hero__description"><?php echo esc_html( get_theme_mod( 'rivross_travel_hero_description', __( 'From air tickets to unforgettable journeys, we provide complete travel solutions tailored to your needs.', 'rivross-corporate' ) ) ); ?></p>
			<a class="rivross-button" href="<?php echo esc_url( $hero_url ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_travel_hero_button_label', __( 'Plan Your Journey', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
		</div>
	</div>
</section>

<section class="travel-benefits" aria-label="Travel benefits">
	<div class="rivross-container rivross-container--wide travel-benefits__grid">
		<?php foreach ( $benefits as $benefit ) : ?>
			<article class="travel-benefit"><div class="travel-benefit__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $benefit[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div><h2><?php echo esc_html( $benefit[1] ); ?></h2><p><?php echo esc_html( $benefit[2] ); ?></p></article>
		<?php endforeach; ?>
	</div>
</section>

<section class="travel-services travel-section">
	<div class="rivross-container rivross-container--wide">
		<div class="travel-section__heading"><span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_travel_services_eyebrow', __( 'Our Services', 'rivross-corporate' ) ) ); ?></span><h2><?php echo esc_html( get_theme_mod( 'rivross_travel_services_title', __( 'Complete Travel Solutions', 'rivross-corporate' ) ) ); ?></h2><span class="travel-heading-rule"></span></div>
		<div class="travel-service-grid">
			<?php foreach ( $services as $service ) : ?>
				<article class="travel-service-card"><div class="travel-service-card__media" style="--travel-service-image:url('<?php echo esc_url( $service[1] ); ?>');"><div class="travel-service-card__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $service[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div></div><div class="travel-service-card__body"><h3><?php echo esc_html( $service[2] ); ?></h3><p><?php echo esc_html( $service[3] ); ?></p></div></article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="travel-commitment travel-section">
	<div class="rivross-container rivross-container--wide travel-commitment__inner" style="--travel-why-image:url('<?php echo esc_url( $why_image ); ?>');">
		<div class="travel-commitment__copy"><p class="travel-kicker"><span></span><?php echo esc_html( get_theme_mod( 'rivross_travel_why_eyebrow', __( 'Why Choose RIVROSS?', 'rivross-corporate' ) ) ); ?></p><h2><?php echo esc_html( get_theme_mod( 'rivross_travel_why_title', __( 'Your Journey, Our Commitment', 'rivross-corporate' ) ) ); ?></h2><ul>
			<?php foreach ( $why_points as $point ) : ?><li><?php echo rivross_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $point ); ?></span></li><?php endforeach; ?>
		</ul></div>
	</div>
</section>

<section class="travel-cta">
	<div class="rivross-container rivross-container--wide travel-cta__inner"><div><h2><?php echo esc_html( get_theme_mod( 'rivross_travel_cta_title', __( 'Ready to Explore the World?', 'rivross-corporate' ) ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'rivross_travel_cta_description', __( 'Let us handle the details while you enjoy the experience.', 'rivross-corporate' ) ) ); ?></p></div><a class="rivross-button" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_travel_cta_button_label', __( 'Inquire Now', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div>
</section>

<section id="travel-inquiry" class="travel-inquiry travel-section">
	<div class="rivross-container rivross-container--wide"><div class="travel-inquiry__heading"><p class="travel-kicker"><span></span><?php echo esc_html( get_theme_mod( 'rivross_travel_inquiry_eyebrow', __( 'Plan Your Journey With Us', 'rivross-corporate' ) ) ); ?></p><p><?php echo esc_html( get_theme_mod( 'rivross_travel_inquiry_description', __( 'Share your travel plans and we\'ll get back to you with the best options.', 'rivross-corporate' ) ) ); ?></p></div>
		<?php if ( $travel_form ) : ?>
			<div class="travel-inquiry__form travel-inquiry__form--cf7"><?php echo $travel_form; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<?php else : ?>
			<form class="travel-inquiry__form" action="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" method="post">
				<label><span><?php echo rivross_icon( 'users' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><input type="text" name="travel_name" placeholder="<?php esc_attr_e( 'Full Name', 'rivross-corporate' ); ?>" required></label>
				<label><span><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><input type="email" name="travel_email" placeholder="<?php esc_attr_e( 'Email Address', 'rivross-corporate' ); ?>" required></label>
				<label><span><?php echo rivross_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><input type="tel" name="travel_phone" placeholder="<?php esc_attr_e( 'Phone Number', 'rivross-corporate' ); ?>"></label>
				<label><span><?php echo rivross_icon( 'globe' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><select name="travel_type"><option value=""><?php esc_html_e( 'Travel Type', 'rivross-corporate' ); ?></option><option><?php esc_html_e( 'Air Ticketing', 'rivross-corporate' ); ?></option><option><?php esc_html_e( 'Tour Package', 'rivross-corporate' ); ?></option><option><?php esc_html_e( 'Hajj & Umrah', 'rivross-corporate' ); ?></option><option><?php esc_html_e( 'Corporate Travel', 'rivross-corporate' ); ?></option></select></label>
				<label class="travel-inquiry__message"><span><?php echo rivross_icon( 'news' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><textarea name="travel_message" rows="5" placeholder="<?php esc_attr_e( 'Tell us about your trip...', 'rivross-corporate' ); ?>"></textarea></label>
				<button class="rivross-button travel-inquiry__submit" type="submit"><?php esc_html_e( 'Send Inquiry', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
			</form>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
