<?php
/**
 * Global under-construction and coming-soon access mode.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return whether the public site access screen is enabled.
 *
 * @return bool
 */
function rivross_maintenance_mode_enabled() {
	return (bool) get_theme_mod( 'rivross_maintenance_enabled', false );
}

/**
 * Return the selected public access screen.
 *
 * @return string
 */
function rivross_maintenance_variant() {
	$variant = get_theme_mod( 'rivross_maintenance_variant', 'under-construction' );
	return in_array( $variant, array( 'under-construction', 'coming-soon' ), true ) ? $variant : 'under-construction';
}

/**
 * Sanitize the access screen choice in the Customizer.
 *
 * @param mixed $value Submitted value.
 * @return string
 */
function rivross_sanitize_maintenance_variant( $value ) {
	return in_array( $value, array( 'under-construction', 'coming-soon' ), true ) ? $value : 'under-construction';
}

/**
 * Keep the under-construction progress value between 0 and 100.
 *
 * @param mixed $value Submitted percentage.
 * @return int
 */
function rivross_sanitize_maintenance_percentage( $value ) {
	return min( 100, max( 0, absint( $value ) ) );
}

/**
 * Return editable maintenance copy, falling back when a field is empty.
 *
 * @param string $setting_id Theme mod key.
 * @param string $default Default copy.
 * @return string
 */
function rivross_maintenance_text( $setting_id, $default ) {
	$value = get_theme_mod( $setting_id, $default );
	return '' !== trim( (string) $value ) ? (string) $value : $default;
}

/**
 * Administrators and internal WordPress requests must retain full access.
 *
 * @return bool
 */
function rivross_maintenance_admin_bypass() {
	if ( is_admin() || ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) ) {
		return true;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return true;
	}
	if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
		return true;
	}

	return is_user_logged_in() && current_user_can( 'manage_options' );
}

/**
 * Return whether the current front-end request should show the access screen.
 *
 * @return bool
 */
function rivross_should_render_maintenance() {
	return rivross_maintenance_mode_enabled() && ! rivross_maintenance_admin_bypass();
}

/**
 * Replace every public front-end route with the selected access screen.
 *
 * @return void
 */
function rivross_maintenance_template_redirect() {
	if ( ! rivross_should_render_maintenance() ) {
		return;
	}

	status_header( 503 );
	nocache_headers();
	include get_template_directory() . '/template-maintenance.php';
	exit;
}
add_action( 'template_redirect', 'rivross_maintenance_template_redirect', 0 );
