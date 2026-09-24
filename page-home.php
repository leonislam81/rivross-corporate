<?php
/**
 * Template Name: Home Page
 * Template Post Type: page
 *
 * RIVROSS homepage with editable Hero Slides and Customizer-managed sections.
 *
 * Hero slides and the latest property/project showcase entries are managed
 * from the dashboard; section headings and supporting copy remain editable
 * through the theme's Customizer controls.
 *
 * @package Rivross_Corporate
 */

get_header();

$image_uri = get_theme_file_uri( '/assets/images/home/' );

$hero_default_image   = $image_uri . 'hero-city.png';
$hero_image           = get_theme_mod( 'rivross_home_hero_image', $hero_default_image );

// The previous hero asset included the headline and buttons baked into the
// image. Keep the editable HTML copy as the only source of hero text.
if ( false !== strpos( (string) $hero_image, 'hero-city-v2' ) ) {
	$hero_image = $hero_default_image;
}
$hero_fallback = array(
	'kicker'          => get_theme_mod( 'rivross_home_hero_kicker', __( 'RIVROSS Company Limited', 'rivross-corporate' ) ),
	'line_1'          => get_theme_mod( 'rivross_home_hero_line_1', __( 'Building Businesses.', 'rivross-corporate' ) ),
	'line_2'          => get_theme_mod( 'rivross_home_hero_line_2', __( 'Creating Opportunities.', 'rivross-corporate' ) ),
	'description'     => get_theme_mod( 'rivross_home_hero_description', __( 'RIVROSS Company Limited is a diversified business organization operating across Real Estate, Travel & Tourism, Tea Business and future business ventures.', 'rivross-corporate' ) ),
	'primary_label'   => get_theme_mod( 'rivross_home_hero_primary_label', __( 'Explore Our Businesses', 'rivross-corporate' ) ),
	'primary_url'     => get_theme_mod( 'rivross_home_hero_primary_url', '#businesses' ),
	'secondary_label' => get_theme_mod( 'rivross_home_hero_secondary_label', __( 'Contact Us', 'rivross-corporate' ) ),
	'secondary_url'   => get_theme_mod( 'rivross_home_hero_secondary_url', '#contact' ),
	'image'           => $hero_image,
);
$hero_slides = function_exists( 'rivross_get_hero_slides' ) ? rivross_get_hero_slides() : array();
if ( ! empty( $hero_slides ) ) {
	foreach ( $hero_slides as $index => $slide ) {
		$hero_slides[ $index ] = array_merge( $hero_fallback, $slide );
		if ( empty( $hero_slides[ $index ]['image'] ) ) {
			$hero_slides[ $index ]['image'] = $hero_fallback['image'];
		}
	}
} else {
	$hero_slides = array( $hero_fallback );
}
$hero_carousel_enabled = (bool) get_theme_mod( 'rivross_home_hero_carousel_enabled', true );
$hero_carousel_autoplay = (bool) get_theme_mod( 'rivross_home_hero_carousel_autoplay', true );
$hero_carousel_interval = max( 2500, absint( get_theme_mod( 'rivross_home_hero_carousel_interval', 6000 ) ) );
$hero_carousel_arrows   = (bool) get_theme_mod( 'rivross_home_hero_carousel_arrows', false );
$hero_carousel_dots     = (bool) get_theme_mod( 'rivross_home_hero_carousel_dots', true );
$hero_slide_count       = count( $hero_slides );

$about_eyebrow       = get_theme_mod( 'rivross_home_about_eyebrow', __( 'Who We Are', 'rivross-corporate' ) );
$about_title         = get_theme_mod( 'rivross_home_about_title', __( 'About RIVROSS', 'rivross-corporate' ) );
$about_description   = get_theme_mod( 'rivross_home_about_description', __( 'RIVROSS Company Limited is a dynamic and forward-thinking organization committed to delivering value through multiple business sectors. Our goal is to create sustainable growth, professional service and long-term partnerships.', 'rivross-corporate' ) );
$about_button_label  = get_theme_mod( 'rivross_home_about_button_label', __( 'Read More About Us', 'rivross-corporate' ) );
$about_button_url    = get_theme_mod( 'rivross_home_about_button_url', '#about' );
?>

