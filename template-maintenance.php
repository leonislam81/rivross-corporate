<?php
/**
 * Public under-construction / coming-soon screen.
 *
 * @package Rivross_Corporate
 */

$variant = rivross_maintenance_variant();
$email   = sanitize_email( get_theme_mod( 'rivross_contact_email', 'rivrossgroup@gmail.com' ) );
$phone   = (string) get_theme_mod( 'rivross_contact_phone', '01796-566279' );
$phone_href = preg_replace( '/[^0-9+]/', '', $phone );
$contact_href = 'mailto:' . $email . '?subject=' . rawurlencode( 'RIVROSS website launch' );
$home_href = home_url( '/' );
$socials = array( 'facebook' => 'Facebook', 'linkedin' => 'LinkedIn', 'youtube' => 'YouTube', 'instagram' => 'Instagram' );
$status_label = 'coming-soon' === $variant
	? rivross_maintenance_text( 'rivross_maintenance_cs_status', 'Coming Soon' )
	: rivross_maintenance_text( 'rivross_maintenance_uc_status', 'Under Construction' );
$uc = array(
	'eyebrow'        => rivross_maintenance_text( 'rivross_maintenance_uc_eyebrow', 'RIVROSS Company Limited' ),
	'heading_1'       => rivross_maintenance_text( 'rivross_maintenance_uc_heading_1', 'Under' ),
	'heading_2'       => rivross_maintenance_text( 'rivross_maintenance_uc_heading_2', 'Construction' ),
	'description'    => rivross_maintenance_text( 'rivross_maintenance_uc_description', 'We’re building something exceptional. Our new website is coming soon. Please check back shortly.' ),
	'progress_label'  => rivross_maintenance_text( 'rivross_maintenance_uc_progress_label', 'Site Progress' ),
	'progress'        => rivross_sanitize_maintenance_percentage( get_theme_mod( 'rivross_maintenance_uc_progress', 75 ) ),
	'launch_label'    => rivross_maintenance_text( 'rivross_maintenance_uc_launch_label', 'Launching Soon' ),
	'button_label'    => rivross_maintenance_text( 'rivross_maintenance_uc_button_label', 'Back to Home' ),
);
$cs = array(
	'eyebrow'       => rivross_maintenance_text( 'rivross_maintenance_cs_eyebrow', 'We’re preparing something exceptional.' ),
	'heading_1'      => rivross_maintenance_text( 'rivross_maintenance_cs_heading_1', 'Coming' ),
	'heading_2'      => rivross_maintenance_text( 'rivross_maintenance_cs_heading_2', 'Soon' ),
	'description'   => rivross_maintenance_text( 'rivross_maintenance_cs_description', 'Our new website is almost ready. Please check back soon.' ),
	'days'          => rivross_maintenance_text( 'rivross_maintenance_cs_days', '00' ),
	'days_label'    => rivross_maintenance_text( 'rivross_maintenance_cs_days_label', 'Days' ),
	'hours'         => rivross_maintenance_text( 'rivross_maintenance_cs_hours', '00' ),
	'hours_label'   => rivross_maintenance_text( 'rivross_maintenance_cs_hours_label', 'Hours' ),
	'minutes'       => rivross_maintenance_text( 'rivross_maintenance_cs_minutes', '00' ),
	'minutes_label' => rivross_maintenance_text( 'rivross_maintenance_cs_minutes_label', 'Minutes' ),
	'seconds'       => rivross_maintenance_text( 'rivross_maintenance_cs_seconds', '00' ),
	'seconds_label' => rivross_maintenance_text( 'rivross_maintenance_cs_seconds_label', 'Seconds' ),
	'notify_label'  => rivross_maintenance_text( 'rivross_maintenance_cs_notify_label', 'Contact us to receive launch updates' ),
	'button_label'  => rivross_maintenance_text( 'rivross_maintenance_cs_button_label', 'Back to Home' ),
);
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<?php wp_head(); ?>
</head>
<body <?php body_class( array( 'rivross-maintenance-page', 'rivross-maintenance-page--' . $variant ) ); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) { wp_body_open(); } ?>
	<div class="rivross-maintenance" data-maintenance-mode="<?php echo esc_attr( $variant ); ?>">
		<header class="rivross-maintenance__header">
			<div class="rivross-maintenance__brand">
				<?php echo rivross_brand_logo_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div class="rivross-maintenance__status">
				<span aria-hidden="true">•</span>
				<?php echo esc_html( $status_label ); ?>
				<span aria-hidden="true">•</span>
			</div>
		</header>

		<main class="rivross-maintenance__main" id="maintenance-content">
			<?php if ( 'coming-soon' === $variant ) : ?>
				<div class="rivross-maintenance__main-brand">
					<?php echo rivross_brand_logo_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			<?php else : ?>
				<div class="rivross-maintenance__main-brand">
					<?php echo rivross_brand_logo_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			<?php endif; ?>

			<?php if ( 'coming-soon' === $variant ) : ?>
				<p class="rivross-maintenance__eyebrow"><?php echo esc_html( $cs['eyebrow'] ); ?></p>
				<h1><span><?php echo esc_html( $cs['heading_1'] ); ?></span><strong><?php echo esc_html( $cs['heading_2'] ); ?></strong></h1>
				<p class="rivross-maintenance__intro"><?php echo esc_html( $cs['description'] ); ?></p>
				<div class="rivross-maintenance__accent" aria-hidden="true"><span></span></div>
				<a class="rivross-button rivross-maintenance__button" href="<?php echo esc_url( $home_href ); ?>"><?php echo esc_html( $cs['button_label'] ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			<?php else : ?>
				<h1><span><?php echo esc_html( $uc['heading_1'] ); ?></span><strong><?php echo esc_html( $uc['heading_2'] ); ?></strong></h1>
				<p class="rivross-maintenance__intro"><?php echo esc_html( $uc['description'] ); ?></p>
				<div class="rivross-maintenance__accent" aria-hidden="true"><span></span></div>
				<a class="rivross-button rivross-maintenance__button" href="<?php echo esc_url( $home_href ); ?>"><?php echo esc_html( $uc['button_label'] ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			<?php endif; ?>
		</main>

		<footer class="rivross-maintenance__footer">
			<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $email ); ?></span></a>
			<a href="tel:<?php echo esc_attr( $phone_href ); ?>"><?php echo rivross_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $phone ); ?></span></a>
			<nav class="rivross-maintenance__socials" aria-label="<?php esc_attr_e( 'Social media links', 'rivross-corporate' ); ?>">
			<?php foreach ( $socials as $icon => $label ) : $social_url = get_theme_mod( 'rivross_social_' . $icon, '' ); ?>
				<?php if ( $social_url && '#' !== $social_url ) : ?>
					<a href="<?php echo esc_url( $social_url ); ?>" aria-label="<?php echo esc_attr( $label ); ?>" target="_blank" rel="noopener noreferrer"><?php echo rivross_icon( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<?php endif; ?>
				<?php endforeach; ?>
			</nav>
		</footer>
	</div>
	<?php wp_footer(); ?>
</body>
</html>
