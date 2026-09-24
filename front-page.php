<?php
/**
 * Front-page router.
 *
 * WordPress always checks front-page.php first for the selected static
 * homepage. Delegate to that page's assigned template so the Reading
 * Settings selection remains authoritative instead of forcing one design.
 *
 * @package Rivross_Corporate
 */

$front_page_id = (int) get_option( 'page_on_front' );
$page_template = $front_page_id ? get_page_template_slug( $front_page_id ) : '';
$page_slug     = $front_page_id ? get_post_field( 'post_name', $front_page_id ) : '';

/* Respect an explicitly assigned template, then WordPress's page-{slug}.php
 * convention used by the existing RIVROSS page templates. */
$template_candidates = array();
if ( $page_template && 'front-page.php' !== $page_template ) {
	$template_candidates[] = $page_template;
}
if ( $page_slug ) {
	$template_candidates[] = 'page-' . sanitize_file_name( $page_slug ) . '.php';
}

if ( ! empty( $template_candidates ) ) {
	$located_template = locate_template( array_unique( $template_candidates ), false, false );
	if ( $located_template ) {
		include $located_template;
		return;
	}
}

/* A page without a custom template uses the normal page renderer. */
$fallback_template = locate_template( array( 'page.php', 'index.php' ), false, false );
if ( $fallback_template ) {
	include $fallback_template;
	return;
}

get_header();
get_footer();
