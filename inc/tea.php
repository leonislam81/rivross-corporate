<?php
/**
 * Tea Business page bootstrap.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rivross_seed_tea_page() {
	if ( get_page_by_path( 'tea-business' ) ) {
		return;
	}

	wp_insert_post(
		array(
			'post_title'  => __( 'Tea Business', 'rivross-corporate' ),
			'post_name'   => 'tea-business',
			'post_type'   => 'page',
			'post_status' => 'publish',
		)
	);
}
add_action( 'init', 'rivross_seed_tea_page', 20 );

function rivross_seed_tea_form() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) || ! empty( WPCF7_ContactForm::find( array( 'title' => 'RIVROSS Tea Inquiry', 'posts_per_page' => 1 ) ) ) ) {
		return;
	}

	$icon = static function ( $name ) {
		return function_exists( 'rivross_icon' ) ? rivross_icon( $name ) : '';
	};
	$form_markup = '<div class="tea-cf7-fields">'
		. '<div class="tea-cf7-field"><label><span class="tea-cf7-control"><span class="tea-cf7-icon">' . $icon( 'users' ) . '</span>[text* tea-name autocomplete:name placeholder "Full Name"]</span></label></div>'
		. '<div class="tea-cf7-field"><label><span class="tea-cf7-control"><span class="tea-cf7-icon">' . $icon( 'mail' ) . '</span>[email* tea-email autocomplete:email placeholder "Email Address"]</span></label></div>'
		. '<div class="tea-cf7-field"><label><span class="tea-cf7-control"><span class="tea-cf7-icon">' . $icon( 'building' ) . '</span>[text tea-company placeholder "Company Name"]</span></label></div>'
		. '<div class="tea-cf7-field"><label><span class="tea-cf7-control"><span class="tea-cf7-icon">' . $icon( 'folder' ) . '</span>[select tea-requirement first_as_label "Requirement Type" "Tea Sourcing" "Wholesale Supply" "Distribution" "Corporate Supply"]</span></label></div>'
		. '<div class="tea-cf7-field"><label><span class="tea-cf7-control"><span class="tea-cf7-icon">' . $icon( 'phone' ) . '</span>[tel tea-phone autocomplete:tel placeholder "Phone Number"]</span></label></div>'
		. '<div class="tea-cf7-field tea-cf7-field--message"><label><span class="tea-cf7-control"><span class="tea-cf7-icon tea-cf7-icon--top">' . $icon( 'news' ) . '</span>[textarea tea-message placeholder "Tell us about your requirement..."]</span></label></div>'
		. '<div class="tea-cf7-submit">[submit class:rivross-button "Submit Inquiry →"]</div>'
		. '</div>';

	$form = WPCF7_ContactForm::get_template( array( 'title' => 'RIVROSS Tea Inquiry' ) );
	$mail = (array) $form->prop( 'mail' );
	$mail['subject']            = 'Tea business inquiry from [tea-name]';
	$mail['sender']             = 'RIVROSS Website <wordpress@' . wp_parse_url( home_url(), PHP_URL_HOST ) . '>';
	$mail['recipient']          = get_theme_mod( 'rivross_contact_email', get_option( 'admin_email' ) );
	$mail['body']               = "Name: [tea-name]\nEmail: [tea-email]\nCompany: [tea-company]\nRequirement: [tea-requirement]\nPhone: [tea-phone]\n\nMessage:\n[tea-message]";
	$mail['additional_headers'] = 'Reply-To: [tea-email]';
	$form->set_properties( array( 'form' => $form_markup, 'mail' => $mail ) );
	$form->save();
}
add_action( 'init', 'rivross_seed_tea_form', 25 );
