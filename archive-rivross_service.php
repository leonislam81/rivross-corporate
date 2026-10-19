<?php
/**
 * RIVROSS Services catalogue.
 *
 * @package Rivross_Corporate
 */

get_header();

$archive_url          = get_post_type_archive_link( 'rivross_service' );
$generated_hero_image = get_theme_file_uri( '/assets/images/services-redesign/services-hero.webp' );
$hero_image           = get_theme_mod( 'rivross_services_hero_image', $generated_hero_image );
if ( empty( $hero_image ) || false !== strpos( $hero_image, 'projects-hero' ) ) {
	$hero_image = $generated_hero_image;
}

$category_slug = isset( $_GET['service_category'] ) ? sanitize_title( wp_unslash( $_GET['service_category'] ) ) : '';
$categories    = get_terms(
	array(
		'taxonomy'   => 'rivross_service_category',
		'hide_empty' => true,
	)
);
$categories    = is_wp_error( $categories ) ? array() : $categories;
$service_args  = array(
	'post_type'      => 'rivross_service',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => 'meta_value_num title',
	'meta_key'       => '_rivross_service_order',
	'order'          => 'ASC',
);

if ( $category_slug ) {
	$service_args['tax_query'] = array(
		array(
			'taxonomy' => 'rivross_service_category',
			'field'    => 'slug',
			'terms'    => $category_slug,
		),
	);
}

