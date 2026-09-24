<?php
/**
 * Single Careers job details page.
 *
 * @package Rivross_Corporate
 */

get_header();
while ( have_posts() ) :
	the_post();
	$job_id        = get_the_ID();
	$title         = get_the_title();
	$location      = rivross_job_meta( $job_id, 'location', __( 'Dhaka, Bangladesh', 'rivross-corporate' ) );
	$department    = rivross_job_meta( $job_id, 'department', __( 'RIVROSS Careers', 'rivross-corporate' ) );
	$employment    = rivross_job_meta( $job_id, 'employment_type', __( 'Full Time', 'rivross-corporate' ) );
	$experience     = rivross_job_meta( $job_id, 'experience', __( 'Experience varies by role', 'rivross-corporate' ) );
	$work_mode      = rivross_job_meta( $job_id, 'work_mode', __( 'On-site', 'rivross-corporate' ) );
	$deadline       = rivross_job_meta( $job_id, 'deadline' );
	$job_code       = rivross_job_meta( $job_id, 'job_code' );
	$application_email = rivross_job_meta( $job_id, 'application_email', 'rivrossgroup@gmail.com' );
	$image          = rivross_job_image_url( $job_id );
	$application_action = admin_url( 'admin-post.php' );
	$contact_url     = home_url( '/contact-us/' );
	$application_form = rivross_job_meta( $job_id, 'application_shortcode' );
	$application_status = isset( $_GET['application'] ) && is_scalar( $_GET['application'] ) ? sanitize_key( wp_unslash( $_GET['application'] ) ) : '';
	$responsibilities = rivross_job_bullets(
		$job_id,
		'responsibilities',
		array( __( 'Lead projects and coordinate stakeholders across the full delivery lifecycle.', 'rivross-corporate' ) )
	);
	$requirements = rivross_job_bullets(
		$job_id,
		'requirements',
		array( __( 'Bring relevant experience, strong communication and a collaborative mindset.', 'rivross-corporate' ) )
	);
	$benefits       = rivross_job_benefits( $job_id );
	$share_url      = rawurlencode( get_permalink() );
	$share_title    = rawurlencode( $title );
	$share_links    = array(
		'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $share_url,
		'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $share_url,
		'whatsapp' => 'https://wa.me/?text=' . $share_title . '%20' . $share_url,
		'email'    => 'mailto:?subject=' . $share_title . '&body=' . $share_url,
	);
?>

<section class="career-job-hero" style="--career-job-image: url('<?php echo esc_url( $image ); ?>');">
	<div class="rivross-container rivross-container--wide career-job-hero__inner">
		<nav class="career-job-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rivross-corporate' ); ?></a><span aria-hidden="true">›</span>
			<a href="<?php echo esc_url( home_url( '/careers/' ) ); ?>"><?php esc_html_e( 'Careers', 'rivross-corporate' ); ?></a><span aria-hidden="true">›</span>
			<span><?php echo esc_html( $title ); ?></span>
		</nav>
		<div class="career-job-hero__copy">
			<h1><?php echo esc_html( $title ); ?></h1>
			<span class="career-job-hero__rule"></span>
			<span class="career-job-hero__badge"><?php echo esc_html( $employment ); ?></span>
		</div>
	</div>
</section>

