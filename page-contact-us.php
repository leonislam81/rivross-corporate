<?php
/**
 * Contact Us page template.
 *
 * @package Rivross_Corporate
 */

get_header();

$theme_uri = get_theme_file_uri( '/assets/images/contact/' );
$hero_image = get_theme_mod( 'rivross_contact_hero_image', $theme_uri . 'contact-hero.png' );
$breadcrumb_home = get_theme_mod( 'rivross_contact_breadcrumb_home', __( 'Home', 'rivross-corporate' ) );
$breadcrumb_page = get_theme_mod( 'rivross_contact_breadcrumb_page', __( 'Contact Us', 'rivross-corporate' ) );
$hero_line_1 = get_theme_mod( 'rivross_contact_hero_line_1', __( 'Get In Touch', 'rivross-corporate' ) );
$hero_line_2 = get_theme_mod( 'rivross_contact_hero_line_2', __( 'With Rivross', 'rivross-corporate' ) );
$hero_description = str_replace( '\\n', "\n", (string) get_theme_mod( 'rivross_contact_hero_description', __( "We're here to answer your questions, listen to your ideas and help you find the perfect solution for your real estate needs.", 'rivross-corporate' ) ) );

$contact_items = array(
	array( get_theme_mod( 'rivross_contact_call_icon', 'phone' ), get_theme_mod( 'rivross_contact_call_title', __( 'Call Us', 'rivross-corporate' ) ), get_theme_mod( 'rivross_contact_call_phone', '01796-565279' ), get_theme_mod( 'rivross_contact_call_meta', __( 'Sat - Thu (10:00 AM - 07:00 PM)', 'rivross-corporate' ) ) ),
	array( get_theme_mod( 'rivross_contact_email_icon', 'mail' ), get_theme_mod( 'rivross_contact_email_title', __( 'Email Us', 'rivross-corporate' ) ), get_theme_mod( 'rivross_contact_email_address', 'rivrossgroup@gmail.com' ), get_theme_mod( 'rivross_contact_email_meta', __( 'We reply within 24 hours', 'rivross-corporate' ) ) ),
	array( get_theme_mod( 'rivross_contact_visit_icon', 'pin' ), get_theme_mod( 'rivross_contact_visit_title', __( 'Visit Us', 'rivross-corporate' ) ), get_theme_mod( 'rivross_contact_visit_address', '3/3 Matirari, Jamebagh, Jurabagh, Dhaka-1204, Bangladesh' ), get_theme_mod( 'rivross_contact_visit_meta', '' ) ),
	array( get_theme_mod( 'rivross_contact_hours_icon', 'clock' ), get_theme_mod( 'rivross_contact_hours_title', __( 'Office Hours', 'rivross-corporate' ) ), get_theme_mod( 'rivross_contact_hours', 'Saturday - Thursday' ), get_theme_mod( 'rivross_contact_hours_meta', '10:00 AM - 07:00 PM' ) ),
);

$map_label = get_theme_mod( 'rivross_contact_map_label', __( 'Our Office Location', 'rivross-corporate' ) );
$map_address = get_theme_mod( 'rivross_contact_map_address', '3/3 Matirari, Jamebagh, Jurabagh, Dhaka-1204, Bangladesh' );
$map_url = get_theme_mod( 'rivross_contact_map_url', 'https://maps.google.com/?q=Jatrabari,Dhaka' );
$form_heading = get_theme_mod( 'rivross_contact_form_heading', __( 'Send Us a Message', 'rivross-corporate' ) );
$form_privacy = get_theme_mod( 'rivross_contact_form_privacy', __( 'Your information is safe with us. We respect your privacy.', 'rivross-corporate' ) );

$faq_heading_eyebrow = get_theme_mod( 'rivross_contact_faq_eyebrow', __( 'FAQ', 'rivross-corporate' ) );
$faq_heading = get_theme_mod( 'rivross_contact_faq_heading', __( 'Frequently Asked Questions', 'rivross-corporate' ) );
$faq_description = get_theme_mod( 'rivross_contact_faq_description', __( 'Find quick answers to common questions about our services and processes.', 'rivross-corporate' ) );
$faq_defaults = array(
	array( 'What types of properties do you deal with?', 'We help clients explore residential and commercial property opportunities through our real estate team.' ),
	array( 'How can I schedule a property visit?', 'Send us your preferred date through the form and our team will confirm a convenient time.' ),
	array( 'Do you provide financing support?', 'We can guide you through available options and connect you with the appropriate partners.' ),
	array( 'How can I list my property with Rivross?', 'Share your property details and our team will contact you about the next steps.' ),
	array( 'What documents are required to purchase a property?', 'The required documents depend on the property and transaction; our team will provide a checklist.' ),
);
$faqs = array();
for ( $index = 1; $index <= 5; $index++ ) {
	$faqs[] = array(
		get_theme_mod( 'rivross_contact_faq_' . $index . '_question', $faq_defaults[ $index - 1 ][0] ),
		get_theme_mod( 'rivross_contact_faq_' . $index . '_answer', $faq_defaults[ $index - 1 ][1] ),
	);
}

$cta_heading = get_theme_mod( 'rivross_contact_cta_heading', __( 'Ready to Find Your Dream Property?', 'rivross-corporate' ) );
$cta_description = get_theme_mod( 'rivross_contact_cta_description', __( 'Our experts are ready to help you make the right move.', 'rivross-corporate' ) );
$cta_primary_label = get_theme_mod( 'rivross_contact_cta_primary_label', __( 'Explore Properties', 'rivross-corporate' ) );
$cta_primary_url = get_theme_mod( 'rivross_contact_cta_primary_url', '#properties' );
$cta_secondary_label = get_theme_mod( 'rivross_contact_cta_secondary_label', __( 'Schedule a Consultation', 'rivross-corporate' ) );
$cta_secondary_url = get_theme_mod( 'rivross_contact_cta_secondary_url', '#contact-form' );

