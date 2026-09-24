<?php
/**
 * Lightweight local newsletter subscriptions.
 *
 * The public forms intentionally store subscribers in a WordPress option
 * instead of sending mail. A production newsletter provider can be attached
 * later through the rivross_newsletter_subscribed action.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the hidden fields shared by all public newsletter forms.
 *
 * @param string $source Form source label.
 * @return string
 */
function rivross_newsletter_form_fields( $source = 'website' ) {
	$source = sanitize_key( $source );

	ob_start();
	?>
	<input type="hidden" name="rivross_newsletter_source" value="<?php echo esc_attr( $source ); ?>">
	<?php wp_nonce_field( 'rivross_newsletter_subscribe', 'rivross_newsletter_nonce', true, true ); ?>
	<div class="rivross-newsletter-honeypot" aria-hidden="true">
		<label for="rivross-newsletter-website"><?php esc_html_e( 'Leave this field empty', 'rivross-corporate' ); ?></label>
		<input id="rivross-newsletter-website" type="text" name="rivross_newsletter_website" value="" tabindex="-1" autocomplete="off">
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Redirect back to the originating page with a safe subscription status.
 *
 * @param string $status Result key.
 * @return void
 */
function rivross_newsletter_redirect( $status ) {
	$redirect = wp_get_referer();
	$redirect = wp_validate_redirect( $redirect, home_url( '/' ) );
	$redirect = remove_query_arg( 'newsletter_status', $redirect );
	wp_safe_redirect( add_query_arg( 'newsletter_status', sanitize_key( $status ), $redirect ) );
	exit;
}

/**
 * Process a public newsletter subscription without sending email.
 *
 * @return void
 */
function rivross_handle_newsletter_subscription() {
	if ( 'POST' !== strtoupper( (string) ( $_SERVER['REQUEST_METHOD'] ?? '' ) ) || ! isset( $_POST['newsletter_email'] ) ) {
		return;
	}

	$nonce = isset( $_POST['rivross_newsletter_nonce'] ) && is_scalar( $_POST['rivross_newsletter_nonce'] )
		? sanitize_text_field( wp_unslash( $_POST['rivross_newsletter_nonce'] ) )
		: '';
	if ( ! $nonce || ! wp_verify_nonce( $nonce, 'rivross_newsletter_subscribe' ) ) {
		rivross_newsletter_redirect( 'error' );
	}

	if ( ! empty( $_POST['rivross_newsletter_website'] ) ) {
		rivross_newsletter_redirect( 'error' );
	}

	$email = sanitize_email( wp_unslash( $_POST['newsletter_email'] ) );
	if ( ! is_email( $email ) ) {
		rivross_newsletter_redirect( 'invalid' );
	}
	$email  = strtolower( $email );
	$source = isset( $_POST['rivross_newsletter_source'] ) ? sanitize_key( wp_unslash( $_POST['rivross_newsletter_source'] ) ) : 'website';

	$subscribers = get_option( 'rivross_newsletter_subscribers', array() );
	$subscribers = is_array( $subscribers ) ? $subscribers : array();
	foreach ( $subscribers as $subscriber ) {
		if ( is_array( $subscriber ) && isset( $subscriber['email'] ) && strtolower( (string) $subscriber['email'] ) === $email ) {
			rivross_newsletter_redirect( 'already_subscribed' );
		}
	}

	$subscribers[] = array(
		'email'         => $email,
		'source'        => $source ? $source : 'website',
		'subscribed_at' => current_time( 'mysql' ),
	);
	update_option( 'rivross_newsletter_subscribers', $subscribers, false );

	do_action( 'rivross_newsletter_subscribed', $email, $source );
	rivross_newsletter_redirect( 'subscribed' );
}
add_action( 'template_redirect', 'rivross_handle_newsletter_subscription', 1 );

/**
 * Render a one-time notice after a subscription redirect.
 *
 * @return string
 */
function rivross_newsletter_notice() {
	static $rendered = false;
	if ( $rendered || empty( $_GET['newsletter_status'] ) ) {
		return '';
	}
	$rendered = true;

	$status = sanitize_key( wp_unslash( $_GET['newsletter_status'] ) );
	$messages = array(
		'subscribed'         => __( 'Thanks for subscribing. We will keep you updated.', 'rivross-corporate' ),
		'already_subscribed' => __( 'This email is already subscribed.', 'rivross-corporate' ),
		'invalid'            => __( 'Please enter a valid email address.', 'rivross-corporate' ),
		'error'              => __( 'We could not process your subscription. Please try again.', 'rivross-corporate' ),
	);
	if ( ! isset( $messages[ $status ] ) ) {
		return '';
	}

	$type = in_array( $status, array( 'subscribed', 'already_subscribed' ), true ) ? 'success' : 'error';
	return '<p class="rivross-newsletter-notice rivross-newsletter-notice--' . esc_attr( $type ) . '" role="status">' . esc_html( $messages[ $status ] ) . '</p>';
}
