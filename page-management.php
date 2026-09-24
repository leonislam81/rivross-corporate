<?php
/**
 * Leadership / Management page template.
 *
 * @package Rivross_Corporate
 */

get_header();

$leadership_uri = get_theme_file_uri( '/assets/images/leadership/' );
$home_uri       = get_theme_file_uri( '/assets/images/home/' );

$hero_image       = get_theme_mod( 'rivross_management_hero_image', $leadership_uri . 'leadership-hero.png' );
$breadcrumb_home  = get_theme_mod( 'rivross_management_breadcrumb_home', __( 'Home', 'rivross-corporate' ) );
$breadcrumb_page  = get_theme_mod( 'rivross_management_breadcrumb_page', __( 'Management', 'rivross-corporate' ) );
$hero_line_1      = get_theme_mod( 'rivross_management_hero_line_1', __( 'Our Leadership,', 'rivross-corporate' ) );
$hero_line_2      = get_theme_mod( 'rivross_management_hero_line_2', __( 'Your Trust', 'rivross-corporate' ) );
$hero_description = str_replace( '\\n', "\n", (string) get_theme_mod( 'rivross_management_hero_description', __( 'A team of visionary leaders and industry experts working together to build a better future with integrity, innovation and excellence.', 'rivross-corporate' ) ) );
$dynamic_leaders_enabled = function_exists( 'rivross_leadership_has_published_entries' ) && rivross_leadership_has_published_entries();
$dynamic_leaders         = $dynamic_leaders_enabled && function_exists( 'rivross_get_leaders' ) ? rivross_get_leaders( 'management' ) : array();

$leaders = array(
	array( 'leadership-placeholder.png', 'Mohammad Reza', 'Chairman', 'Visionary leader with over 25 years of experience in real estate and business development.' ),
	array( 'leadership-glasses.png', 'Arif Hasan', 'Managing Director', 'Expert in strategic planning and operations with a proven track record of delivering results.' ),
	array( '../leadership/leadership-finance.png', 'Nusrat Jahan', 'Director – Finance', 'Finance professional with strong expertise in investment, risk management and compliance.' ),
	array( 'leadership-director.png', 'Tanvir Ahmed', 'Director – Development', 'Leads project development and execution with a focus on quality, safety and innovation.' ),
	array( 'leadership-beard.png', 'Sabbir Rahman', 'Head of Projects', 'Oversees project planning and delivery to ensure on-time completion and excellence.' ),
	array( '../leadership/leadership-marketing.png', 'Faria Islam', 'Head of Marketing', 'Drives brand growth and customer engagement through innovative marketing strategies.' ),
	array( 'leadership-director.png', 'Imtiaz Uddin', 'Head of Operations', 'Ensures operational efficiency and excellence across all business functions.' ),
	array( 'leadership-glasses.png', 'Khalid Mahmud', 'Company Secretary', 'Responsible for governance, compliance and corporate secretarial affairs.' ),
);

$stats = array(
	array( 'users', '100+', 'Team Members', '' ),
	array( 'briefcase', '25+', 'Years of Combined', 'Experience' ),
	array( 'building', '50+', 'Successful', 'Projects' ),
	array( 'award', 'Awards', 'For Excellence in', 'Real Estate' ),
);

$commitment_image       = get_theme_mod( 'rivross_management_commitment_image', $leadership_uri . 'leadership-commitment.png' );
$commitment_eyebrow     = get_theme_mod( 'rivross_management_commitment_eyebrow', __( 'Our Commitment', 'rivross-corporate' ) );
$commitment_title       = get_theme_mod( 'rivross_management_commitment_title', __( 'Building a Legacy of Trust and Excellence', 'rivross-corporate' ) );
$commitment_description = str_replace( '\\n', "\n", (string) get_theme_mod( 'rivross_management_commitment_description', __( 'At RIVROSS, our leadership is committed to creating value for our clients, partners and communities through transparency, innovation and sustainable growth.', 'rivross-corporate' ) ) );
$commitment_label       = get_theme_mod( 'rivross_management_commitment_button_label', __( 'Learn More About Us', 'rivross-corporate' ) );
$commitment_url         = get_theme_mod( 'rivross_management_commitment_button_url', home_url( '/about-us/' ) );

$cta_heading       = get_theme_mod( 'rivross_management_cta_heading', __( "Let's Build Something Great Together", 'rivross-corporate' ) );
$cta_description   = get_theme_mod( 'rivross_management_cta_description', __( 'Partner with our experienced leadership team and turn your vision into reality.', 'rivross-corporate' ) );
$cta_primary_label = get_theme_mod( 'rivross_management_cta_primary_label', __( 'Discuss Your Project', 'rivross-corporate' ) );
$cta_primary_url   = get_theme_mod( 'rivross_management_cta_primary_url', home_url( '/contact-us/' ) );
$cta_secondary_label = get_theme_mod( 'rivross_management_cta_secondary_label', __( 'Contact Us', 'rivross-corporate' ) );
$cta_secondary_url = get_theme_mod( 'rivross_management_cta_secondary_url', home_url( '/contact-us/' ) );
?>

<section class="management-hero" style="--management-hero-image: url('<?php echo esc_url( $hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide management-hero__inner">
		<nav class="management-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $breadcrumb_home ); ?></a>
			<span aria-hidden="true">›</span>
			<span><?php echo esc_html( $breadcrumb_page ); ?></span>
		</nav>
		<div class="management-hero__copy">
			<h1><span><?php echo esc_html( $hero_line_1 ); ?></span><strong><?php echo esc_html( $hero_line_2 ); ?></strong></h1>
			<span class="management-rule"></span>
			<p><?php echo esc_html( $hero_description ); ?></p>
		</div>
	</div>
