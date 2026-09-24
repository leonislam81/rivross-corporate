<?php
/**
 * Template Name: Legal Page
 * Template Post Type: page
 *
 * @package Rivross_Corporate
 */

get_header();
$is_privacy = is_page( 'privacy-policy' );
$eyebrow    = $is_privacy ? __( 'Your privacy matters', 'rivross-corporate' ) : __( 'Please read carefully', 'rivross-corporate' );
$intro      = $is_privacy
	? __( 'How RIVROSS collects, uses and protects information submitted through this website.', 'rivross-corporate' )
	: __( 'The terms that apply when you use the RIVROSS Company Limited website and contact our team.', 'rivross-corporate' );
?>

<main class="legal-page">
	<section class="legal-hero">
		<div class="rivross-container rivross-container--wide legal-hero__inner">
			<nav class="legal-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rivross-corporate' ); ?></a>
				<span aria-hidden="true">/</span>
				<span><?php the_title(); ?></span>
			</nav>
			<div class="legal-hero__copy">
				<span class="rivross-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
				<h1><?php the_title(); ?></h1>
				<span class="legal-hero__rule" aria-hidden="true"></span>
				<p><?php echo esc_html( $intro ); ?></p>
			</div>
		</div>
	</section>

	<section class="legal-content">
		<div class="rivross-container rivross-container--narrow">
			<article class="legal-content__card">
				<div class="legal-content__updated">
					<?php
					printf(
						/* translators: %s: page modified date. */
						esc_html__( 'Last updated: %s', 'rivross-corporate' ),
						esc_html( get_the_modified_date( get_option( 'date_format' ) ) )
					);
					?>
				</div>
				<div class="legal-content__body">
					<?php
					while ( have_posts() ) :
						the_post();
						the_content();
					endwhile;
					?>
				</div>
			</article>
		</div>
	</section>
</main>

<?php get_footer(); ?>

