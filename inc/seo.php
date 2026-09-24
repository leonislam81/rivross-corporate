<?php
/**
 * Conservative SEO fallbacks for installations without an SEO plugin.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Return whether a major SEO plugin already owns head metadata. */
function rivross_seo_plugin_active() {
	$plugin_constants = array(
		'WPSEO_VERSION',
		'RANK_MATH_VERSION',
		'AIOSEO_VERSION',
		'SEOPRESS_VERSION',
		'THE_SEO_FRAMEWORK_VERSION',
		'SLIM_SEO_VERSION',
		'WPSSO_VERSION',
	);

	foreach ( $plugin_constants as $constant ) {
		if ( defined( $constant ) ) {
			return true;
		}
	}

	return class_exists( 'WPSEO_Options' ) || class_exists( 'AIOSEO\Plugin\AIOSEO' ) || function_exists( 'rank_math' );
}

/** Build a short, plain-text description for the current view. */
function rivross_seo_description() {
	$description = '';
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			$description = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( $post->post_content ), 30, '…' );
		}
	}

	if ( '' === trim( (string) $description ) ) {
		$description = get_bloginfo( 'description' );
	}
	if ( '' === trim( (string) $description ) ) {
		$description = sprintf( __( '%s — corporate information, projects and opportunities.', 'rivross-corporate' ), get_bloginfo( 'name' ) );
	}

	return trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( (string) $description ) ) );
}

/** Print metadata only when an SEO plugin is not already active. */
function rivross_seo_fallback_head() {
	if ( is_admin() || rivross_seo_plugin_active() ) {
		return;
	}

	$description = rivross_seo_description();
	if ( $description ) {
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}

	if ( ! is_front_page() ) {
		return;
	}

	$logo = get_template_directory_uri() . '/assets/images/brand/rivross-main-logo-transparent.png';
	$schema  = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
		'name'     => get_bloginfo( 'name' ),
		'url'      => home_url( '/' ),
	);
	if ( $logo ) {
		$schema['logo'] = $logo;
	}
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) . '</script>' . "\n";
}
add_action( 'wp_head', 'rivross_seo_fallback_head', 1 );