$services = get_posts( $service_args );
if ( empty( $services ) && $category_slug ) {
	$services = get_posts(
		array(
			'post_type'      => 'rivross_service',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);
}

$service_count = count( $services );
$category_visuals = array(
	'building-finishes' => array(
		'image' => get_theme_file_uri( '/assets/images/services-redesign/services-finishes.webp' ),
		'icon'  => 'building',
	),
	'design-fit-out'    => array(
		'image' => get_theme_file_uri( '/assets/images/services-redesign/services-interiors.webp' ),
		'icon'  => 'ruler',
	),
	'building-systems'  => array(
		'image' => get_theme_file_uri( '/assets/images/services-redesign/services-systems.webp' ),
		'icon'  => 'gear',
	),
	'care-maintenance'  => array(
		'image' => get_theme_file_uri( '/assets/images/services-redesign/services-property-care.webp' ),
		'icon'  => 'sprout',
	),
);

$featured_service = ! empty( $services ) ? $services[0] : null;
$featured_terms   = $featured_service ? get_the_terms( $featured_service->ID, 'rivross_service_category' ) : array();
$featured_term    = ! empty( $featured_terms ) && ! is_wp_error( $featured_terms ) ? $featured_terms[0] : null;
$featured_key     = $featured_term ? $featured_term->slug : 'building-finishes';
$featured_visual  = isset( $category_visuals[ $featured_key ] ) ? $category_visuals[ $featured_key ] : $category_visuals['building-finishes'];
$featured_intro   = $featured_service ? rivross_service_meta( $featured_service->ID, 'intro', get_the_excerpt( $featured_service->ID ) ) : __( 'From specification to installation, our team helps every space come together with confidence.', 'rivross-corporate' );
$featured_tagline  = $featured_service ? rivross_service_meta( $featured_service->ID, 'tagline' ) : __( 'Specification, supply and support', 'rivross-corporate' );
$featured_highlights = $featured_service ? rivross_service_meta( $featured_service->ID, 'highlights' ) : '';
$featured_highlights = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $featured_highlights ) ) );
if ( empty( $featured_highlights ) ) {
	$featured_highlights = array(
		__( 'Curated product selection', 'rivross-corporate' ),
		__( 'Practical technical guidance', 'rivross-corporate' ),
		__( 'Reliable project coordination', 'rivross-corporate' ),
	);
}
?>
<section class="services-hero services-hero--catalogue" style="--services-hero-image:url('<?php echo esc_url( $hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide services-hero__inner">
		<nav class="services-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rivross-corporate' ); ?></a>
			<span aria-hidden="true">›</span>
			<span><?php esc_html_e( 'Services', 'rivross-corporate' ); ?></span>
		</nav>
		<div class="services-hero__layout">
			<div class="services-hero__copy">
				<span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_services_hero_eyebrow', __( 'RIVROSS Services', 'rivross-corporate' ) ) ); ?></span>
				<h1>
					<span><?php echo esc_html( get_theme_mod( 'rivross_services_hero_line_1', __( 'Built for the way you', 'rivross-corporate' ) ) ); ?></span>
					<strong><?php echo esc_html( get_theme_mod( 'rivross_services_hero_line_2', __( 'build.', 'rivross-corporate' ) ) ); ?></strong>
				</h1>
				<p><?php echo esc_html( get_theme_mod( 'rivross_services_hero_description', __( 'One trusted partner for the products, expertise and coordination that bring every space together.', 'rivross-corporate' ) ) ); ?></p>
				<div class="services-hero__actions">
					<a class="rivross-button" href="#services-catalogue"><?php esc_html_e( 'Explore services', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="services-hero__outline" href="<?php echo esc_url( home_url( '/contact-us/#contact-form' ) ); ?>"><?php esc_html_e( 'Talk to our team', 'rivross-corporate' ); ?></a>
				</div>
			</div>
			<div class="services-hero__proof" aria-label="<?php esc_attr_e( 'Service highlights', 'rivross-corporate' ); ?>">
				<div class="services-hero__proof-mark"><?php echo rivross_icon( 'handshake' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<span class="services-hero__proof-label"><?php esc_html_e( 'One coordinated team', 'rivross-corporate' ); ?></span>
				<strong><?php echo esc_html( $service_count ); ?> <span><?php esc_html_e( 'specialist services', 'rivross-corporate' ); ?></span></strong>
				<ul class="services-hero__proof-list">
					<li><?php echo rivross_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e( 'Trusted product sourcing', 'rivross-corporate' ); ?></li>
					<li><?php echo rivross_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e( 'Technical guidance', 'rivross-corporate' ); ?></li>
					<li><?php echo rivross_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e( 'Reliable delivery support', 'rivross-corporate' ); ?></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<main class="services-page services-page--catalogue">
	<section class="services-intro-v2">
		<div class="rivross-container rivross-container--wide">
			<div class="services-section-heading">
				<span class="rivross-eyebrow"><?php esc_html_e( 'What we do', 'rivross-corporate' ); ?></span>
				<h2><?php esc_html_e( 'One trusted partner. Every finishing touch.', 'rivross-corporate' ); ?></h2>
			</div>
			<p><?php esc_html_e( 'From doors, tiles and ceramics to interiors, plumbing and property care, RIVROSS brings the right people and products together for spaces built to last.', 'rivross-corporate' ); ?></p>
		</div>
	</section>

	<section class="services-catalogue-v2" id="services-catalogue">
		<div class="rivross-container rivross-container--wide">
			<div class="services-stats" aria-label="<?php esc_attr_e( 'Service catalogue summary', 'rivross-corporate' ); ?>">
				<div><strong><?php echo esc_html( $service_count ); ?></strong><span><?php esc_html_e( 'Specialist services', 'rivross-corporate' ); ?></span></div>
				<div><strong><?php echo esc_html( count( $categories ) ); ?></strong><span><?php esc_html_e( 'Service categories', 'rivross-corporate' ); ?></span></div>
				<div><strong>01</strong><span><?php esc_html_e( 'Coordinated partner', 'rivross-corporate' ); ?></span></div>
			</div>

			<?php if ( ! empty( $categories ) ) : ?>
				<nav class="services-category-nav" aria-label="<?php esc_attr_e( 'Service categories', 'rivross-corporate' ); ?>">
					<a class="<?php echo empty( $category_slug ) ? 'is-active' : ''; ?>" href="<?php echo esc_url( $archive_url ); ?>" <?php echo empty( $category_slug ) ? 'aria-current="page"' : ''; ?>><?php echo rivross_icon( 'grid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php esc_html_e( 'All services', 'rivross-corporate' ); ?></span></a>
					<?php foreach ( $categories as $category ) : ?>
						<?php $category_visual = isset( $category_visuals[ $category->slug ] ) ? $category_visuals[ $category->slug ] : array( 'icon' => 'folder' ); ?>
						<a class="<?php echo $category_slug === $category->slug ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'service_category', $category->slug, $archive_url ) ); ?>" <?php echo $category_slug === $category->slug ? 'aria-current="page"' : ''; ?>><?php echo rivross_icon( $category_visual['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $category->name ); ?></span><small><?php echo esc_html( $category->count ); ?></small></a>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>

			<?php if ( $featured_service ) : ?>
				<article class="services-feature">
					<div class="services-feature__media">
						<img src="<?php echo esc_url( $featured_visual['image'] ); ?>" alt="<?php echo esc_attr( $featured_term ? $featured_term->name : __( 'RIVROSS service solutions', 'rivross-corporate' ) ); ?>" loading="lazy">
						<span><?php esc_html_e( 'Featured capability', 'rivross-corporate' ); ?></span>
					</div>
					<div class="services-feature__body">
						<span class="rivross-eyebrow"><?php echo esc_html( $featured_term ? $featured_term->name : __( 'RIVROSS Services', 'rivross-corporate' ) ); ?></span>
						<h2><?php echo esc_html( get_the_title( $featured_service->ID ) ); ?></h2>
						<?php if ( $featured_tagline ) : ?><p class="services-feature__tagline"><?php echo esc_html( $featured_tagline ); ?></p><?php endif; ?>
						<p><?php echo esc_html( wp_trim_words( $featured_intro, 34, '…' ) ); ?></p>
						<a class="service-card__link" href="<?php echo esc_url( get_permalink( $featured_service->ID ) ); ?>"><?php esc_html_e( 'Discover this service', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					</div>
					<ul class="services-feature__list">
						<?php foreach ( array_slice( $featured_highlights, 0, 4 ) as $highlight ) : ?><li><?php echo rivross_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $highlight ); ?></span></li><?php endforeach; ?>
					</ul>
				</article>
			<?php endif; ?>

			<div class="services-catalogue-heading">
				<div><span class="rivross-eyebrow"><?php esc_html_e( 'Explore the catalogue', 'rivross-corporate' ); ?></span><h2><?php esc_html_e( 'Services that keep projects moving.', 'rivross-corporate' ); ?></h2></div>
				<p><?php esc_html_e( 'Choose a service to see how our team can support your next space.', 'rivross-corporate' ); ?></p>
			</div>

			<?php if ( ! empty( $services ) ) : ?>
				<div class="service-card-grid-v2">
					<?php foreach ( $services as $index => $service ) : ?>
						<?php
						$service_id    = $service->ID;
						$terms         = get_the_terms( $service_id, 'rivross_service_category' );
						$category_label = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0]->name : __( 'RIVROSS Service', 'rivross-corporate' );
						$intro         = rivross_service_meta( $service_id, 'intro', get_the_excerpt( $service_id ) );
						$tagline       = rivross_service_meta( $service_id, 'tagline' );
						$order         = (int) rivross_service_meta( $service_id, 'order', $index + 1 );
						?>
						<article class="service-card-v2">
							<a class="service-card-v2__media" href="<?php echo esc_url( get_permalink( $service_id ) ); ?>">
								<img src="<?php echo esc_url( rivross_service_image_url( $service_id ) ); ?>" alt="<?php echo esc_attr( get_the_title( $service_id ) ); ?>" loading="lazy">
								<span class="service-card-v2__number"><?php echo esc_html( sprintf( '%02d', $order ) ); ?></span>
								<span class="service-card-v2__icon"><?php echo rivross_icon( rivross_service_icon( $service_id ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							</a>
							<div class="service-card-v2__body">
								<span class="service-card-v2__category"><?php echo esc_html( $category_label ); ?></span>
								<h3><a href="<?php echo esc_url( get_permalink( $service_id ) ); ?>"><?php echo esc_html( get_the_title( $service_id ) ); ?></a></h3>
								<?php if ( $tagline ) : ?><p class="service-card-v2__tagline"><?php echo esc_html( $tagline ); ?></p><?php endif; ?>
								<p><?php echo esc_html( wp_trim_words( $intro, 20, '…' ) ); ?></p>
								<a class="service-card-v2__link" href="<?php echo esc_url( get_permalink( $service_id ) ); ?>"><?php esc_html_e( 'View service', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="services-empty"><h2><?php esc_html_e( 'Services are being updated.', 'rivross-corporate' ); ?></h2><p><?php esc_html_e( 'Please contact our team and we will help you find the right solution.', 'rivross-corporate' ); ?></p></div>
			<?php endif; ?>
		</div>
	</section>

	<section class="services-cta services-cta--catalogue">
		<div class="rivross-container rivross-container--wide services-cta__inner">
			<div class="services-cta__icon"><?php echo rivross_icon( 'handshake' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			<div><span class="rivross-eyebrow"><?php esc_html_e( 'Let’s talk', 'rivross-corporate' ); ?></span><h2><?php echo esc_html( get_theme_mod( 'rivross_services_cta_title', __( 'Have a space in mind?', 'rivross-corporate' ) ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'rivross_services_cta_description', __( 'Share your requirement and our team will recommend the right service path.', 'rivross-corporate' ) ) ); ?></p></div>
			<a class="rivross-button" href="<?php echo esc_url( home_url( '/contact-us/#contact-form' ) ); ?>"><?php esc_html_e( 'Start a conversation', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
		</div>
	</section>
</main>
<?php get_footer(); ?>