<section class="home-hero<?php echo $hero_carousel_enabled ? '' : ' home-hero--static'; ?>" data-rivross-hero-carousel data-enabled="<?php echo $hero_carousel_enabled ? '1' : '0'; ?>" data-autoplay="<?php echo $hero_carousel_autoplay ? '1' : '0'; ?>" data-interval="<?php echo esc_attr( $hero_carousel_interval ); ?>" data-show-arrows="<?php echo $hero_carousel_arrows ? '1' : '0'; ?>" data-show-dots="<?php echo $hero_carousel_dots ? '1' : '0'; ?>" style="--hero-image: url('<?php echo esc_url( $hero_slides[0]['image'] ); ?>');">
	<div class="home-hero__slides">
		<?php foreach ( $hero_slides as $index => $slide ) : ?>
			<article class="home-hero__slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-slide-index="<?php echo esc_attr( $index ); ?>" style="--hero-image: url('<?php echo esc_url( $slide['image'] ); ?>');" aria-roledescription="<?php esc_attr_e( 'slide', 'rivross-corporate' ); ?>" aria-label="<?php echo esc_attr( sprintf( __( '%1$d of %2$d', 'rivross-corporate' ), $index + 1, $hero_slide_count ) ); ?>" aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>">
				<div class="rivross-container rivross-container--wide home-hero__inner">
					<div class="home-hero__copy">
						<span class="home-hero__kicker"><?php echo esc_html( $slide['kicker'] ); ?></span>
						<h1><span><?php echo esc_html( $slide['line_1'] ); ?></span><strong><?php echo esc_html( $slide['line_2'] ); ?></strong></h1>
						<p><?php echo esc_html( $slide['description'] ); ?></p>
						<div class="home-hero__actions">
							<a class="rivross-button" href="<?php echo esc_url( rivross_theme_link( $slide['primary_url'] ) ); ?>"><?php echo esc_html( $slide['primary_label'] ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
							<a class="rivross-button rivross-button--outline" href="<?php echo esc_url( rivross_theme_link( $slide['secondary_url'] ) ); ?>"><?php echo esc_html( $slide['secondary_label'] ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
						</div>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
	<button class="home-hero__control home-hero__control--prev" type="button" aria-label="<?php esc_attr_e( 'Previous hero slide', 'rivross-corporate' ); ?>" hidden><?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
	<button class="home-hero__control home-hero__control--next" type="button" aria-label="<?php esc_attr_e( 'Next hero slide', 'rivross-corporate' ); ?>" hidden><?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
	<div class="home-hero__pager" role="tablist" aria-label="<?php esc_attr_e( 'Hero slides', 'rivross-corporate' ); ?>" hidden></div>
</section>

<section id="about" class="home-about home-section">
	<div class="rivross-container rivross-container--wide home-about__grid">
		<div class="home-about__intro">
			<span class="rivross-eyebrow"><?php echo esc_html( $about_eyebrow ); ?></span>
			<h2><?php echo esc_html( $about_title ); ?></h2>
			<p><?php echo esc_html( $about_description ); ?></p>
			<a class="rivross-button rivross-button--dark" href="<?php echo esc_url( rivross_theme_link( $about_button_url ) ); ?>"><?php echo esc_html( $about_button_label ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
		</div>
		<div class="home-about__strengths">
			<?php
			$about_strengths = array(
				array( 'building', 'Multiple Business Sectors', 'Diversified portfolio for sustainable growth' ),
				array( 'users', 'Professional Management', 'Experienced leadership driving the organization' ),
				array( 'handshake', 'Trusted Partnerships', 'Building long-term business relationships' ),
				array( 'chart', 'Growth Oriented', 'Committed to excellence and innovation' ),
				array( 'shield', 'Customer Focused', 'Delivering exceptional value and service' ),
				array( 'sprout', 'Sustainable Growth', 'Building lasting value for communities and partners' ),
				array( 'lightbulb', 'Innovation Driven', 'Embracing new ideas for better solutions' ),
				array( 'award', 'Trusted Service', 'Reliable support from first contact to delivery' ),
			);
			foreach ( $about_strengths as $index => $strength ) {
				$number             = $index + 1;
				$strength[0]        = get_theme_mod( 'rivross_home_strength_' . $number . '_icon', $strength[0] );
				$strength[1]        = get_theme_mod( 'rivross_home_strength_' . $number . '_title', $strength[1] );
				$strength[2]        = get_theme_mod( 'rivross_home_strength_' . $number . '_description', $strength[2] );
				$about_strengths[ $index ] = $strength;
			}
			foreach ( $about_strengths as $strength ) :
				?>
				<div class="home-about__strength">
					<?php echo rivross_icon( rivross_sanitize_icon_choice( $strength[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<h3><?php echo esc_html( $strength[1] ); ?></h3>
					<p><?php echo esc_html( $strength[2] ); ?></p>
				</div>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>

<section id="businesses" class="home-businesses home-section home-section--surface">
	<div class="rivross-container rivross-container--wide">
		<div class="home-section__heading">
			<span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_home_businesses_eyebrow', __( 'Our Core Businesses', 'rivross-corporate' ) ) ); ?></span>
			<h2><?php echo esc_html( get_theme_mod( 'rivross_home_businesses_title', __( 'Our Business Verticals', 'rivross-corporate' ) ) ); ?></h2>
		</div>
		<div class="business-grid">
			<?php
			$business_property_posts       = get_posts(
				array(
					'post_type'      => 'rivross_property',
					'post_status'    => 'publish',
					'posts_per_page' => 12,
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);
			$real_estate_backgrounds = array();
			if ( ! empty( $business_property_posts ) && function_exists( 'rivross_property_image_url' ) ) {
				foreach ( $business_property_posts as $business_property_post ) {
					$property_background = rivross_property_image_url( $business_property_post->ID );
					if ( $property_background && ! in_array( $property_background, $real_estate_backgrounds, true ) ) {
						$real_estate_backgrounds[] = $property_background;
					}
				}
			}
			$businesses = array(
				array( 'business-real-estate.png', 'building', 'Real Estate', 'Property development, sales, investment opportunities and project marketing.', 'Explore Real Estate', home_url( '/real-estate/' ) ),
				array( 'business-travel.png', 'plane', 'Travel & Tourism', 'Air ticketing, hotel booking, tour packages, Hajj & Umrah and corporate travel services.', 'Explore Travel', home_url( '/travel-tourism/' ) ),
				array( 'business-tea.png', 'leaf', 'Tea Business', 'Tea supply, wholesale, distribution and supply across Bangladesh.', 'Explore Tea Business', home_url( '/tea-business/' ) ),
			);
			foreach ( $businesses as $index => $business ) :
				$number = $index + 1;
				$business[0] = get_theme_mod( 'rivross_home_business_' . $number . '_image', $image_uri . $business[0] );
				if ( 0 === $index && ! empty( $real_estate_backgrounds ) ) {
					$business[0] = $real_estate_backgrounds[0];
				}
				$business[1] = get_theme_mod( 'rivross_home_business_' . $number . '_icon', $business[1] );
				$business[2] = get_theme_mod( 'rivross_home_business_' . $number . '_title', $business[2] );
				$business[3] = get_theme_mod( 'rivross_home_business_' . $number . '_description', $business[3] );
				$business[4] = get_theme_mod( 'rivross_home_business_' . $number . '_button_label', $business[4] );
				$business[5] = get_theme_mod( 'rivross_home_business_' . $number . '_button_url', $business[5] );
				$travel_motion_enabled = false;
				$travel_image_path = (string) wp_parse_url( $business[0], PHP_URL_PATH );
				if ( 1 === $index && 'business-travel.png' === wp_basename( $travel_image_path ) ) {
					$business[0]            = $image_uri . 'business-travel-static.png';
					$travel_motion_enabled = true;
				}
				$business_class = 'business-card';
				if ( 0 === $index ) {
					$business_class .= ' business-card--real-estate';
				} elseif ( 1 === $index ) {
					$business_class .= ' business-card--travel';
				} else {
					$business_class .= ' business-card--tea';
				}
				?>
				<article class="<?php echo esc_attr( $business_class ); ?>" style="--card-image: url('<?php echo esc_url( $business[0] ); ?>');"<?php if ( 0 === $index && count( $real_estate_backgrounds ) > 1 ) : ?> data-business-images="<?php echo esc_attr( wp_json_encode( $real_estate_backgrounds ) ); ?>" data-business-interval="5000"<?php endif; ?>>
					<?php if ( 0 === $index && count( $real_estate_backgrounds ) > 1 ) : ?>
						<span class="business-card__media business-card__media--primary" aria-hidden="true"></span>
						<span class="business-card__media business-card__media--secondary" aria-hidden="true"></span>
					<?php endif; ?>
					<?php if ( 1 === $index && $travel_motion_enabled ) : ?>
						<span class="business-card__cloud business-card__cloud--one" aria-hidden="true"></span>
						<span class="business-card__cloud business-card__cloud--two" aria-hidden="true"></span>
						<span class="business-card__cloud business-card__cloud--three" aria-hidden="true"></span>
						<img class="business-card__plane" src="<?php echo esc_url( $image_uri . 'business-travel-plane.png' ); ?>" alt="" aria-hidden="true" loading="lazy">
					<?php endif; ?>
					<?php if ( 2 === $index ) : ?>
						<span class="business-card__mist business-card__mist--one" aria-hidden="true"></span>
						<span class="business-card__mist business-card__mist--two" aria-hidden="true"></span>
						<span class="business-card__mist business-card__mist--three" aria-hidden="true"></span>
					<?php endif; ?>
					<div class="business-card__content">
						<div class="business-card__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $business[1] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<h3><?php echo esc_html( $business[2] ); ?></h3>
						<p><?php echo esc_html( $business[3] ); ?></p>
						<a href="<?php echo esc_url( rivross_theme_link( $business[5] ) ); ?>"><?php echo esc_html( $business[4] ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					</div>
				</article>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>

<section class="home-why home-section">
	<div class="rivross-container rivross-container--wide">
		<div class="home-section__heading home-section__heading--dark">
			<span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_home_why_eyebrow', __( 'Why Choose RIVROSS?', 'rivross-corporate' ) ) ); ?></span>
		</div>
		<div class="why-grid">
			<?php
			$why_items = array(
				array( 'award', 'Professional Management' ),
				array( 'gear', 'Quality Services' ),
				array( 'shield', 'Customer Satisfaction' ),
				array( 'headset', 'Reliable Support' ),
				array( 'sprout', 'Sustainable Growth' ),
			);
			foreach ( $why_items as $index => $why_item ) :
				$number        = $index + 1;
				$why_item[0]   = get_theme_mod( 'rivross_home_why_' . $number . '_icon', $why_item[0] );
				$why_item[1]   = get_theme_mod( 'rivross_home_why_' . $number . '_label', $why_item[1] );
				?>
				<div class="why-item">
					<?php echo rivross_icon( rivross_sanitize_icon_choice( $why_item[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php echo esc_html( $why_item[1] ); ?></span>
				</div>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>

<section id="projects" class="home-showcase home-section">
	<div class="rivross-container rivross-container--wide showcase-grid">
		<div class="showcase-panel">
			<div class="showcase-panel__heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_home_properties_title', __( 'Featured Properties', 'rivross-corporate' ) ) ); ?></h2><a href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_home_properties_view_all_url', home_url( '/real-estate/' ) ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_home_properties_view_all_label', __( 'View All Properties', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div>
			<div class="property-grid">
				<?php
				$property_posts = get_posts(
					array(
						'post_type'      => 'rivross_property',
						'post_status'    => 'publish',
						'posts_per_page' => 3,
						'orderby'        => 'date',
						'order'          => 'DESC',
					)
				);
				if ( ! empty( $property_posts ) && function_exists( 'rivross_property_meta' ) ) :
					foreach ( $property_posts as $property_post ) :
						$property_id = $property_post->ID;
						$property_terms = get_the_terms( $property_id, 'rivross_property_type' );
						$property_type = ! empty( $property_terms ) && ! is_wp_error( $property_terms ) ? $property_terms[0]->name : rivross_property_meta( $property_id, 'type', __( 'Property', 'rivross-corporate' ) );
						$property_url  = get_permalink( $property_id );
						?>
						<article class="property-card">
							<a class="property-card__image-link" href="<?php echo esc_url( $property_url ); ?>"><img src="<?php echo esc_url( rivross_property_image_url( $property_id ) ); ?>" alt="<?php echo esc_attr( get_the_title( $property_id ) ); ?>" loading="lazy"></a>
							<div class="property-card__body"><span class="property-card__tag"><?php echo esc_html( $property_type ); ?></span><h3><a href="<?php echo esc_url( $property_url ); ?>"><?php echo esc_html( get_the_title( $property_id ) ); ?></a></h3><p><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( rivross_property_meta( $property_id, 'location' ) ); ?></p><strong><?php echo esc_html( rivross_property_meta( $property_id, 'price' ) ); ?></strong></div>
						</article>
						<?php
					endforeach;
				else :
					$property_fallbacks = array(
						array( 'business-real-estate.png', 'Apartment', 'Rivross Lake View Residence', 'Uttara, Dhaka', 'BDT 6,500 /sqft' ),
						array( 'property-tower.png', 'Apartment', 'Rivross Green Heights', 'Bashundhara, Dhaka', 'BDT 7,200 /sqft' ),
						array( 'property-tower.png', 'Commercial', 'Rivross Corporate Tower', 'Gulshan, Dhaka', 'BDT 18,000 /sqft' ),
					);
					foreach ( $property_fallbacks as $property ) :
						?>
						<article class="property-card">
							<img src="<?php echo esc_url( $image_uri . $property[0] ); ?>" alt="<?php echo esc_attr( $property[2] ); ?>" loading="lazy">
							<div class="property-card__body"><span class="property-card__tag"><?php echo esc_html( $property[1] ); ?></span><h3><?php echo esc_html( $property[2] ); ?></h3><p><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $property[3] ); ?></p><strong><?php echo esc_html( $property[4] ); ?></strong></div>
						</article>
						<?php
					endforeach;
				endif;
				?>
			</div>
		</div>

		<div id="services" class="showcase-panel">
			<div class="showcase-panel__heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_home_services_title', __( 'Travel Services', 'rivross-corporate' ) ) ); ?></h2><a href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_home_services_view_all_url', '#travel' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_home_services_view_all_label', __( 'View All Services', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div>
			<div class="service-grid">
				<?php
				$services = array(
					array( 'plane', 'Air Ticket', '#travel' ), array( 'hotel', 'Hotel Booking', '#travel' ), array( 'suitcase', 'Tour Packages', '#travel' ),
					array( 'kaaba', 'Hajj & Umrah', '#travel' ), array( 'briefcase', 'Corporate Travel', '#travel' ), array( 'globe', 'Visa Assistance', '#travel' ),
				);
				foreach ( $services as $index => $service ) :
					$number      = $index + 1;
					$service[0]  = get_theme_mod( 'rivross_home_service_' . $number . '_icon', $service[0] );
					$service[1]  = get_theme_mod( 'rivross_home_service_' . $number . '_label', $service[1] );
					$service[2]  = get_theme_mod( 'rivross_home_service_' . $number . '_url', $service[2] );
					?><a class="service-item" href="<?php echo esc_url( rivross_theme_link( $service[2] ) ); ?>"><?php echo rivross_icon( rivross_sanitize_icon_choice( $service[0] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $service[1] ); ?></span></a><?php
				endforeach;
				?>
			</div>
		</div>
	</div>
</section>

<section class="home-network home-section home-section--surface">
	<div class="rivross-container rivross-container--wide network-grid">
		<div class="showcase-panel">
			<div class="showcase-panel__heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_home_projects_title', __( 'Our Projects', 'rivross-corporate' ) ) ); ?></h2><a href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_home_projects_view_all_url', home_url( '/projects/' ) ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_home_projects_view_all_label', __( 'View All Projects', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div>
			<div class="project-grid">
				<?php
				$project_posts = get_posts(
					array(
						'post_type'      => 'rivross_project',
						'post_status'    => 'publish',
						'posts_per_page' => 3,
						'orderby'        => 'date',
						'order'          => 'DESC',
					)
				);
				if ( ! empty( $project_posts ) && function_exists( 'rivross_project_meta' ) ) :
					foreach ( $project_posts as $project_post ) :
						$project_id = $project_post->ID;
						$project_status = rivross_project_meta( $project_id, 'status', __( 'Project', 'rivross-corporate' ) );
						$project_url = get_permalink( $project_id );
						?>
						<article class="project-card"><a class="project-card__image-link" href="<?php echo esc_url( $project_url ); ?>"><div class="project-card__image"><img src="<?php echo esc_url( rivross_project_image_url( $project_id ) ); ?>" alt="<?php echo esc_attr( get_the_title( $project_id ) ); ?>" loading="lazy"><span class="project-card__status"><?php echo esc_html( $project_status ); ?></span></div></a><h3><a href="<?php echo esc_url( $project_url ); ?>"><?php echo esc_html( get_the_title( $project_id ) ); ?></a></h3><p><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( rivross_project_meta( $project_id, 'location' ) ); ?></p><small><?php echo esc_html( rivross_project_meta( $project_id, 'timeline' ) ); ?></small></article>
						<?php
					endforeach;
				else :
					$project_fallbacks = array(
						array( 'business-real-estate.png', 'Ongoing', 'Rivross Heights', 'Bashundhara, Dhaka', 'Completion: Dec 2026' ),
						array( 'property-tower.png', 'Upcoming', 'Rivross City Center', 'Mirpur, Dhaka', 'Completion: Jun 2027' ),
						array( 'business-real-estate.png', 'Completed', 'Rivross Garden', 'Uttara, Dhaka', 'Completed: 2024' ),
					);
					foreach ( $project_fallbacks as $project ) :
						?><article class="project-card"><div class="project-card__image"><img src="<?php echo esc_url( $image_uri . $project[0] ); ?>" alt="<?php echo esc_attr( $project[2] ); ?>" loading="lazy"><span class="project-card__status"><?php echo esc_html( $project[1] ); ?></span></div><h3><?php echo esc_html( $project[2] ); ?></h3><p><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $project[3] ); ?></p><small><?php echo esc_html( $project[4] ); ?></small></article><?php
					endforeach;
				endif;
				?>
			</div>
		</div>
		<div class="showcase-panel partners-panel">
			<?php
			$partners_carousel_enabled = (bool) get_theme_mod( 'rivross_home_partners_carousel_enabled', true );
			$partners_carousel_autoplay = (bool) get_theme_mod( 'rivross_home_partners_carousel_autoplay', true );
			$partners_carousel_interval = max( 2000, absint( get_theme_mod( 'rivross_home_partners_carousel_interval', 5000 ) ) );
			$partners_carousel_arrows   = (bool) get_theme_mod( 'rivross_home_partners_carousel_arrows', false );
			$partners_carousel_dots     = (bool) get_theme_mod( 'rivross_home_partners_carousel_dots', true );
			$partners_carousel_desktop  = min( 5, max( 1, absint( get_theme_mod( 'rivross_home_partners_carousel_desktop', 4 ) ) ) );
			$partners_carousel_tablet   = min( 3, max( 1, absint( get_theme_mod( 'rivross_home_partners_carousel_tablet', 3 ) ) ) );
			$partners_carousel_mobile   = min( 2, max( 1, absint( get_theme_mod( 'rivross_home_partners_carousel_mobile', 2 ) ) ) );
			$partner_logo_defaults       = rivross_get_partner_logo_default_urls();
			$partner_logos        = array();
			$partner_gallery_mod  = get_theme_mod( 'rivross_home_partner_logo_gallery', null );
			if ( null !== $partner_gallery_mod ) {
				$partner_gallery_items = json_decode( (string) $partner_gallery_mod, true );
				if ( is_array( $partner_gallery_items ) ) {
					foreach ( $partner_gallery_items as $partner_index => $partner_logo ) {
						if ( is_array( $partner_logo ) && isset( $partner_logo['url'] ) ) {
							$partner_logo = $partner_logo['url'];
						}
						$partner_logo = trim( (string) $partner_logo );
						if ( '' !== $partner_logo ) {
							$partner_logos[] = array(
								'url' => $partner_logo,
								'alt' => sprintf( __( 'RIVROSS Partner %d logo', 'rivross-corporate' ), $partner_index + 1 ),
							);
						}
					}
				}
			} else {
				/* Keep the old per-slot values as a backward-compatible fallback. */
				for ( $partner_index = 1; $partner_index <= 8; $partner_index++ ) {
					$partner_default = isset( $partner_logo_defaults[ $partner_index ] ) ? $partner_logo_defaults[ $partner_index ] : '';
					$partner_logo    = trim( (string) get_theme_mod( 'rivross_home_partner_' . $partner_index . '_logo', $partner_default ) );
					if ( '' !== $partner_logo ) {
						$partner_logos[] = array(
							'url' => $partner_logo,
							'alt' => sprintf( __( 'RIVROSS Partner %d logo', 'rivross-corporate' ), $partner_index ),
						);
					}
				}
			}
			$has_partner_logos = ! empty( $partner_logos );
			?>
			<div class="showcase-panel__heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_home_partners_title', __( 'Our Partners', 'rivross-corporate' ) ) ); ?></h2></div>
			<div class="partners-carousel<?php echo $partners_carousel_enabled ? '' : ' partners-carousel--static'; ?>" data-rivross-carousel data-enabled="<?php echo $partners_carousel_enabled ? '1' : '0'; ?>" data-autoplay="<?php echo $partners_carousel_autoplay ? '1' : '0'; ?>" data-interval="<?php echo esc_attr( $partners_carousel_interval ); ?>" data-show-arrows="<?php echo $partners_carousel_arrows ? '1' : '0'; ?>" data-show-dots="<?php echo $partners_carousel_dots ? '1' : '0'; ?>" data-desktop="<?php echo esc_attr( $partners_carousel_desktop ); ?>" data-tablet="<?php echo esc_attr( $partners_carousel_tablet ); ?>" data-mobile="<?php echo esc_attr( $partners_carousel_mobile ); ?>" data-viewport-selector=".partners-carousel__viewport" data-track-selector=".partners-carousel__track" data-slide-selector=".partners-carousel__slide" data-previous-selector=".partners-carousel__control--prev" data-next-selector=".partners-carousel__control--next" data-empty-class="partners-carousel--empty" data-static-class="partners-carousel--static" data-ready-class="partners-carousel--ready" data-multiple-class="partners-carousel--multiple" data-dot-label="<?php esc_attr_e( 'Partners logo slides', 'rivross-corporate' ); ?>" aria-label="<?php esc_attr_e( 'Our Partners', 'rivross-corporate' ); ?>">
				<button class="partners-carousel__control partners-carousel__control--prev" type="button" aria-label="<?php esc_attr_e( 'Previous partner logos', 'rivross-corporate' ); ?>" hidden><?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
				<div class="partners-carousel__viewport">
					<div class="partner-grid partners-carousel__track" role="list">
						<?php if ( $has_partner_logos ) : ?>
							<?php foreach ( $partner_logos as $partner_logo ) : ?>
								<div class="partner-card partners-carousel__slide" role="listitem"><img src="<?php echo esc_url( $partner_logo['url'] ); ?>" alt="<?php echo esc_attr( $partner_logo['alt'] ); ?>" loading="lazy"></div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
				<button class="partners-carousel__control partners-carousel__control--next" type="button" aria-label="<?php esc_attr_e( 'Next partner logos', 'rivross-corporate' ); ?>" hidden><?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
				<div class="carousel-dots" role="tablist" aria-label="<?php esc_attr_e( 'Partner logo slides', 'rivross-corporate' ); ?>" hidden></div>
			</div>
		</div>
	</div>
</section>

<section id="news" class="home-news home-section">
	<div class="rivross-container rivross-container--wide news-grid">
		<div class="showcase-panel news-panel">
			<div class="showcase-panel__heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_home_news_title', __( 'Latest News & Updates', 'rivross-corporate' ) ) ); ?></h2><a href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_home_news_view_all_url', home_url( '/news-media/' ) ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_home_news_view_all_label', __( 'View All News', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div>
			<?php
			$home_news_count    = min( 6, max( 1, absint( get_theme_mod( 'rivross_home_news_count', 3 ) ) ) );
			$home_news_category = sanitize_title( get_theme_mod( 'rivross_home_news_category', '' ) );
			$home_news_args     = array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => $home_news_count,
				'orderby'        => 'date',
				'order'          => 'DESC',
			);
			if ( '' !== $home_news_category ) {
				$home_news_args['category_name'] = $home_news_category;
			}
			$home_news_query = new WP_Query(
				$home_news_args
			);
			if ( $home_news_query->have_posts() ) :
				while ( $home_news_query->have_posts() ) :
					$home_news_query->the_post();
					$thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
					$thumbnail = $thumbnail ? $thumbnail : $image_uri . 'news-meeting.png';
					?>
					<article class="news-item"><a class="news-item__image" href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy"></a><div><small><?php echo esc_html( get_the_date( 'd M Y' ) ); ?></small><h3><?php the_title(); ?></h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( get_theme_mod( 'rivross_home_news_read_more_label', __( 'Read More', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div></article>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<p><?php esc_html_e( 'News and updates will appear here soon.', 'rivross-corporate' ); ?></p>
				<?php
			endif;
			?>
		</div>

		<div id="leadership" class="showcase-panel leadership-panel">
			<div class="showcase-panel__heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_home_leadership_title', __( 'Our Leadership', 'rivross-corporate' ) ) ); ?></h2><a href="<?php echo esc_url( rivross_theme_link( get_theme_mod( 'rivross_home_leadership_view_all_url', '#leadership' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_home_leadership_view_all_label', __( 'View All Members', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div>
			<?php
			$carousel_enabled = (bool) get_theme_mod( 'rivross_home_leadership_carousel_enabled', true );
			$carousel_autoplay = (bool) get_theme_mod( 'rivross_home_leadership_carousel_autoplay', true );
			$carousel_interval = max( 2000, absint( get_theme_mod( 'rivross_home_leadership_carousel_interval', 5000 ) ) );
			$carousel_arrows   = (bool) get_theme_mod( 'rivross_home_leadership_carousel_arrows', false );
			$carousel_dots     = (bool) get_theme_mod( 'rivross_home_leadership_carousel_dots', true );
			$carousel_desktop  = min( 4, max( 1, absint( get_theme_mod( 'rivross_home_leadership_carousel_desktop', 4 ) ) ) );
			$carousel_tablet   = min( 3, max( 1, absint( get_theme_mod( 'rivross_home_leadership_carousel_tablet', 2 ) ) ) );
			$carousel_mobile   = min( 2, max( 1, absint( get_theme_mod( 'rivross_home_leadership_carousel_mobile', 2 ) ) ) );
			$dynamic_leaders_enabled = function_exists( 'rivross_leadership_has_published_entries' ) && rivross_leadership_has_published_entries();
			$dynamic_leaders         = $dynamic_leaders_enabled && function_exists( 'rivross_get_leaders' ) ? rivross_get_leaders( 'home' ) : array();
				$leaders = array(
					array( 'Nasrullah Hossain Nahid', 'Chief Operating Officer (COO)', 'Managing Director (MD)', 'leadership-placeholder.png' ),
					array( 'Md. Fatin Ishtiyaq Fahim', 'Chief Financial Officer (CFO)', 'Managing Director', 'leadership-glasses.png' ),
					array( 'MD Obayed Ullah Sarker', 'Director', 'Design & Operations', 'leadership-beard.png' ),
					array( 'MD Ataullah', 'Director', 'Real Estate', 'leadership-director.png' ),
				);
				$leaders_to_render = $dynamic_leaders_enabled ? $dynamic_leaders : $leaders;
				$leader_count      = count( $leaders_to_render );
			?>
			<div class="leadership-carousel<?php echo $carousel_enabled ? '' : ' leadership-carousel--disabled'; ?>" data-rivross-carousel data-enabled="<?php echo $carousel_enabled ? '1' : '0'; ?>" data-autoplay="<?php echo $carousel_autoplay ? '1' : '0'; ?>" data-interval="<?php echo esc_attr( $carousel_interval ); ?>" data-show-arrows="<?php echo $carousel_arrows ? '1' : '0'; ?>" data-show-dots="<?php echo $carousel_dots ? '1' : '0'; ?>" data-desktop="<?php echo esc_attr( $carousel_desktop ); ?>" data-tablet="<?php echo esc_attr( $carousel_tablet ); ?>" data-mobile="<?php echo esc_attr( $carousel_mobile ); ?>" aria-label="<?php esc_attr_e( 'Our Leadership', 'rivross-corporate' ); ?>">
				<button class="leadership-carousel__control leadership-carousel__control--prev" type="button" aria-label="<?php esc_attr_e( 'Previous leadership profiles', 'rivross-corporate' ); ?>" hidden><?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
				<div class="leadership-carousel__viewport">
					<div class="leadership-grid leadership-carousel__track" role="list">
					<?php foreach ( $leaders_to_render as $index => $leader ) :
					$number      = $index + 1;
					if ( $dynamic_leaders_enabled ) {
						$dynamic_leader = $leader;
						$leader[0]      = $dynamic_leader['name'];
						$leader[1]      = $dynamic_leader['role'];
						$leader[2]      = $dynamic_leader['department'];
						$leader[3]      = $dynamic_leader['image'] ? $dynamic_leader['image'] : $image_uri . 'leadership-placeholder.png';
						$socials        = $dynamic_leader['socials'];
					} else {
						$leader[0]   = get_theme_mod( 'rivross_home_leader_' . $number . '_name', $leader[0] );
						$leader[1]   = get_theme_mod( 'rivross_home_leader_' . $number . '_role_1', $leader[1] );
						$leader[2]   = get_theme_mod( 'rivross_home_leader_' . $number . '_role_2', $leader[2] );
						$leader[3]   = get_theme_mod( 'rivross_home_leader_' . $number . '_image', $image_uri . $leader[3] );
						$socials     = array();
					}
					?><article class="leader-card leadership-carousel__slide" role="listitem" aria-roledescription="<?php esc_attr_e( 'slide', 'rivross-corporate' ); ?>" aria-label="<?php echo esc_attr( sprintf( __( '%1$d of %2$d', 'rivross-corporate' ), $number, $leader_count ) ); ?>"><img src="<?php echo esc_url( $leader[3] ); ?>" alt="<?php echo esc_attr( $leader[0] ); ?>" loading="lazy"><h3><?php echo esc_html( $leader[0] ); ?></h3><p><?php echo esc_html( $leader[1] ); ?><?php if ( '' !== trim( (string) $leader[2] ) ) : ?><br><?php echo esc_html( $leader[2] ); ?><?php endif; ?></p><?php echo rivross_leadership_social_links( $socials, $leader[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></article><?php
					endforeach;
					?>
					</div>
				</div>
				<button class="leadership-carousel__control leadership-carousel__control--next" type="button" aria-label="<?php esc_attr_e( 'Next leadership profiles', 'rivross-corporate' ); ?>" hidden><?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
				<div class="carousel-dots" role="tablist" aria-label="<?php esc_attr_e( 'Leadership slides', 'rivross-corporate' ); ?>" hidden></div>
			</div>
			<?php if ( 0 === $leader_count ) : ?><p class="leadership-carousel__empty"><?php esc_html_e( 'Leadership profiles will appear here once they are published.', 'rivross-corporate' ); ?></p><?php endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
