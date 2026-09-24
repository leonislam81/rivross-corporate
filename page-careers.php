<?php
/**
 * Careers page template.
 *
 * @package Rivross_Corporate
 */

get_header();

$careers_uri = get_theme_file_uri( '/assets/images/careers/' );
$home_uri    = get_theme_file_uri( '/assets/images/home/' );
$application_url = home_url( '/submit-your-cv/' );
$careers_hero_image       = get_theme_mod( 'rivross_careers_hero_image', $careers_uri . 'careers-hero.png' );
$careers_breadcrumb_home  = get_theme_mod( 'rivross_careers_breadcrumb_home', __( 'Home', 'rivross-corporate' ) );
$careers_breadcrumb_page  = get_theme_mod( 'rivross_careers_breadcrumb_page', __( 'Careers', 'rivross-corporate' ) );
$careers_hero_line_1      = get_theme_mod( 'rivross_careers_hero_line_1', __( 'Build Your Career.', 'rivross-corporate' ) );
$careers_hero_line_2      = get_theme_mod( 'rivross_careers_hero_line_2', __( 'Build a Better Tomorrow.', 'rivross-corporate' ) );
$careers_hero_description = get_theme_mod( 'rivross_careers_hero_description', __( 'At RIVROSS, we empower people to grow, innovate and make a lasting impact in real estate and beyond.', 'rivross-corporate' ) );
$careers_hero_button      = get_theme_mod( 'rivross_careers_hero_button_label', __( 'Explore Opportunities', 'rivross-corporate' ) );
$careers_hero_url         = get_theme_mod( 'rivross_careers_hero_button_url', '#open-positions' );
$careers_about_image      = get_theme_mod( 'rivross_careers_about_image', $careers_uri . 'careers-collaboration.png' );
$careers_about_eyebrow    = get_theme_mod( 'rivross_careers_about_eyebrow', __( 'About Careers at RIVROSS', 'rivross-corporate' ) );
$careers_about_title      = get_theme_mod( 'rivross_careers_about_title', __( 'Where Ambition Meets Opportunity', 'rivross-corporate' ) );
$careers_about_description = get_theme_mod( 'rivross_careers_about_description', __( 'We are more than a real estate company; we are a team of visionaries, problem-solvers and change-makers. Join us and be part of a dynamic environment where your ideas shape iconic projects and communities.', 'rivross-corporate' ) );
$careers_about_button     = get_theme_mod( 'rivross_careers_about_button_label', __( 'Learn More About Us', 'rivross-corporate' ) );
$careers_about_url        = get_theme_mod( 'rivross_careers_about_button_url', home_url( '/about-us/' ) );
$careers_why_title        = get_theme_mod( 'rivross_careers_why_title', __( 'Why Join RIVROSS?', 'rivross-corporate' ) );
$careers_jobs_title       = get_theme_mod( 'rivross_careers_jobs_title', __( 'Open Positions', 'rivross-corporate' ) );
$careers_process_title    = get_theme_mod( 'rivross_careers_process_title', __( 'Our Hiring Process', 'rivross-corporate' ) );
$careers_process_description = get_theme_mod( 'rivross_careers_process_description', __( 'Simple, transparent and focused on finding the right fit.', 'rivross-corporate' ) );
$careers_testimonials_title = get_theme_mod( 'rivross_careers_testimonials_title', __( 'Hear From Our Team', 'rivross-corporate' ) );
$careers_cta_image        = get_theme_mod( 'rivross_careers_cta_background_image', $careers_uri . 'careers-job-hero.png' );
$careers_cta_heading      = get_theme_mod( 'rivross_careers_cta_heading', __( 'Ready to Take the Next Step?', 'rivross-corporate' ) );
$careers_cta_description  = get_theme_mod( 'rivross_careers_cta_description', __( 'Explore opportunities and build a career that makes a difference.', 'rivross-corporate' ) );
$careers_cta_primary      = get_theme_mod( 'rivross_careers_cta_primary_label', __( 'Browse All Jobs', 'rivross-corporate' ) );
$careers_cta_primary_url  = get_theme_mod( 'rivross_careers_cta_primary_url', '#open-positions' );
$careers_cta_secondary    = get_theme_mod( 'rivross_careers_cta_secondary_label', __( 'Submit Your CV', 'rivross-corporate' ) );
$careers_cta_secondary_url = get_theme_mod( 'rivross_careers_cta_secondary_url', $application_url );

