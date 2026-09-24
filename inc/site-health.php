<?php
/**
 * RIVROSS checks for the WordPress Site Health screen.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Add theme health checks without exposing private site data. */
function rivross_site_health_tests( $tests ) {
	$tests['direct']['rivross_theme'] = array(
		'label' => __( 'RIVROSS theme setup', 'rivross-corporate' ),
		'test'  => 'rivross_run_theme_health_test',
	);
	return $tests;
}
add_filter( 'site_status_tests', 'rivross_site_health_tests' );

/** Verify the active theme and the content types used by the site. */
function rivross_run_theme_health_test() {
	$theme       = wp_get_theme();
	$required    = array( 'rivross_hero_slide', 'rivross_property', 'rivross_project', 'rivross_event', 'rivross_job', 'rivross_leader' );
	$missing     = array_values( array_filter( $required, static function ( $post_type ) { return ! post_type_exists( $post_type ); } ) );
	$mail_target = sanitize_email( get_theme_mod( 'rivross_contact_email', get_option( 'admin_email' ) ) );
	$mail_ready  = is_email( $mail_target );
	$is_rivross  = 'rivross-corporate' === $theme->get_stylesheet();
	$is_healthy  = $is_rivross && empty( $missing ) && $mail_ready;
	$description = $is_healthy
		? __( 'The RIVROSS theme and its editable content types are registered correctly.', 'rivross-corporate' )
		: __( 'The active theme or one or more RIVROSS content types need attention. Re-save the theme or contact the site administrator.', 'rivross-corporate' );

	if ( ! empty( $missing ) ) {
		$description .= ' ' . sprintf( __( 'Missing: %s.', 'rivross-corporate' ), implode( ', ', array_map( 'esc_html', $missing ) ) );
	}
	if ( ! $mail_ready ) {
		$description .= ' ' . __( 'The contact email used for enquiries and applications is not configured.', 'rivross-corporate' );
	}

	return array(
		'label'       => $is_healthy ? __( 'RIVROSS theme is ready', 'rivross-corporate' ) : __( 'RIVROSS theme needs attention', 'rivross-corporate' ),
	'status'      => $is_healthy ? 'good' : 'recommended',
	'badge'       => array( 'label' => __( 'RIVROSS', 'rivross-corporate' ), 'color' => $is_healthy ? 'green' : 'orange' ),
	'description' => '<p>' . esc_html( $description ) . '</p>',
		'actions'     => '',
	);
}
