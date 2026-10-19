<?php
/**
 * About Us page template.
 *
 * @package Rivross_Corporate
 */

get_header();

$image_uri = get_theme_file_uri( '/assets/images/home/' );

$hero_image       = get_theme_mod( 'rivross_about_hero_image', $image_uri . 'hero-city.png' );
$breadcrumb_home  = get_theme_mod( 'rivross_about_breadcrumb_home', __( 'Home', 'rivross-corporate' ) );
$breadcrumb_page  = get_theme_mod( 'rivross_about_breadcrumb_page', __( 'About Us', 'rivross-corporate' ) );
$hero_line_1      = get_theme_mod( 'rivross_about_hero_line_1', __( 'About', 'rivross-corporate' ) );
$hero_line_2      = get_theme_mod( 'rivross_about_hero_line_2', __( 'RIVROSS', 'rivross-corporate' ) );
$hero_description = str_replace( '\\n', "\n", (string) get_theme_mod( 'rivross_about_hero_description', __( "Driven by vision. Guided by values.\nCommitted to building a better tomorrow.", 'rivross-corporate' ) ) );

$intro_eyebrow      = get_theme_mod( 'rivross_about_intro_eyebrow', __( 'Who We Are', 'rivross-corporate' ) );
$intro_title        = str_replace( '\\n', "\n", (string) get_theme_mod( 'rivross_about_intro_title', __( "Building Businesses.\nCreating Opportunities.", 'rivross-corporate' ) ) );
$intro_paragraph_1  = get_theme_mod( 'rivross_about_intro_paragraph_1', __( 'RIVROSS Company Limited is a diversified business organization operating across Real Estate, Travel & Tourism, Tea Business and future business ventures.', 'rivross-corporate' ) );
$intro_paragraph_2  = get_theme_mod( 'rivross_about_intro_paragraph_2', __( 'Our goal is to deliver sustainable growth, professional service and long-term partnerships while creating value for our clients, partners and the communities we serve.', 'rivross-corporate' ) );
$intro_button_label = get_theme_mod( 'rivross_about_intro_button_label', __( 'Download Corporate Profile', 'rivross-corporate' ) );
$intro_button_url   = get_theme_mod( 'rivross_about_intro_button_url', '#contact' );

$about_email        = get_theme_mod( 'rivross_contact_email', 'rivrossgroup@gmail.com' );
$about_phone        = get_theme_mod( 'rivross_contact_phone', '01796-566279' );
$about_visit        = get_theme_mod( 'rivross_contact_visit_address', get_theme_mod( 'rivross_contact_address', '3/3 Matuail Junglebari, Jatrabari, Dhaka-1362, Bangladesh' ) );
$about_map_url      = get_theme_mod( 'rivross_contact_map_url', 'https://maps.google.com/?q=Jatrabari,Dhaka' );
$about_socials      = array();
foreach ( array( 'facebook' => 'Facebook', 'linkedin' => 'LinkedIn', 'youtube' => 'YouTube', 'instagram' => 'Instagram' ) as $social_key => $social_label ) {
	$about_socials[ $social_key ] = array(
		'label' => $social_label,
		'url'   => get_theme_mod( 'rivross_social_' . $social_key, '#' ),
	);
}

$about_expertise = array(
	array( 'building', 'Real Estate', 'Property development, sales and investment opportunities shaped around long-term value.', home_url( '/real-estate/' ) ),
	array( 'plane', 'Travel & Tourism', 'Air ticketing, hotel booking, tour packages and corporate travel support.', home_url( '/travel-tourism/' ) ),
	array( 'leaf', 'Tea Business', 'Thoughtful sourcing and dependable supply from Bangladesh to growing markets.', home_url( '/tea-business/' ) ),
	array( 'ruler', 'Building Services', 'Doors, tiles & ceramics, interior, plumbing and finishing support for better spaces.', get_post_type_archive_link( 'rivross_service' ) ? get_post_type_archive_link( 'rivross_service' ) : home_url( '/services/' ) ),
);

