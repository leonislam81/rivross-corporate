<?php
/**
 * Our Companies page template.
 *
 * @package Rivross_Corporate
 */

get_header();

$image_uri = get_theme_file_uri( '/assets/images/companies/' );

$hero_image       = get_theme_mod( 'rivross_companies_hero_image', $image_uri . 'companies-hero.png' );
$breadcrumb_home  = get_theme_mod( 'rivross_companies_breadcrumb_home', __( 'Home', 'rivross-corporate' ) );
$breadcrumb_page  = get_theme_mod( 'rivross_companies_breadcrumb_page', __( 'Our Companies', 'rivross-corporate' ) );
$hero_line_1      = get_theme_mod( 'rivross_companies_hero_line_1', __( 'Our', 'rivross-corporate' ) );
$hero_line_2      = get_theme_mod( 'rivross_companies_hero_line_2', __( 'Companies', 'rivross-corporate' ) );
$hero_description = str_replace( '\\n', "\n", (string) get_theme_mod( 'rivross_companies_hero_description', __( 'RIVROSS Company Limited operates through diverse business verticals, each committed to excellence and driven by our core values.', 'rivross-corporate' ) ) );

$businesses = array(
	array(
		'image'    => 'business-real-estate.png',
		'icon'     => 'building',
		'title'    => 'Real Estate',
		'description' => 'From residential to commercial developments, we build premium properties and communities that stand the test of time.',
		'features' => array( 'Property Development', 'Sales & Marketing', 'Investment Opportunities', 'Property Management' ),
		'button'   => 'Explore Real Estate',
		'url'      => home_url( '/real-estate/' ),
	),
	array(
		'image'    => 'business-travel.png',
		'icon'     => 'plane',
		'title'    => 'Travel & Tourism',
		'description' => 'We offer comprehensive travel solutions and unforgettable experiences around the world with reliability and care.',
		'features' => array( 'Air Ticketing', 'Hotel Booking', 'Tour Packages', 'Hajj & Umrah', 'Corporate Travel' ),
		'button'   => 'Explore Travel & Tourism',
		'url'      => '#travel',
	),
	array(
		'image'    => 'business-tea.png',
		'icon'     => 'leaf',
		'title'    => 'Tea Business',
		'description' => 'Delivering the finest quality tea sourced from the best gardens of Bangladesh to local and international markets.',
		'features' => array( 'Tea Sourcing', 'Wholesale Supply', 'Distribution', 'Corporate Supply' ),
		'button'   => 'Explore Tea Business',
		'url'      => '#tea',
	),
);

$stats = array(
	array( 'building', '3+', 'Business Verticals', 'Strong & Growing' ),
	array( 'chart', '100+', 'Projects Completed', 'Across Sectors' ),
	array( 'users', '50+', 'Expert Professionals', 'Dedicated Team' ),
	array( 'globe', '500+', 'Happy Clients', 'Worldwide' ),
);

$cta_icon        = get_theme_mod( 'rivross_companies_cta_icon', 'users' );
$cta_title       = get_theme_mod( 'rivross_companies_cta_title', __( 'Looking for Business Opportunities?', 'rivross-corporate' ) );
$cta_description = get_theme_mod( 'rivross_companies_cta_description', __( 'Partner with us and be a part of our growth journey.', 'rivross-corporate' ) );
$cta_label       = get_theme_mod( 'rivross_companies_cta_button_label', __( 'Send an Inquiry', 'rivross-corporate' ) );
$cta_url         = get_theme_mod( 'rivross_companies_cta_button_url', '#contact' );
?>

<section class="companies-hero" style="--companies-hero-image: url('<?php echo esc_url( $hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide companies-hero__inner">
		<nav class="companies-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $breadcrumb_home ); ?></a>
			<span aria-hidden="true">›</span>
			<span><?php echo esc_html( $breadcrumb_page ); ?></span>
		</nav>
		<div class="companies-hero__copy">
			<h1><span><?php echo esc_html( $hero_line_1 ); ?></span><strong><?php echo esc_html( $hero_line_2 ); ?></strong></h1>
			<span class="companies-rule"></span>
			<p><?php echo esc_html( $hero_description ); ?></p>
		</div>
	</div>
