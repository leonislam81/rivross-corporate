<?php
/**
 * RIVROSS site header.
 *
 * @package Rivross_Corporate
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $site_tagline = get_bloginfo( 'description' ); ?>
	<?php if ( $site_tagline ) : ?>
		<meta name="description" content="<?php echo esc_attr( $site_tagline ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#primary"><?php esc_html_e( 'Skip to content', 'rivross-corporate' ); ?></a>
<header class="site-header" data-rivross-component="header">
	<div class="rivross-container rivross-container--wide site-header__inner">
		<div class="site-brand">
			<?php echo rivross_brand_logo_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>

		<button class="site-nav__toggle" type="button" aria-expanded="false" aria-controls="primary-navigation">
			<span class="screen-reader-text"><?php esc_html_e( 'Toggle navigation', 'rivross-corporate' ); ?></span>
			<span></span><span></span><span></span>
		</button>

		<nav id="primary-navigation" class="site-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'rivross-corporate' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'site-nav__list',
					'container'      => false,
					'fallback_cb'    => 'rivross_primary_menu_fallback',
				)
			);
			?>
		</nav>

		<a class="site-header__inquiry rivross-button" href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_inquiry_url', home_url( '/#contact' ) ) ) ); ?>">
			<span><?php echo esc_html( get_theme_mod( 'rivross_header_inquiry_label', __( 'Inquiry', 'rivross-corporate' ) ) ); ?></span>
			<?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>
	</div>
</header>
<main id="primary" class="site-main">