$pillars = array(
	array( 'eye', 'Our Vision', 'To be a leading diversified business organization recognized for excellence, innovation and sustainable growth.' ),
	array( 'target', 'Our Mission', 'To create long-term value through quality services, trusted partnerships and responsible business practices.' ),
	array( 'flag', 'Our Purpose', 'To empower people and businesses by providing opportunities that inspire growth and success.' ),
	array( 'shield', 'Our Promise', 'We are committed to professionalism, integrity and delivering value that exceeds expectations.' ),
);

$values = array(
	array( 'shield', 'Integrity', 'We uphold the highest standards of honesty and transparency.' ),
	array( 'award', 'Excellence', 'We are committed to delivering quality in everything we do.' ),
	array( 'gear', 'Innovation', 'We embrace innovation to create sustainable solutions.' ),
	array( 'users', 'Teamwork', 'We believe in the power of collaboration and shared success.' ),
	array( 'leaf', 'Responsibility', 'We act responsibly towards our stakeholders and the environment.' ),
	array( 'handshake', 'Respect', 'We value people and build relationships based on respect.' ),
);

$journey = array(
	array( 'building', '2010', 'Foundation', 'RIVROSS Company Limited was founded with a vision to build lasting value.' ),
	array( 'handshake', '2012', 'First Partnerships', 'Established strategic partnerships and expanded our business network.' ),
	array( 'building', '2015', 'Business Expansion', 'Expanded into Real Estate and Travel & Tourism sectors.' ),
	array( 'leaf', '2018', 'Tea Business', 'Ventured into Tea Business to diversify and strengthen our portfolio.' ),
	array( 'globe', '2021', 'Regional Growth', 'Strengthened our presence across Bangladesh and beyond.' ),
	array( 'award', '2024+', 'Looking Ahead', 'Continuing our journey towards sustainable growth.' ),
);

$leaders = array(
	array( 'leadership-placeholder.png', 'Nasrullah Hossain Nahid', 'Chief Operating Officer (COO)', 'Leads operations with a focus on efficiency, innovation and sustainable growth.' ),
	array( 'leadership-glasses.png', 'Md. Fatin Ishtiyaq Fahim', 'Chief Financial Officer (CFO)', 'Ensures financial stability and strategic planning for long-term success.' ),
	array( 'leadership-beard.png', 'MD Obayed Ullah Sarker', 'Director', 'Oversees design, operations and business development initiatives.' ),
	array( 'leadership-director.png', 'MD Ataullah', 'Director', 'Drives real estate growth and customer-focused development.' ),
);
$dynamic_leaders_enabled = function_exists( 'rivross_leadership_has_published_entries' ) && rivross_leadership_has_published_entries();
$dynamic_leaders         = $dynamic_leaders_enabled && function_exists( 'rivross_get_leaders' ) ? rivross_get_leaders( 'about', 4 ) : array();
?>

<section class="about-hero" style="--about-hero-image: url('<?php echo esc_url( $hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide about-hero__inner">
		<nav class="about-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $breadcrumb_home ); ?></a>
			<span aria-hidden="true">/</span>
			<span><?php echo esc_html( $breadcrumb_page ); ?></span>
		</nav>
		<div class="about-hero__copy">
			<h1><span><?php echo esc_html( $hero_line_1 ); ?></span><strong><?php echo esc_html( $hero_line_2 ); ?></strong></h1>
			<span class="about-hero__rule"></span>
			<p class="about-hero__description"><?php echo esc_html( $hero_description ); ?></p>
		</div>
	</div>
</section>

