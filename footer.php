<?php
/**
 * RIVROSS site footer.
 *
 * @package Rivross_Corporate
 */
?></main>
<footer class="site-footer" data-rivross-component="footer">
	<?php if ( ! is_home() && ! is_page( array( 'about-us', 'about', 'our-companies', 'contact-us', 'management', 'careers', 'news-media', 'events', 'real-estate', 'projects', 'travel-tourism', 'tea-business', 'terms-and-conditions', 'privacy-policy' ) ) && ! is_page_template( array( 'page-about-us.php', 'page-about.php', 'page-our-companies.php', 'page-contact-us.php', 'page-management.php', 'page-careers.php', 'page-news-media.php', 'page-events.php', 'page-real-estate.php', 'page-projects.php', 'page-travel-tourism.php', 'page-tea-business.php', 'page-legal.php' ) ) && ! is_singular( 'rivross_event' ) && ! is_singular( 'rivross_property' ) && ! is_singular( 'rivross_project' ) && ! is_singular( 'rivross_job' ) && ! is_singular( 'post' ) ) : ?>
	<section class="footer-cta">
		<div class="rivross-container rivross-container--wide footer-cta__inner">
			<div class="footer-cta__icon" aria-hidden="true"><?php echo rivross_icon( rivross_sanitize_icon_choice( get_theme_mod( 'rivross_footer_cta_icon', 'phone' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			<div class="footer-cta__copy">
				<span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_footer_cta_eyebrow', __( 'Connect with RIVROSS', 'rivross-corporate' ) ) ); ?></span>
				<h2><?php echo esc_html( get_theme_mod( 'rivross_footer_cta_title', __( 'Looking for a business opportunity or professional service?', 'rivross-corporate' ) ) ); ?></h2>
				<p><?php echo esc_html( get_theme_mod( 'rivross_footer_cta_description', __( 'Connect with RIVROSS Company Limited today.', 'rivross-corporate' ) ) ); ?></p>
			</div>
			<div class="footer-cta__actions">
				<a class="rivross-button" href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_footer_cta_primary_url', '#contact' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_footer_cta_primary_label', __( 'Send an Inquiry', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<a class="rivross-button rivross-button--outline" href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_footer_cta_secondary_url', '#contact' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_footer_cta_secondary_label', __( 'Contact Us', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<div class="footer-main">
		<div class="rivross-container rivross-container--wide footer-main__grid">
			<div class="footer-brand">
				<?php echo rivross_brand_logo_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php if ( get_bloginfo( 'description' ) ) : ?>
					<p class="footer-brand__tagline"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
				<?php endif; ?>
				<p><?php echo esc_html( get_theme_mod( 'rivross_footer_description', __( 'A diversified business organization committed to delivering value through multiple sectors and creating opportunities for everyone.', 'rivross-corporate' ) ) ); ?></p>
				<div class="footer-socials" aria-label="<?php esc_attr_e( 'Social media links', 'rivross-corporate' ); ?>">
					<?php foreach ( array( 'facebook' => 'Facebook', 'linkedin' => 'LinkedIn', 'youtube' => 'YouTube', 'instagram' => 'Instagram' ) as $icon => $label ) : ?>
						<a href="<?php echo esc_url( get_theme_mod( 'rivross_social_' . $icon, '#' ) ); ?>" aria-label="<?php echo esc_attr( $label ); ?>"><?php echo rivross_icon( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="footer-column">
				<h3><?php echo esc_html( get_theme_mod( 'rivross_footer_quick_links_title', __( 'Quick Links', 'rivross-corporate' ) ) ); ?></h3>
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'footer-links', 'container' => false, 'fallback_cb' => 'rivross_footer_menu_fallback' ) ); ?>
			</div>

			<div class="footer-column">
				<h3><?php echo esc_html( get_theme_mod( 'rivross_footer_businesses_title', __( 'Our Businesses', 'rivross-corporate' ) ) ); ?></h3>
				<ul class="footer-links">
					<?php
					$footer_business_defaults = array( array( 'Real Estate', home_url( '/real-estate/' ) ), array( 'Travel & Tourism', home_url( '/travel-tourism/' ) ), array( 'Tea Business', home_url( '/tea-business/' ) ) );
					foreach ( $footer_business_defaults as $index => $business ) :
						$number = $index + 1;
						$label  = get_theme_mod( 'rivross_footer_business_' . $number . '_label', $business[0] );
						$url    = get_theme_mod( 'rivross_footer_business_' . $number . '_url', $business[1] );
						if ( 1 === $number && in_array( trim( (string) $url ), array( '#real-estate', home_url( '/#real-estate' ) ), true ) ) { $url = home_url( '/real-estate/' ); }
						?><li><a href="<?php echo esc_url( rivross_theme_link( $url ) ); ?>"><?php echo esc_html( $label ); ?></a></li><?php
					endforeach;
					?>
				</ul>
			</div>

			<div class="footer-column footer-contact">
				<h3><?php echo esc_html( get_theme_mod( 'rivross_footer_contact_title', __( 'Contact Information', 'rivross-corporate' ) ) ); ?></h3>
				<ul class="footer-contact__list">
					<li><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( get_theme_mod( 'rivross_contact_address', '3/3 Matuail Junglebari, Jatrabari, Dhaka-1362, Bangladesh' ) ); ?></span></li>
					<li><a href="mailto:<?php echo esc_attr( get_theme_mod( 'rivross_contact_email', 'rivrossgroup@gmail.com' ) ); ?>"><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( get_theme_mod( 'rivross_contact_email', 'rivrossgroup@gmail.com' ) ); ?></span></a></li>
					<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', get_theme_mod( 'rivross_contact_phone', '01796-566279' ) ) ); ?>"><?php echo rivross_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( get_theme_mod( 'rivross_contact_phone', '01796-566279' ) ); ?></span></a></li>
					<li><?php echo rivross_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( get_theme_mod( 'rivross_footer_hours', __( 'Saturday - Thursday | 10:00 AM - 07:00 PM', 'rivross-corporate' ) ) ); ?></span></li>
				</ul>
			</div>

			<div class="footer-column">
				<h3><?php echo esc_html( get_theme_mod( 'rivross_footer_legal_title', __( 'Legal', 'rivross-corporate' ) ) ); ?></h3>
				<ul class="footer-links">
					<li><a href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_footer_legal_1_url', home_url( '/terms-and-conditions/' ) ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_footer_legal_1_label', __( 'Terms & Conditions', 'rivross-corporate' ) ) ); ?></a></li>
					<li><a href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_footer_legal_2_url', home_url( '/privacy-policy/' ) ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_footer_legal_2_label', __( 'Privacy Policy', 'rivross-corporate' ) ) ); ?></a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="rivross-container rivross-container--wide footer-bottom__inner">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_theme_mod( 'rivross_footer_copyright', __( 'RIVROSS Company Limited. All Rights Reserved.', 'rivross-corporate' ) ) ); ?></span>
			<span><?php echo esc_html( get_theme_mod( 'rivross_footer_bottom_note', __( 'Designed with Excellence for a Better Tomorrow', 'rivross-corporate' ) ) ); ?></span>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
