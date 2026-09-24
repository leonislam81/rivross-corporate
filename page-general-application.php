<?php
/**
 * General Careers application page.
 *
 * @package Rivross_Corporate
 */

get_header();

$careers_page = get_page_by_path( 'careers' );
$careers_url  = $careers_page ? get_permalink( $careers_page ) : home_url( '/careers/' );
$hero_image   = get_theme_mod( 'rivross_careers_hero_image', get_theme_file_uri( '/assets/images/careers/careers-hero.png' ) );
$form_markup  = '';

if ( class_exists( 'WPCF7_ContactForm' ) ) {
	$forms = WPCF7_ContactForm::find( array( 'title' => 'RIVROSS General Application', 'posts_per_page' => 1 ) );
	if ( ! empty( $forms ) ) {
		$form_markup = do_shortcode( $forms[0]->shortcode() );
	}
}
?>

<section class="career-application-hero" style="--career-application-image: url('<?php echo esc_url( $hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide career-application-hero__inner">
		<nav class="career-application-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rivross-corporate' ); ?></a><span aria-hidden="true">›</span>
			<a href="<?php echo esc_url( $careers_url ); ?>"><?php esc_html_e( 'Careers', 'rivross-corporate' ); ?></a><span aria-hidden="true">›</span>
			<span><?php esc_html_e( 'Submit Your CV', 'rivross-corporate' ); ?></span>
		</nav>
		<div class="career-application-hero__copy">
			<span class="rivross-eyebrow"><?php esc_html_e( 'RIVROSS CAREERS', 'rivross-corporate' ); ?></span>
			<h1><?php esc_html_e( 'Submit Your CV', 'rivross-corporate' ); ?></h1>
			<span class="career-application-hero__rule"></span>
			<p><?php esc_html_e( 'Tell us about your experience and the kind of work you want to do. We will keep your profile in mind for the right opportunity.', 'rivross-corporate' ); ?></p>
		</div>
	</div>
</section>

<main class="career-application-main">
	<div class="rivross-container rivross-container--wide">
		<div class="career-application-grid">
			<aside class="career-application-intro">
				<span class="rivross-eyebrow"><?php esc_html_e( 'JOIN OUR TEAM', 'rivross-corporate' ); ?></span>
				<h2><?php esc_html_e( 'Build a Better Tomorrow With Us', 'rivross-corporate' ); ?></h2>
				<span class="career-application-rule"></span>
				<p><?php esc_html_e( 'RIVROSS brings together people who care about thoughtful growth, dependable service and the communities we serve.', 'rivross-corporate' ); ?></p>
				<ul>
					<li><?php esc_html_e( 'Explore roles across our growing businesses.', 'rivross-corporate' ); ?></li>
					<li><?php esc_html_e( 'Work with a collaborative, supportive team.', 'rivross-corporate' ); ?></li>
					<li><?php esc_html_e( 'Grow through meaningful projects and opportunities.', 'rivross-corporate' ); ?></li>
				</ul>
				<a class="rivross-button rivross-button--outline-dark" href="<?php echo esc_url( trailingslashit( $careers_url ) . '#open-positions' ); ?>">
					<?php esc_html_e( 'View Open Positions', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			</aside>

			<section id="general-application-form" class="career-application-card" aria-labelledby="general-application-title">
				<span class="rivross-eyebrow"><?php esc_html_e( 'GENERAL APPLICATION', 'rivross-corporate' ); ?></span>
				<h2 id="general-application-title"><?php esc_html_e( 'Share Your Profile', 'rivross-corporate' ); ?></h2>
				<span class="career-application-rule"></span>
				<p class="career-application-card__intro"><?php esc_html_e( 'Complete the form below and attach your latest CV. Our team will contact you when a suitable opportunity is available.', 'rivross-corporate' ); ?></p>
				<?php if ( $form_markup ) : ?>
					<div class="career-general-form"><?php echo $form_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<?php else : ?>
					<p class="career-application-fallback"><?php esc_html_e( 'The application form is being prepared. Please email your CV to', 'rivross-corporate' ); ?> <a href="mailto:<?php echo esc_attr( get_theme_mod( 'rivross_contact_email', get_option( 'admin_email' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_contact_email', get_option( 'admin_email' ) ) ); ?></a>.</p>
				<?php endif; ?>
			</section>
		</div>
	</div>
</main>

<?php get_footer(); ?>
