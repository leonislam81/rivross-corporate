<?php
/**
 * Seed the site's legal pages so footer links always resolve to WordPress Pages.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create the two legal pages on a fresh install.
 * Existing pages are left untouched so editors can update them from Pages.
 */
function rivross_seed_legal_pages() {
	$pages = array(
		'terms-and-conditions' => array(
			'title'   => __( 'Terms & Conditions', 'rivross-corporate' ),
			'content' => '<p>These Terms &amp; Conditions govern your use of the RIVROSS Company Limited website. By accessing this website, you agree to follow these terms.</p>'
				. '<h2>Use of this website</h2><p>Website content is provided for general information about RIVROSS, its business verticals, projects, services and opportunities. You may use the information for lawful personal or business purposes.</p>'
				. '<h2>Business and property information</h2><p>Property, project, pricing, availability and service information may change as projects progress. Please contact our team to confirm current details before making a decision.</p>'
				. '<h2>Inquiries and communications</h2><p>Submitting an inquiry does not create a contract, reservation or agency relationship. Our team will respond based on the information you provide.</p>'
				. '<h2>Intellectual property</h2><p>RIVROSS owns or licenses the website text, branding, images and other materials. You may not reproduce or distribute them without written permission.</p>'
				. '<h2>External links</h2><p>Links to third-party websites are provided for convenience. RIVROSS does not control or endorse their content, availability or policies.</p>'
				. '<h2>Changes to these terms</h2><p>We may update these terms when our services or legal requirements change. The updated version will be published on this page.</p>'
				. '<h2>Contact</h2><p>For questions about these terms, contact us at <a href="mailto:rivrossgroup@gmail.com">rivrossgroup@gmail.com</a> or call <a href="tel:+8801796566279">+880 1796-566279</a>.</p>',
		),
		'privacy-policy'        => array(
			'title'   => __( 'Privacy Policy', 'rivross-corporate' ),
			'content' => '<p>RIVROSS Company Limited respects your privacy. This policy explains what information we collect through this website and how we use it.</p>'
				. '<h2>Information we collect</h2><p>When you contact us, we may collect your name, email address, phone number, company details and the information included in your message.</p>'
				. '<h2>How we use information</h2><p>We use submitted information to respond to inquiries, provide requested details, improve our services and maintain website security.</p>'
				. '<h2>Cookies and analytics</h2><p>The website may use essential cookies and anonymous analytics to keep pages working and understand how visitors use the site. You can manage cookies through your browser settings.</p>'
				. '<h2>Sharing and security</h2><p>We do not sell personal information. Information may be shared with trusted service providers when needed to operate the website or respond to your request. We use reasonable safeguards to protect it.</p>'
				. '<h2>Retention and your choices</h2><p>We keep inquiry information only as long as needed for the purpose it was provided or to meet legal obligations. You may ask us to update or delete your information by contacting us.</p>'
				. '<h2>Policy updates</h2><p>We may revise this policy as our website and services evolve. The latest version will always be available on this page.</p>'
				. '<h2>Contact</h2><p>For privacy questions or requests, contact <a href="mailto:rivrossgroup@gmail.com">rivrossgroup@gmail.com</a>.</p>',
		),
	);

	foreach ( $pages as $slug => $page ) {
		if ( get_page_by_path( $slug ) ) {
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_title'     => $page['title'],
				'post_name'      => $slug,
				'post_content'   => $page['content'],
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'comment_status' => 'closed',
			),
			true
		);

		if ( ! is_wp_error( $page_id ) && $page_id ) {
			update_post_meta( $page_id, '_wp_page_template', 'page-legal.php' );
		}
	}
}
add_action( 'init', 'rivross_seed_legal_pages', 20 );