$form_markup = '';
if ( class_exists( 'WPCF7_ContactForm' ) ) {
	$contact_forms = WPCF7_ContactForm::find( array( 'title' => 'RIVROSS Contact Inquiry', 'posts_per_page' => 1 ) );
	if ( ! empty( $contact_forms ) ) {
		$form_markup = do_shortcode( $contact_forms[0]->shortcode() );
		$form_markup = str_replace( 'Your information is safe with us. We respect your privacy.', esc_html( $form_privacy ), $form_markup );
		$form_markup = preg_replace_callback(
			'/(<p class="rivross-contact-form__privacy">)\s*<span[^>]*>.*?<\/span>(.*?)<\/p>/s',
			function ( $matches ) {
				return $matches[1] . '<span aria-hidden="true">' . rivross_icon( 'shield' ) . '</span>' . $matches[2] . '</p>';
			},
			$form_markup
		);
	}
}
?>

<section class="contact-hero" style="--contact-hero-image: url('<?php echo esc_url( $hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide contact-hero__inner">
		<nav class="contact-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $breadcrumb_home ); ?></a>
			<span aria-hidden="true">›</span>
			<span><?php echo esc_html( $breadcrumb_page ); ?></span>
		</nav>
		<div class="contact-hero__copy">
			<h1><span><?php echo esc_html( $hero_line_1 ); ?></span><strong><?php echo esc_html( $hero_line_2 ); ?></strong></h1>
			<span class="contact-hero__rule"></span>
			<p><?php echo esc_html( $hero_description ); ?></p>
		</div>
	</div>
</section>

<section class="contact-info-strip" aria-label="<?php esc_attr_e( 'Contact information', 'rivross-corporate' ); ?>">
	<div class="rivross-container rivross-container--wide contact-info-strip__inner">
		<?php foreach ( $contact_items as $item ) : ?>
			<div class="contact-info-item">
				<span class="contact-info-item__icon" aria-hidden="true"><?php echo rivross_icon( rivross_sanitize_icon_choice( $item[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<div class="contact-info-item__copy"><h2><?php echo esc_html( $item[1] ); ?></h2><strong><?php echo esc_html( $item[2] ); ?></strong><?php if ( $item[3] ) : ?><span><?php echo esc_html( $item[3] ); ?></span><?php endif; ?></div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section id="contact-form" class="contact-main">
	<div class="rivross-container rivross-container--wide contact-main__grid">
		<div class="contact-form-card">
			<div class="contact-section-heading"><span class="rivross-eyebrow"><?php echo esc_html( $form_heading ); ?></span><span class="contact-heading-rule"></span></div>
			<?php if ( $form_markup ) : ?>
				<?php echo $form_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php else : ?>
				<p class="contact-form-fallback"><?php esc_html_e( 'The contact form is being prepared. Please check back shortly.', 'rivross-corporate' ); ?></p>
			<?php endif; ?>
		</div>

		<aside class="contact-location-card">
			<div class="contact-section-heading"><span class="rivross-eyebrow"><?php echo esc_html( $map_label ); ?></span><span class="contact-heading-rule"></span></div>
			<div class="contact-map" role="img" aria-label="<?php echo esc_attr( $map_address ); ?>">
				<div class="contact-map__roads contact-map__roads--one"></div><div class="contact-map__roads contact-map__roads--two"></div><div class="contact-map__roads contact-map__roads--three"></div>
				<div class="contact-map__water"></div><span class="contact-map__label contact-map__label--north">Jamebagh Rd</span><span class="contact-map__label contact-map__label--south">Matirari Jame Masjid</span><span class="contact-map__pin" aria-hidden="true"><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			</div>
			<div class="contact-location-card__details">
				<div class="contact-location-card__address"><span aria-hidden="true"><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><p><?php echo esc_html( $map_address ); ?></p></div>
				<a class="rivross-button rivross-button--dark" href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Get Directions', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
		</aside>
	</div>
</section>

<section class="contact-faq contact-section--surface">
	<div class="rivross-container rivross-container--wide contact-faq__grid">
		<div class="contact-faq__intro"><span class="rivross-eyebrow"><?php echo esc_html( $faq_heading_eyebrow ); ?></span><h2><?php echo esc_html( $faq_heading ); ?></h2><p><?php echo esc_html( $faq_description ); ?></p></div>
		<div class="contact-faq__list">
			<?php foreach ( $faqs as $faq ) : if ( '' === trim( $faq[0] ) ) { continue; } ?>
				<details><summary><?php echo esc_html( $faq[0] ); ?><span aria-hidden="true">+</span></summary><div class="contact-faq__answer"><div class="contact-faq__answer-inner"><?php echo esc_html( $faq[1] ); ?></div></div></details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="contact-page-cta" style="--contact-cta-image: url('<?php echo esc_url( $hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide contact-page-cta__inner"><div><h2><?php echo esc_html( $cta_heading ); ?></h2><p><?php echo esc_html( $cta_description ); ?></p></div><div class="contact-page-cta__actions"><a class="rivross-button" href="<?php echo esc_url( rivross_theme_link( $cta_primary_url ) ); ?>"><?php echo esc_html( $cta_primary_label ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><a class="rivross-button rivross-button--outline" href="<?php echo esc_url( rivross_theme_link( $cta_secondary_url ) ); ?>"><?php echo esc_html( $cta_secondary_label ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div></div>
</section>

<?php get_footer(); ?>