<section id="about-content" class="about-section about-intro">
	<div class="rivross-container rivross-container--wide about-intro__grid">
		<div class="about-intro__copy">
			<span class="rivross-eyebrow"><?php echo esc_html( $intro_eyebrow ); ?></span>
			<h2><?php echo esc_html( $intro_title ); ?></h2>
			<span class="about-hero__rule"></span>
			<p><?php echo esc_html( $intro_paragraph_1 ); ?></p>
			<p><?php echo esc_html( $intro_paragraph_2 ); ?></p>
			<a class="rivross-button rivross-button--dark" href="<?php echo esc_url( rivross_theme_link( $intro_button_url ) ); ?>"><?php echo esc_html( $intro_button_label ); ?> <?php echo rivross_icon( 'download' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
		</div>
		<div class="about-pillars">
			<?php foreach ( $pillars as $index => $pillar ) : $number = $index + 1; ?>
				<?php $pillar[0] = get_theme_mod( 'rivross_about_pillar_' . $number . '_icon', $pillar[0] ); ?>
				<?php $pillar[1] = get_theme_mod( 'rivross_about_pillar_' . $number . '_title', $pillar[1] ); ?>
				<?php $pillar[2] = get_theme_mod( 'rivross_about_pillar_' . $number . '_description', $pillar[2] ); ?>
				<div class="about-pillar">
					<?php echo rivross_icon( rivross_sanitize_icon_choice( $pillar[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div><h3><?php echo esc_html( $pillar[1] ); ?></h3><p><?php echo esc_html( $pillar[2] ); ?></p></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="about-section about-contact-panel">
	<div class="rivross-container rivross-container--wide">
		<div class="about-contact-panel__intro">
			<div>
				<span class="rivross-eyebrow"><?php esc_html_e( 'Visit Rivross', 'rivross-corporate' ); ?></span>
				<h2><?php esc_html_e( 'Let’s build the next opportunity together.', 'rivross-corporate' ); ?></h2>
				<p><?php esc_html_e( 'Have a requirement, a partnership idea or a place to visit? Our team is ready to listen and guide you to the right next step.', 'rivross-corporate' ); ?></p>
			</div>
			<a class="rivross-button" href="<?php echo esc_url( rivross_theme_link( '#contact' ) ); ?>"><?php esc_html_e( 'Start a Conversation', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
		</div>

		<div class="about-contact-panel__cards">
			<a class="about-contact-card" href="mailto:<?php echo esc_attr( $about_email ); ?>">
				<span class="about-contact-card__icon"><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<span class="about-contact-card__copy"><small><?php esc_html_e( 'Email Us', 'rivross-corporate' ); ?></small><strong><?php echo esc_html( $about_email ); ?></strong><em><?php esc_html_e( 'We reply within 24 hours', 'rivross-corporate' ); ?></em></span>
			</a>
			<a class="about-contact-card" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $about_phone ) ); ?>">
				<span class="about-contact-card__icon"><?php echo rivross_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<span class="about-contact-card__copy"><small><?php esc_html_e( 'Call Us', 'rivross-corporate' ); ?></small><strong><?php echo esc_html( $about_phone ); ?></strong><em><?php esc_html_e( 'Saturday – Thursday · 10:00 AM – 07:00 PM', 'rivross-corporate' ); ?></em></span>
			</a>
			<a class="about-contact-card" href="<?php echo esc_url( $about_map_url ); ?>" target="_blank" rel="noopener">
				<span class="about-contact-card__icon"><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<span class="about-contact-card__copy"><small><?php esc_html_e( 'Visit Us', 'rivross-corporate' ); ?></small><strong><?php esc_html_e( 'Our Office Location', 'rivross-corporate' ); ?></strong><em><?php echo esc_html( $about_visit ); ?></em></span>
			</a>
		</div>

		<div class="about-contact-panel__socials">
			<span><?php esc_html_e( 'Our Companies · Connect with RIVROSS', 'rivross-corporate' ); ?></span>
			<div>
				<?php foreach ( $about_socials as $social_key => $social ) : ?>
					<a href="<?php echo esc_url( $social['url'] ); ?>" aria-label="<?php echo esc_attr( $social['label'] ); ?>"<?php echo '#' !== $social['url'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo rivross_icon( $social_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<section class="about-section about-expertise about-section--surface">
	<div class="rivross-container rivross-container--wide">
		<div class="about-section__heading about-expertise__heading">
			<span class="rivross-eyebrow"><?php esc_html_e( 'Our Experience', 'rivross-corporate' ); ?></span>
			<h2><?php esc_html_e( 'One group. Multiple ways to create value.', 'rivross-corporate' ); ?></h2>
			<p><?php esc_html_e( 'From property and travel to tea and building services, our experience connects people, products and possibilities.', 'rivross-corporate' ); ?></p>
		</div>
		<div class="about-expertise__grid">
			<?php foreach ( $about_expertise as $index => $expertise ) : ?>
				<a class="about-expertise-card" href="<?php echo esc_url( $expertise[3] ); ?>">
					<span class="about-expertise-card__number">0<?php echo esc_html( $index + 1 ); ?></span>
					<span class="about-expertise-card__icon"><?php echo rivross_icon( $expertise[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<h3><?php echo esc_html( $expertise[1] ); ?></h3>
					<p><?php echo esc_html( $expertise[2] ); ?></p>
					<span class="about-expertise-card__link"><?php esc_html_e( 'Explore area', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="about-section about-section--surface about-values">
	<div class="rivross-container rivross-container--wide">
		<div class="about-section__heading"><span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_about_values_eyebrow', __( 'Our Core Values', 'rivross-corporate' ) ) ); ?></span><h2><?php echo esc_html( get_theme_mod( 'rivross_about_values_title', __( 'The Values That Define Us', 'rivross-corporate' ) ) ); ?></h2></div>
		<div class="about-values__grid">
			<?php foreach ( $values as $index => $value ) : $number = $index + 1; ?>
				<?php $value[0] = get_theme_mod( 'rivross_about_value_' . $number . '_icon', $value[0] ); $value[1] = get_theme_mod( 'rivross_about_value_' . $number . '_title', $value[1] ); $value[2] = get_theme_mod( 'rivross_about_value_' . $number . '_description', $value[2] ); ?>
				<article class="about-value"><?php echo rivross_icon( rivross_sanitize_icon_choice( $value[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><h3><?php echo esc_html( $value[1] ); ?></h3><p><?php echo esc_html( $value[2] ); ?></p></article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="journey" class="about-section about-journey">
	<div class="rivross-container rivross-container--wide">
		<div class="about-section__heading"><span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_about_journey_eyebrow', __( 'Our Journey', 'rivross-corporate' ) ) ); ?></span><h2><?php echo esc_html( get_theme_mod( 'rivross_about_journey_title', __( 'Milestones of Growth', 'rivross-corporate' ) ) ); ?></h2></div>
		<div class="about-journey__track">
			<?php foreach ( $journey as $index => $milestone ) : $number = $index + 1; ?>
				<?php $milestone[0] = get_theme_mod( 'rivross_about_journey_' . $number . '_icon', $milestone[0] ); $milestone[1] = get_theme_mod( 'rivross_about_journey_' . $number . '_year', $milestone[1] ); $milestone[2] = get_theme_mod( 'rivross_about_journey_' . $number . '_title', $milestone[2] ); $milestone[3] = get_theme_mod( 'rivross_about_journey_' . $number . '_description', $milestone[3] ); ?>
				<article class="about-milestone"><div class="about-milestone__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $milestone[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div><span class="about-milestone__year"><?php echo esc_html( $milestone[1] ); ?></span><h3><?php echo esc_html( $milestone[2] ); ?></h3><p><?php echo esc_html( $milestone[3] ); ?></p></article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="leadership" class="about-section about-leadership">
	<div class="rivross-container rivross-container--wide">
		<div class="about-section__heading"><span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_about_leadership_eyebrow', __( 'Leadership That Inspires', 'rivross-corporate' ) ) ); ?></span><h2><?php echo esc_html( get_theme_mod( 'rivross_about_leadership_title', __( 'Guided by Experience. Driven by Purpose.', 'rivross-corporate' ) ) ); ?></h2></div>
		<div class="about-leadership__grid">
			<?php $leaders_to_render = $dynamic_leaders_enabled ? $dynamic_leaders : $leaders; ?>
			<?php foreach ( $leaders_to_render as $index => $leader ) : $number = $index + 1; ?>
				<?php
				if ( $dynamic_leaders_enabled ) {
					$dynamic_leader = $leader;
					$leader[0]      = $dynamic_leader['image'] ? $dynamic_leader['image'] : $image_uri . 'leadership-placeholder.png';
					$leader[1]      = $dynamic_leader['name'];
					$leader[2]      = $dynamic_leader['role'];
					$leader[3]      = $dynamic_leader['bio'];
					$socials        = $dynamic_leader['socials'];
				} else {
					$leader[0]  = get_theme_mod( 'rivross_about_leader_' . $number . '_image', $image_uri . $leader[0] );
					$leader[1]  = get_theme_mod( 'rivross_about_leader_' . $number . '_name', $leader[1] );
					$leader[2]  = get_theme_mod( 'rivross_about_leader_' . $number . '_role', $leader[2] );
					$leader[3]  = get_theme_mod( 'rivross_about_leader_' . $number . '_description', $leader[3] );
					$socials    = array();
				}
				?>
				<article class="about-leader"><img src="<?php echo esc_url( $leader[0] ); ?>" alt="<?php echo esc_attr( $leader[1] ); ?>" loading="lazy"><div class="about-leader__body"><h3><?php echo esc_html( $leader[1] ); ?></h3><span class="about-leader__role"><?php echo esc_html( $leader[2] ); ?></span><p><?php echo esc_html( $leader[3] ); ?></p><?php echo rivross_leadership_social_links( $socials, $leader[1] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div></article>
			<?php endforeach; ?>
			<div class="about-leadership__promo"><h3><?php echo esc_html( get_theme_mod( 'rivross_about_leadership_promo_title', __( 'Meet Our Leadership', 'rivross-corporate' ) ) ); ?></h3><p><?php echo esc_html( get_theme_mod( 'rivross_about_leadership_promo_description', __( 'Learn more about our experienced leadership team.', 'rivross-corporate' ) ) ); ?></p><a class="rivross-button" href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_about_leadership_promo_url', home_url( '/management/' ) ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_about_leadership_promo_label', __( 'View All Members', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div>
		</div>
	</div>
</section>

<section class="about-page-cta">
	<div class="rivross-container rivross-container--wide about-page-cta__inner">
		<div class="about-page-cta__icon" aria-hidden="true"><?php echo rivross_icon( rivross_sanitize_icon_choice( get_theme_mod( 'rivross_about_cta_icon', 'phone' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<div><span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_about_cta_eyebrow', __( "Let's Build Something Great Together", 'rivross-corporate' ) ) ); ?></span><h2><?php echo esc_html( get_theme_mod( 'rivross_about_cta_title', __( "Let's Build Something Great Together", 'rivross-corporate' ) ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'rivross_about_cta_description', __( 'We are always open to new opportunities, partnerships and business collaborations.', 'rivross-corporate' ) ) ); ?></p></div>
		<div class="about-page-cta__actions"><a class="rivross-button" href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_about_cta_primary_url', '#contact' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_about_cta_primary_label', __( 'Send an Inquiry', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><a class="rivross-button rivross-button--outline" href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_about_cta_secondary_url', '#contact' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_about_cta_secondary_label', __( 'Contact Us', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div>
	</div>
</section>

<?php get_footer(); ?>