/* Keep the branded artwork visible when an optional image field is cleared. */
$careers_hero_image = $careers_hero_image ? $careers_hero_image : $careers_uri . 'careers-hero.png';
$careers_about_image = $careers_about_image ? $careers_about_image : $careers_uri . 'careers-collaboration.png';
$careers_cta_image   = $careers_cta_image ? $careers_cta_image : $careers_uri . 'careers-job-hero.png';

$values = array(
	array( 'users', __( 'People First', 'rivross-corporate' ), __( 'We value our people and their well-being.', 'rivross-corporate' ) ),
	array( 'lightbulb', __( 'Innovation', 'rivross-corporate' ), __( 'We encourage new ideas and creative thinking.', 'rivross-corporate' ) ),
	array( 'target', __( 'Excellence', 'rivross-corporate' ), __( 'We are committed to quality in everything we do.', 'rivross-corporate' ) ),
	array( 'handshake', __( 'Integrity', 'rivross-corporate' ), __( 'We do the right thing, always.', 'rivross-corporate' ) ),
	array( 'chart', __( 'Growth', 'rivross-corporate' ), __( 'We grow together and celebrate success.', 'rivross-corporate' ) ),
	array( 'sprout', __( 'Sustainability', 'rivross-corporate' ), __( 'We build responsibly for a better future.', 'rivross-corporate' ) ),
);

foreach ( $values as $index => $value ) {
	$number = $index + 1;
	$values[ $index ] = array(
		rivross_sanitize_icon_choice( get_theme_mod( 'rivross_careers_value_' . $number . '_icon', $value[0] ) ),
		get_theme_mod( 'rivross_careers_value_' . $number . '_title', $value[1] ),
		get_theme_mod( 'rivross_careers_value_' . $number . '_description', $value[2] ),
	);
}

$why_items = array(
	array( 'chart', __( 'Career Growth', 'rivross-corporate' ), __( 'Access learning, mentorship and advancement opportunities.', 'rivross-corporate' ) ),
	array( 'money', __( 'Competitive Rewards', 'rivross-corporate' ), __( 'We offer market-competitive salaries and performance bonuses.', 'rivross-corporate' ) ),
	array( 'heart', __( 'Work-Life Balance', 'rivross-corporate' ), __( 'Flexible policies and a culture that respects your personal time.', 'rivross-corporate' ) ),
	array( 'shield', __( 'Health & Wellness', 'rivross-corporate' ), __( 'Comprehensive health coverage and wellness programs.', 'rivross-corporate' ) ),
	array( 'users', __( 'Great Culture', 'rivross-corporate' ), __( 'Collaborative, inclusive and supportive work environment.', 'rivross-corporate' ) ),
);

foreach ( $why_items as $index => $item ) {
	$number = $index + 1;
	$why_items[ $index ] = array(
		rivross_sanitize_icon_choice( get_theme_mod( 'rivross_careers_why_' . $number . '_icon', $item[0] ) ),
		get_theme_mod( 'rivross_careers_why_' . $number . '_title', $item[1] ),
		get_theme_mod( 'rivross_careers_why_' . $number . '_description', $item[2] ),
	);
}