</section>

<div class="companies-page">
	<section id="businesses" class="companies-section companies-intro">
		<div class="rivross-container rivross-container--wide">
			<div class="companies-section__heading">
				<span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_companies_intro_eyebrow', __( 'Diversified Businesses', 'rivross-corporate' ) ) ); ?></span>
				<h2><?php echo esc_html( get_theme_mod( 'rivross_companies_intro_title', __( 'One Vision. Multiple Businesses.', 'rivross-corporate' ) ) ); ?></h2>
				<p><?php echo esc_html( get_theme_mod( 'rivross_companies_intro_description', __( 'Our diverse business portfolio allows us to create value across industries and deliver sustainable growth for our clients, partners and communities.', 'rivross-corporate' ) ) ); ?></p>
			</div>

			<div class="companies-business-grid">
				<?php foreach ( $businesses as $index => $business ) : $number = $index + 1; ?>
					<?php
					$image       = get_theme_mod( 'rivross_companies_business_' . $number . '_image', $image_uri . $business['image'] );
					$icon        = get_theme_mod( 'rivross_companies_business_' . $number . '_icon', $business['icon'] );
					$title       = get_theme_mod( 'rivross_companies_business_' . $number . '_title', $business['title'] );
					$description = get_theme_mod( 'rivross_companies_business_' . $number . '_description', $business['description'] );
					$button      = get_theme_mod( 'rivross_companies_business_' . $number . '_button_label', $business['button'] );
					$url         = get_theme_mod( 'rivross_companies_business_' . $number . '_button_url', $business['url'] );
					?>
					<article class="companies-business-card">
						<div class="companies-business-card__media" style="--card-image: url('<?php echo esc_url( $image ); ?>');">
							<span class="companies-business-card__number"><?php echo esc_html( sprintf( '%02d', $number ) ); ?></span>
							<span class="companies-business-card__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $icon ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						</div>
						<div class="companies-business-card__body">
							<h3><?php echo esc_html( $title ); ?></h3>
							<span class="companies-card-rule"></span>
							<p><?php echo esc_html( $description ); ?></p>
							<ul>
								<?php foreach ( $business['features'] as $feature_index => $feature ) : $feature_number = $feature_index + 1; ?>
									<?php $feature = get_theme_mod( 'rivross_companies_business_' . $number . '_feature_' . $feature_number, $feature ); ?>
									<?php if ( '' !== trim( (string) $feature ) ) : ?>
										<li><?php echo rivross_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $feature ); ?></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
							<a class="rivross-button rivross-button--dark" href="<?php echo esc_url( rivross_theme_link( $url ) ); ?>"><?php echo esc_html( $button ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>

			<div class="companies-stats">
				<?php foreach ( $stats as $index => $stat ) : $number = $index + 1; ?>
					<?php $stat_icon = get_theme_mod( 'rivross_companies_stat_' . $number . '_icon', $stat[0] ); $stat_value = get_theme_mod( 'rivross_companies_stat_' . $number . '_value', $stat[1] ); $stat_title = get_theme_mod( 'rivross_companies_stat_' . $number . '_title', $stat[2] ); $stat_subtitle = get_theme_mod( 'rivross_companies_stat_' . $number . '_subtitle', $stat[3] ); ?>
					<div class="companies-stat">
						<?php echo rivross_icon( rivross_sanitize_icon_choice( $stat_icon ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<strong><?php echo esc_html( $stat_value ); ?></strong>
						<b><?php echo esc_html( $stat_title ); ?></b>
						<small><?php echo esc_html( $stat_subtitle ); ?></small>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="companies-inquiry">
				<span class="companies-inquiry__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $cta_icon ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<div><h3><?php echo esc_html( $cta_title ); ?></h3><p><?php echo esc_html( $cta_description ); ?></p></div>
				<a class="rivross-button" href="<?php echo esc_url( rivross_theme_link( $cta_url ) ); ?>"><?php echo esc_html( $cta_label ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
		</div>
	</section>
</div>

<?php get_footer(); ?>