<main class="career-job-main">
	<div class="rivross-container rivross-container--wide">
		<div class="career-job-grid">
			<article class="career-job-content__card">
				<h2><?php echo esc_html( $title ); ?></h2>
				<span class="career-job-heading-rule"></span>
				<div class="career-job-meta" aria-label="<?php esc_attr_e( 'Job summary', 'rivross-corporate' ); ?>">
					<div class="career-job-meta__item"><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $location ); ?></span></div>
					<div class="career-job-meta__item"><?php echo rivross_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $experience ); ?></span></div>
					<div class="career-job-meta__item"><?php echo rivross_icon( 'briefcase' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $work_mode ); ?></span></div>
					<div class="career-job-meta__item"><?php echo rivross_icon( 'building' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $department ); ?></span></div>
					<?php if ( $deadline ) : ?><div class="career-job-meta__item"><?php echo rivross_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( sprintf( __( 'Apply by %s', 'rivross-corporate' ), $deadline ) ); ?></span></div><?php endif; ?>
					<?php if ( $job_code ) : ?><div class="career-job-meta__item"><?php echo rivross_icon( 'file' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( sprintf( __( 'Ref. %s', 'rivross-corporate' ), $job_code ) ); ?></span></div><?php endif; ?>
				</div>

				<section class="career-job-section career-job-content__body">
					<h2><?php esc_html_e( 'About the Role', 'rivross-corporate' ); ?></h2><span class="career-job-heading-rule"></span>
					<?php if ( trim( get_the_content() ) ) : the_content(); else : ?><p><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
				</section>

				<section class="career-job-section">
					<h2><?php esc_html_e( 'Key Responsibilities', 'rivross-corporate' ); ?></h2><span class="career-job-heading-rule"></span>
					<ul class="career-job-list"><?php foreach ( $responsibilities as $item ) : ?><li><?php echo esc_html( $item ); ?></li><?php endforeach; ?></ul>
				</section>

				<section class="career-job-section">
					<h2><?php esc_html_e( 'Requirements', 'rivross-corporate' ); ?></h2><span class="career-job-heading-rule"></span>
					<ul class="career-job-list"><?php foreach ( $requirements as $item ) : ?><li><?php echo esc_html( $item ); ?></li><?php endforeach; ?></ul>
				</section>

				<section class="career-job-section">
					<h2><?php esc_html_e( 'What We Offer', 'rivross-corporate' ); ?></h2><span class="career-job-heading-rule"></span>
					<div class="career-job-benefits">
						<?php foreach ( $benefits as $benefit ) : ?><div class="career-job-benefit"><span><?php echo rivross_icon( rivross_sanitize_icon_choice( $benefit[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><h3><?php echo esc_html( $benefit[1] ); ?></h3><p><?php echo esc_html( $benefit[2] ); ?></p></div><?php endforeach; ?>
					</div>
				</section>
			</article>

			<aside class="career-job-sidebar">
				<section class="career-apply-card">
					<h2><?php esc_html_e( 'Apply for this Position', 'rivross-corporate' ); ?></h2><span class="career-job-heading-rule"></span>
					<p><?php esc_html_e( 'Take the next step in your career. Fill out the form below and join our team.', 'rivross-corporate' ); ?></p>
					<?php if ( 'sent' === $application_status ) : ?><p class="career-application-feedback career-application-feedback--success" role="status"><?php esc_html_e( 'Thank you. Your application has been sent successfully.', 'rivross-corporate' ); ?></p><?php elseif ( 'error' === $application_status ) : ?><p class="career-application-feedback career-application-feedback--error" role="alert"><?php esc_html_e( 'We could not send your application. Please check the form and try again.', 'rivross-corporate' ); ?></p><?php endif; ?>
					<?php if ( $application_form ) : ?>
						<div class="career-application-shortcode"><?php echo do_shortcode( $application_form ); ?></div>
					<?php else : ?>
						<form id="career-application-form" class="career-application-form" action="<?php echo esc_url( $application_action ); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="action" value="rivross_submit_job_application">
							<input type="hidden" name="job_id" value="<?php echo esc_attr( $job_id ); ?>">
							<?php wp_nonce_field( 'rivross_submit_job_application', 'rivross_application_nonce' ); ?>
							<div class="career-application-form__honeypot" aria-hidden="true"><label for="rivross-website"><?php esc_html_e( 'Leave this field empty', 'rivross-corporate' ); ?></label><input id="rivross-website" type="text" name="rivross_website" value="" tabindex="-1" autocomplete="off"></div>
							<label><span class="screen-reader-text"><?php esc_html_e( 'Full Name', 'rivross-corporate' ); ?></span><?php echo rivross_icon( 'users' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><input type="text" name="applicant_name" autocomplete="name" placeholder="<?php esc_attr_e( 'Full Name *', 'rivross-corporate' ); ?>" required></label>
							<label><span class="screen-reader-text"><?php esc_html_e( 'Email Address', 'rivross-corporate' ); ?></span><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><input type="email" name="applicant_email" autocomplete="email" placeholder="<?php esc_attr_e( 'Email Address *', 'rivross-corporate' ); ?>" required></label>
							<label><span class="screen-reader-text"><?php esc_html_e( 'Phone Number', 'rivross-corporate' ); ?></span><?php echo rivross_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><input type="tel" name="applicant_phone" autocomplete="tel" inputmode="tel" placeholder="<?php esc_attr_e( 'Phone Number *', 'rivross-corporate' ); ?>" required></label>
							<label class="career-application-form__file"><?php echo rivross_icon( 'file' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php esc_html_e( 'Upload CV', 'rivross-corporate' ); ?></span><input type="file" name="applicant_cv" accept=".pdf,.doc,.docx"></label>
							<label class="screen-reader-text" for="applicant-message"><?php esc_html_e( 'Short Message', 'rivross-corporate' ); ?></label><textarea id="applicant-message" name="applicant_message" placeholder="<?php esc_attr_e( 'Tell us why you are a great fit for this role... (optional)', 'rivross-corporate' ); ?>"></textarea>
							<button class="rivross-button" type="submit"><?php esc_html_e( 'Submit Application', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
						</form>
						<p class="career-application-note"><?php esc_html_e( 'You can connect a Contact Form 7 shortcode to this job from the Job Details panel at any time.', 'rivross-corporate' ); ?><br><a href="<?php echo esc_url( 'mailto:' . sanitize_email( $application_email ) ); ?>"><?php echo esc_html( $application_email ); ?></a></p>
					<?php endif; ?>
				</section>

				<section class="career-share-card"><h2><?php esc_html_e( 'Share This Job', 'rivross-corporate' ); ?></h2><span class="career-job-heading-rule"></span><p><?php esc_html_e( 'Know someone who might be a great fit? Share this opportunity with your network.', 'rivross-corporate' ); ?></p><div class="career-share-links" aria-label="<?php esc_attr_e( 'Share this job', 'rivross-corporate' ); ?>"><?php foreach ( array( 'linkedin' => 'LinkedIn', 'facebook' => 'Facebook', 'whatsapp' => 'WhatsApp', 'email' => 'Email' ) as $network => $label ) : ?><a href="<?php echo esc_url( $share_links[ $network ] ); ?>" aria-label="<?php echo esc_attr( $label ); ?>"<?php echo 'email' !== $network ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo rivross_icon( 'email' === $network ? 'mail' : $network ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><?php endforeach; ?></div></section>
			</aside>
		</div>
	</div>
</main>

<section class="career-job-cta" style="--career-job-image: url('<?php echo esc_url( $image ); ?>');">
	<div class="rivross-container rivross-container--wide career-job-cta__inner">
		<div><h2><?php esc_html_e( 'Ready to Build a Better Tomorrow?', 'rivross-corporate' ); ?></h2><p><?php esc_html_e( 'Explore exciting career opportunities and be part of a team shaping stronger communities.', 'rivross-corporate' ); ?></p></div>
		<div class="career-job-cta__actions"><a class="rivross-button" href="<?php echo esc_url( home_url( '/careers/#open-positions' ) ); ?>"><?php esc_html_e( 'View All Jobs', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><a class="rivross-button rivross-button--outline" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Contact Us', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div>
	</div>
</section>

<?php endwhile; get_footer(); ?>