</section>

<div class="management-page">
	<section class="management-section management-team" id="leadership">
		<div class="rivross-container rivross-container--wide">
			<header class="management-section__heading">
				<span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_management_intro_eyebrow', __( 'Our Management Team', 'rivross-corporate' ) ) ); ?></span>
				<h2><?php echo esc_html( get_theme_mod( 'rivross_management_intro_title', __( 'Experience. Vision. Leadership.', 'rivross-corporate' ) ) ); ?></h2>
				<span class="management-heading-rule"></span>
				<p><?php echo esc_html( get_theme_mod( 'rivross_management_intro_description', __( 'Our management team brings together decades of experience in real estate, development, finance and operations to drive sustainable growth and lasting value.', 'rivross-corporate' ) ) ); ?></p>
			</header>

			<div class="management-team-grid">
				<?php $leaders_to_render = $dynamic_leaders_enabled ? $dynamic_leaders : $leaders; ?>
				<?php foreach ( $leaders_to_render as $index => $leader ) : $number = $index + 1; ?>
					<?php
					if ( $dynamic_leaders_enabled ) {
						$dynamic_leader = $dynamic_leaders[ $index ];
						$image          = $dynamic_leader['image'] ? $dynamic_leader['image'] : $home_uri . 'leadership-placeholder.png';
						$name           = $dynamic_leader['name'];
						$role           = $dynamic_leader['role'];
						$description    = $dynamic_leader['bio'];
						$profile_url    = $dynamic_leader['url'] && '#' !== $dynamic_leader['url'] ? $dynamic_leader['url'] : home_url( '/management/#leadership' );
						$socials        = $dynamic_leader['socials'];
					} else {
						$leader_default_image = 0 === strpos( $leader[0], '../leadership/' ) ? $leadership_uri . substr( $leader[0], 14 ) : $home_uri . $leader[0];
						$image       = get_theme_mod( 'rivross_management_leader_' . $number . '_image', $leader_default_image );
						$name        = get_theme_mod( 'rivross_management_leader_' . $number . '_name', $leader[1] );
						$role        = get_theme_mod( 'rivross_management_leader_' . $number . '_role', $leader[2] );
						$description = str_replace( '\\n', "\n", (string) get_theme_mod( 'rivross_management_leader_' . $number . '_description', $leader[3] ) );
						$profile_url = get_theme_mod( 'rivross_management_leader_' . $number . '_url', '#' );
						$socials     = ( $profile_url && '#' !== trim( $profile_url ) ) ? array( 'linkedin' => $profile_url ) : array();
					}
					?>
					<article class="management-leader-card">
						<div class="management-leader-card__media"><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy"></div>
						<div class="management-leader-card__body">
							<h3><?php echo esc_html( $name ); ?></h3>
							<span class="management-leader-card__role"><?php echo esc_html( $role ); ?></span>
							<p><?php echo esc_html( $description ); ?></p>
							<?php echo rivross_leadership_social_links( $socials, $name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="management-section management-stats" aria-label="<?php esc_attr_e( 'Leadership statistics', 'rivross-corporate' ); ?>">
		<div class="rivross-container rivross-container--wide management-stats__grid">
			<?php foreach ( $stats as $index => $stat ) : $number = $index + 1; ?>
				<?php
				$icon     = get_theme_mod( 'rivross_management_stat_' . $number . '_icon', $stat[0] );
				$value    = get_theme_mod( 'rivross_management_stat_' . $number . '_value', $stat[1] );
				$title    = get_theme_mod( 'rivross_management_stat_' . $number . '_title', $stat[2] );
				$subtitle = get_theme_mod( 'rivross_management_stat_' . $number . '_subtitle', $stat[3] );
				?>
				<div class="management-stat">
					<span class="management-stat__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $icon ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<div><strong><?php echo esc_html( $value ); ?></strong><b><?php echo esc_html( $title ); ?></b><?php if ( '' !== trim( (string) $subtitle ) ) : ?><small><?php echo esc_html( $subtitle ); ?></small><?php endif; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="management-section management-commitment">
		<div class="rivross-container rivross-container--wide management-commitment__grid">
			<div class="management-commitment__media"><img src="<?php echo esc_url( $commitment_image ); ?>" alt="<?php esc_attr_e( 'RIVROSS leadership team in a boardroom', 'rivross-corporate' ); ?>" loading="lazy"></div>
			<div class="management-commitment__copy">
				<span class="rivross-eyebrow"><?php echo esc_html( $commitment_eyebrow ); ?></span>
				<h2><?php echo esc_html( $commitment_title ); ?></h2>
				<p><?php echo esc_html( $commitment_description ); ?></p>
				<a class="rivross-button" href="<?php echo esc_url( rivross_theme_link( $commitment_url ) ); ?>"><?php echo esc_html( $commitment_label ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
		</div>
	</section>

	<section class="management-page-cta" style="--management-cta-image: url('<?php echo esc_url( $hero_image ); ?>');">
		<div class="rivross-container rivross-container--wide management-page-cta__inner">
			<div><h2><?php echo esc_html( $cta_heading ); ?></h2><p><?php echo esc_html( $cta_description ); ?></p></div>
			<div class="management-page-cta__actions">
				<a class="rivross-button" href="<?php echo esc_url( rivross_theme_link( $cta_primary_url ) ); ?>"><?php echo esc_html( $cta_primary_label ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<a class="rivross-button rivross-button--outline" href="<?php echo esc_url( rivross_theme_link( $cta_secondary_url ) ); ?>"><?php echo esc_html( $cta_secondary_label ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
		</div>
	</section>
</div>

<?php get_footer(); ?>
