<?php
/**
 * Travel & Tourism page bootstrap.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create the dedicated Travel & Tourism page when a fresh install does not
 * have one yet. Editors can then change its content and URL normally.
 *
 * @return void
 */
function rivross_seed_travel_page() {
	if ( get_page_by_path( 'travel-tourism' ) ) {
		return;
	}

	wp_insert_post(
		array(
			'post_title'  => __( 'Travel & Tourism', 'rivross-corporate' ),
			'post_name'   => 'travel-tourism',
			'post_type'   => 'page',
			'post_status' => 'publish',
		)
	);
}
add_action( 'init', 'rivross_seed_travel_page', 20 );

/**
 * Create the page-specific Contact Form 7 form once, keeping delivery in the
 * same plugin workflow as the main Contact Us page.
 *
 * @return void
 */
function rivross_seed_travel_form() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) || ! empty( WPCF7_ContactForm::find( array( 'title' => 'RIVROSS Travel Inquiry', 'posts_per_page' => 1 ) ) ) ) {
		return;
	}

	$icon = static function ( $name ) {
		return function_exists( 'rivross_icon' ) ? rivross_icon( $name ) : '';
	};
	$form_markup = '<div class="travel-cf7-fields">'
		. '<div class="travel-cf7-field"><label><span class="travel-cf7-label">Full Name</span><span class="travel-cf7-control"><span class="travel-cf7-icon">' . $icon( 'users' ) . '</span>[text* travel-name autocomplete:name placeholder "Full Name"]</span></label></div>'
		. '<div class="travel-cf7-field"><label><span class="travel-cf7-label">Email Address</span><span class="travel-cf7-control"><span class="travel-cf7-icon">' . $icon( 'mail' ) . '</span>[email* travel-email autocomplete:email placeholder "Email Address"]</span></label></div>'
		. '<div class="travel-cf7-field"><label><span class="travel-cf7-label">Phone Number</span><span class="travel-cf7-control"><span class="travel-cf7-icon">' . $icon( 'phone' ) . '</span>[tel travel-phone autocomplete:tel placeholder "Phone Number"]</span></label></div>'
		. '<div class="travel-cf7-field"><label><span class="travel-cf7-label">Travel Type</span><span class="travel-cf7-control"><span class="travel-cf7-icon">' . $icon( 'globe' ) . '</span>[select travel-type first_as_label "Travel Type" "Air Ticketing" "Hotel Booking" "Tour Package" "Hajj & Umrah" "Corporate Travel"]</span></label></div>'
		. '<div class="travel-cf7-field travel-cf7-field--message"><label><span class="travel-cf7-label">Tell us about your trip</span><span class="travel-cf7-control"><span class="travel-cf7-icon travel-cf7-icon--top">' . $icon( 'news' ) . '</span>[textarea travel-message placeholder "Tell us about your trip..."]</span></label></div>'
		. '<div class="travel-cf7-submit">[submit class:rivross-button "Send Inquiry →"]</div>'
		. '</div>';

	$form = WPCF7_ContactForm::get_template( array( 'title' => 'RIVROSS Travel Inquiry' ) );
	$mail = (array) $form->prop( 'mail' );
	$mail['subject']            = 'Travel inquiry from [travel-name]';
	$mail['sender']             = 'RIVROSS Website <wordpress@' . wp_parse_url( home_url(), PHP_URL_HOST ) . '>';
	$mail['recipient']          = get_theme_mod( 'rivross_contact_email', get_option( 'admin_email' ) );
	$mail['body']               = "Name: [travel-name]\nEmail: [travel-email]\nPhone: [travel-phone]\nTravel type: [travel-type]\n\nMessage:\n[travel-message]";
	$mail['additional_headers'] = 'Reply-To: [travel-email]';
	$form->set_properties( array( 'form' => $form_markup, 'mail' => $mail ) );
	$form->save();
}
add_action( 'init', 'rivross_seed_travel_form', 25 );