$jobs_query = new WP_Query(
	array(
		'post_type'      => 'rivross_job',
		'post_status'    => 'publish',
		'posts_per_page' => 6,
		'paged'          => 1,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);
$jobs           = $jobs_query->posts;
$jobs_max_pages = (int) $jobs_query->max_num_pages;

$hiring_steps = array(
	array( 'file', __( 'Apply Online', 'rivross-corporate' ), __( 'Submit your application through our career portal.', 'rivross-corporate' ) ),
	array( 'users', __( 'Initial Screening', 'rivross-corporate' ), __( 'Our team reviews your application and experience.', 'rivross-corporate' ) ),
	array( 'microphone', __( 'Interviews', 'rivross-corporate' ), __( 'Meet with our team to discuss your skills and aspirations.', 'rivross-corporate' ) ),
	array( 'award', __( 'Offer & Onboarding', 'rivross-corporate' ), __( 'Receive your offer and begin your journey with us.', 'rivross-corporate' ) ),
);

foreach ( $hiring_steps as $index => $step ) {
	$number = $index + 1;
	$hiring_steps[ $index ] = array(
		rivross_sanitize_icon_choice( get_theme_mod( 'rivross_careers_process_' . $number . '_icon', $step[0] ) ),
		get_theme_mod( 'rivross_careers_process_' . $number . '_title', $step[1] ),
		get_theme_mod( 'rivross_careers_process_' . $number . '_description', $step[2] ),
	);
}

$testimonials = array(
	array( $home_uri . 'leadership-director.png', 'Tanvir Ahmed', 'Project Manager', 'RIVROSS has given me the platform to grow professionally while working on some of the most exciting projects in the industry.' ),
	array( get_theme_file_uri( '/assets/images/leadership/leadership-marketing.png' ), 'Faria Islam', 'Marketing Manager', 'The supportive culture and learning opportunities here make every day challenging and rewarding.' ),
	array( $home_uri . 'leadership-beard.png', 'Imtiaz Uddin', 'Business Development Manager', 'I love being part of a team that is passionate about building a better future for our clients and communities.' ),
);

foreach ( $testimonials as $index => $testimonial ) {
	$number = $index + 1;
	$testimonial_image = get_theme_mod( 'rivross_careers_testimonial_' . $number . '_image', $testimonial[0] );
	$testimonial_image = $testimonial_image ? $testimonial_image : $testimonial[0];
	$testimonials[ $index ] = array(
		$testimonial_image,
		get_theme_mod( 'rivross_careers_testimonial_' . $number . '_name', $testimonial[1] ),
		get_theme_mod( 'rivross_careers_testimonial_' . $number . '_role', $testimonial[2] ),
		get_theme_mod( 'rivross_careers_testimonial_' . $number . '_quote', $testimonial[3] ),
	);
}
?>

<section class="careers-hero" style="--careers-hero-image: url('<?php echo esc_url( $careers_hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide careers-hero__inner">
		<nav class="careers-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $careers_breadcrumb_home ); ?></a>
			<span aria-hidden="true">›</span>
			<span><?php echo esc_html( $careers_breadcrumb_page ); ?></span>
		</nav>
		<div class="careers-hero__copy">
			<h1><span><?php echo esc_html( $careers_hero_line_1 ); ?></span><strong><?php echo esc_html( $careers_hero_line_2 ); ?></strong></h1>
			<span class="careers-hero__rule"></span>
			<p><?php echo esc_html( $careers_hero_description ); ?></p>
			<a class="rivross-button" href="<?php echo esc_url( rivross_theme_link( $careers_hero_url ) ); ?>"><?php echo esc_html( $careers_hero_button ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
		</div>
	</div>
</section>

<div class="careers-page">
	<section class="careers-values" aria-label="<?php esc_attr_e( 'RIVROSS values', 'rivross-corporate' ); ?>">
		<div class="rivross-container rivross-container--wide careers-values__grid">
			<?php foreach ( $values as $value ) : ?>
				<article class="careers-value">
					<span class="careers-value__icon"><?php echo rivross_icon( $value[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<h2><?php echo esc_html( $value[1] ); ?></h2>
					<p><?php echo esc_html( $value[2] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="careers-section careers-about">
		<div class="rivross-container rivross-container--wide careers-about__grid">
			<div class="careers-about__copy">
				<span class="rivross-eyebrow"><?php echo esc_html( $careers_about_eyebrow ); ?></span>
				<h2><?php echo esc_html( $careers_about_title ); ?></h2>
				<p><?php echo esc_html( $careers_about_description ); ?></p>
				<a class="rivross-button rivross-button--outline-dark" href="<?php echo esc_url( rivross_theme_link( $careers_about_url ) ); ?>"><?php echo esc_html( $careers_about_button ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
			<div class="careers-about__media"><img src="<?php echo esc_url( $careers_about_image ); ?>" alt="<?php esc_attr_e( 'RIVROSS team collaborating in a boardroom', 'rivross-corporate' ); ?>" loading="lazy"></div>
		</div>
	</section>

	<section class="careers-why" aria-labelledby="careers-why-title">
		<div class="rivross-container rivross-container--wide">
			<header class="careers-centered-heading"><h2 id="careers-why-title"><?php echo esc_html( $careers_why_title ); ?></h2></header>
			<div class="careers-why__grid">
				<?php foreach ( $why_items as $item ) : ?>
					<article class="careers-why__item">
						<span class="careers-why__icon"><?php echo rivross_icon( $item[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<h3><?php echo esc_html( $item[1] ); ?></h3>
						<p><?php echo esc_html( $item[2] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="careers-section careers-jobs" id="open-positions" aria-labelledby="careers-jobs-title">
		<div class="rivross-container rivross-container--wide">
			<header class="careers-section-heading">
				<h2 id="careers-jobs-title"><?php echo esc_html( $careers_jobs_title ); ?></h2>
			</header>
			<div class="careers-jobs__listing" data-careers-jobs>
				<div class="careers-jobs__grid" data-careers-jobs-grid aria-live="polite">
					<?php echo rivross_render_job_cards( $jobs ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<div class="careers-jobs__pagination-wrap" data-careers-jobs-pagination-wrap>
					<?php echo rivross_render_jobs_pagination( 1, $jobs_max_pages ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<p class="careers-jobs__status" data-careers-jobs-status role="status" aria-live="polite"></p>
			</div>
		</div>
	</section>

	<section class="careers-process" aria-labelledby="careers-process-title">
		<div class="rivross-container rivross-container--wide careers-process__inner">
			<div class="careers-process__intro"><h2 id="careers-process-title"><?php echo esc_html( $careers_process_title ); ?></h2><span class="careers-section-rule"></span><p><?php echo esc_html( $careers_process_description ); ?></p></div>
			<div class="careers-process__steps">
				<?php foreach ( $hiring_steps as $index => $step ) : $number = $index + 1; ?>
					<article class="career-process-step"><span class="career-process-step__icon"><?php echo rivross_icon( $step[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><b><?php echo esc_html( $number ); ?></b><h3><?php echo esc_html( $step[1] ); ?></h3><p><?php echo esc_html( $step[2] ); ?></p></article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="careers-section careers-testimonials" aria-labelledby="careers-testimonials-title">
		<div class="rivross-container rivross-container--wide">
			<header class="careers-centered-heading"><h2 id="careers-testimonials-title"><?php echo esc_html( $careers_testimonials_title ); ?></h2><span class="careers-section-rule"></span></header>
			<div class="careers-testimonials__grid">
				<?php foreach ( $testimonials as $testimonial ) : $testimonial_image = preg_match( '#^https?://#i', $testimonial[0] ) ? $testimonial[0] : $home_uri . $testimonial[0]; ?>
					<article class="career-testimonial"><span class="career-testimonial__quote" aria-hidden="true">“</span><p><?php echo esc_html( $testimonial[3] ); ?></p><div class="career-testimonial__person"><img src="<?php echo esc_url( $testimonial_image ); ?>" alt="<?php echo esc_attr( $testimonial[1] ); ?>" loading="lazy"><span><strong><?php echo esc_html( $testimonial[1] ); ?></strong><small><?php echo esc_html( $testimonial[2] ); ?></small></span></div></article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="careers-cta" style="--careers-cta-image: url('<?php echo esc_url( $careers_cta_image ); ?>');">
		<div class="rivross-container rivross-container--wide careers-cta__inner">
			<div><h2><?php echo esc_html( $careers_cta_heading ); ?></h2><p><?php echo esc_html( $careers_cta_description ); ?></p></div>
			<div class="careers-cta__actions"><a class="rivross-button" href="<?php echo esc_url( rivross_theme_link( $careers_cta_primary_url ) ); ?>"><?php echo esc_html( $careers_cta_primary ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><a class="rivross-button rivross-button--outline" href="<?php echo esc_url( rivross_theme_link( $careers_cta_secondary_url ) ); ?>"><?php echo esc_html( $careers_cta_secondary ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div>
		</div>
	</section>
</div>

<?php get_footer(); ?>
