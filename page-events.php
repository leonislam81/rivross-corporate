<?php
/**
 * Events archive page template.
 *
 * @package Rivross_Corporate
 */

get_header();

$asset_uri       = get_theme_file_uri( '/assets/images/events/' );
$page_url        = get_permalink();
$search_term     = isset( $_GET['event_s'] ) ? sanitize_text_field( wp_unslash( $_GET['event_s'] ) ) : '';
$category_slug   = isset( $_GET['event_cat'] ) ? sanitize_title( wp_unslash( $_GET['event_cat'] ) ) : '';
$current_page    = isset( $_GET['event_page'] ) ? max( 1, absint( $_GET['event_page'] ) ) : 1;
$category_terms  = get_terms( array( 'taxonomy' => 'rivross_event_category', 'hide_empty' => true, 'orderby' => 'term_id', 'order' => 'ASC' ) );
$category_terms  = is_wp_error( $category_terms ) ? array() : $category_terms;
$hero_image      = get_theme_mod( 'rivross_events_hero_image', $asset_uri . 'events-hero.png' );
$breadcrumb_home = get_theme_mod( 'rivross_events_breadcrumb_home', __( 'Home', 'rivross-corporate' ) );
$breadcrumb_parent = get_theme_mod( 'rivross_events_breadcrumb_parent', __( 'News & Media', 'rivross-corporate' ) );
$breadcrumb_page = get_theme_mod( 'rivross_events_breadcrumb_page', __( 'Events', 'rivross-corporate' ) );
$hero_line_1     = get_theme_mod( 'rivross_events_hero_line_1', __( 'Events That Inspire,', 'rivross-corporate' ) );
$hero_line_2     = get_theme_mod( 'rivross_events_hero_line_2', __( 'Connections That Last', 'rivross-corporate' ) );
$hero_description = str_replace( '\\n', "\n", (string) get_theme_mod( 'rivross_events_hero_description', __( 'Join us at our upcoming events, summits and exhibitions where ideas meet opportunities and partnerships are built.', 'rivross-corporate' ) ) );

$today = current_time( 'Y-m-d' );
$event_args = array(
	'post_type'      => 'rivross_event',
	'post_status'    => 'publish',
	'posts_per_page' => 6,
	'paged'          => $current_page,
	'orderby'        => 'meta_value',
	'order'          => 'ASC',
	'meta_key'       => '_rivross_event_start_date',
	'meta_query'     => array(
		'relation' => 'OR',
		array( 'key' => '_rivross_event_status', 'value' => 'upcoming' ),
		array(
			'relation' => 'AND',
			array( 'key' => '_rivross_event_status', 'value' => array( '', 'automatic' ), 'compare' => 'IN' ),
			array( 'key' => '_rivross_event_start_date', 'value' => $today, 'compare' => '>=', 'type' => 'DATE' ),
		),
		array(
			'relation' => 'AND',
			array( 'key' => '_rivross_event_status', 'compare' => 'NOT EXISTS' ),
			array( 'key' => '_rivross_event_start_date', 'value' => $today, 'compare' => '>=', 'type' => 'DATE' ),
		),
	),
);
if ( $search_term ) {
	$event_args['s'] = $search_term;
}
if ( $category_slug ) {
	$event_args['tax_query'] = array( array( 'taxonomy' => 'rivross_event_category', 'field' => 'slug', 'terms' => $category_slug ) );
}
$events_query = new WP_Query( $event_args );

$calendar_args               = $event_args;
$calendar_args['posts_per_page'] = -1;
$calendar_args['paged']      = 1;
$calendar_query              = new WP_Query( $calendar_args );
$calendar_events             = array();
if ( $calendar_query->have_posts() ) {
	while ( $calendar_query->have_posts() ) {
		$calendar_query->the_post();
		$start_date = get_post_meta( get_the_ID(), '_rivross_event_start_date', true );
		if ( $start_date ) {
			$calendar_events[ $start_date ][] = get_the_ID();
		}
	}
	wp_reset_postdata();
}

$calendar_month = isset( $_GET['event_month'] ) && preg_match( '/^\d{4}-\d{2}$/', $_GET['event_month'] ) ? sanitize_text_field( wp_unslash( $_GET['event_month'] ) ) : '';
if ( ! $calendar_month ) {
	$calendar_month = ! empty( $calendar_events ) ? substr( array_key_first( $calendar_events ), 0, 7 ) : current_time( 'Y-m' );
}
$calendar_date = DateTime::createFromFormat( '!Y-m-d', $calendar_month . '-01' );
if ( ! $calendar_date ) {
	$calendar_date = new DateTime( 'first day of this month' );
}
$calendar_label = $calendar_date->format( 'F Y' );
$calendar_start = (int) $calendar_date->format( 'w' );
$calendar_days  = (int) $calendar_date->format( 't' );
$previous_month = (clone $calendar_date)->modify( '-1 month' )->format( 'Y-m' );
$next_month     = (clone $calendar_date)->modify( '+1 month' )->format( 'Y-m' );
$calendar_query_args = array();
if ( $category_slug ) {
	$calendar_query_args['event_cat'] = $category_slug;
}
if ( $search_term ) {
	$calendar_query_args['event_s'] = $search_term;
}
$month_url = static function ( $month ) use ( $page_url, $calendar_query_args ) {
	return add_query_arg( array_merge( $calendar_query_args, array( 'event_month' => $month ) ), $page_url );
};

$category_icons = array(
	'conferences' => 'users',
	'exhibitions' => 'building',
	'webinars'    => 'grid',
	'networking'  => 'handshake',
	'seminars'    => 'briefcase',
);
$filter_url = static function ( $term_slug = '' ) use ( $page_url, $search_term ) {
	$args = array();
	if ( $term_slug ) {
		$args['event_cat'] = $term_slug;
	}
	if ( $search_term ) {
		$args['event_s'] = $search_term;
	}
	return add_query_arg( $args, $page_url );
};

$highlights = array(
	array( 'users', __( 'Industry Experts', 'rivross-corporate' ), __( 'Learn from leading professionals and thought leaders.', 'rivross-corporate' ) ),
	array( 'handshake', __( 'Networking Opportunities', 'rivross-corporate' ), __( 'Connect with potential partners, investors and collaborators.', 'rivross-corporate' ) ),
	array( 'chart', __( 'Exclusive Insights', 'rivross-corporate' ), __( 'Gain access to market trends, research and future opportunities.', 'rivross-corporate' ) ),
	array( 'lightbulb', __( 'Innovative Solutions', 'rivross-corporate' ), __( 'Discover the latest technologies and sustainable practices.', 'rivross-corporate' ) ),
);
$why_items = array(
	array( 'users', __( 'Expand Your Network', 'rivross-corporate' ), __( 'Meet industry leaders, investors and decision-makers.', 'rivross-corporate' ) ),
	array( 'chart', __( 'Stay Informed', 'rivross-corporate' ), __( 'Stay ahead with the latest trends and market insights.', 'rivross-corporate' ) ),
	array( 'lightbulb', __( 'Get Inspired', 'rivross-corporate' ), __( 'Gain new perspectives and ideas from experts.', 'rivross-corporate' ) ),
	array( 'handshake', __( 'Build Partnerships', 'rivross-corporate' ), __( 'Create meaningful relationships that drive success.', 'rivross-corporate' ) ),
	array( 'target', __( 'Drive Growth', 'rivross-corporate' ), __( 'Unlock opportunities that accelerate your business.', 'rivross-corporate' ) ),
);
?>

<section class="events-hero" style="--events-hero-image: url('<?php echo esc_url( $hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide events-hero__inner">
		<nav class="events-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $breadcrumb_home ); ?></a><span aria-hidden="true">›</span>
			<a href="<?php echo esc_url( home_url( '/news-media/' ) ); ?>"><?php echo esc_html( $breadcrumb_parent ); ?></a><span aria-hidden="true">›</span><span><?php echo esc_html( $breadcrumb_page ); ?></span>
		</nav>
		<div class="events-hero__copy">
			<h1><span><?php echo esc_html( $hero_line_1 ); ?></span><strong><?php echo esc_html( $hero_line_2 ); ?></strong></h1>
			<span class="events-hero__rule"></span>
			<p><?php echo esc_html( $hero_description ); ?></p>
		</div>
	</div>
</section>

<div class="events-page">
	<section class="events-filters" aria-label="<?php esc_attr_e( 'Event filters', 'rivross-corporate' ); ?>">
		<div class="rivross-container rivross-container--wide events-filters__inner">
			<nav class="events-categories" aria-label="<?php esc_attr_e( 'Event categories', 'rivross-corporate' ); ?>">
				<a class="events-category<?php echo '' === $category_slug ? ' is-active' : ''; ?>" href="<?php echo esc_url( $filter_url() ); ?>"><span class="events-category__icon"><?php echo rivross_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><span><?php esc_html_e( 'All Events', 'rivross-corporate' ); ?></span></a>
				<?php foreach ( $category_terms as $term ) : $term_icon = get_term_meta( $term->term_id, '_rivross_event_category_icon', true ); $term_icon = $term_icon ? $term_icon : ( isset( $category_icons[ $term->slug ] ) ? $category_icons[ $term->slug ] : 'calendar' ); ?>
					<a class="events-category<?php echo $category_slug === $term->slug ? ' is-active' : ''; ?>" href="<?php echo esc_url( $filter_url( $term->slug ) ); ?>"><span class="events-category__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $term_icon ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><span><?php echo esc_html( $term->name ); ?></span></a>
				<?php endforeach; ?>
			</nav>
			<form class="events-search" role="search" method="get" action="<?php echo esc_url( $page_url ); ?>">
				<?php if ( $category_slug ) : ?><input type="hidden" name="event_cat" value="<?php echo esc_attr( $category_slug ); ?>"><?php endif; ?>
				<label class="screen-reader-text" for="events-search-input"><?php esc_html_e( 'Search events', 'rivross-corporate' ); ?></label>
				<input id="events-search-input" type="search" name="event_s" value="<?php echo esc_attr( $search_term ); ?>" placeholder="<?php echo esc_attr( get_theme_mod( 'rivross_events_search_placeholder', __( 'Search events...', 'rivross-corporate' ) ) ); ?>">
				<button type="submit" aria-label="<?php esc_attr_e( 'Search events', 'rivross-corporate' ); ?>"><?php echo rivross_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
			</form>
		</div>
	</section>

	<section class="events-content">
		<div class="rivross-container rivross-container--wide events-content__grid">
			<div class="events-upcoming">
				<div class="events-section-heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_events_upcoming_title', __( 'Upcoming Events', 'rivross-corporate' ) ) ); ?></h2><span class="events-heading-rule"></span></div>
				<?php if ( $events_query->have_posts() ) : ?>
					<div class="events-list">
						<?php while ( $events_query->have_posts() ) : $events_query->the_post(); ?>
							<?php $event_id = get_the_ID(); $badge = rivross_event_date_badge( $event_id ); $register_url = get_post_meta( $event_id, '_rivross_event_register_url', true ); $details_url = get_post_meta( $event_id, '_rivross_event_details_url', true ); $details_url = $details_url ? $details_url : get_permalink(); $location = get_post_meta( $event_id, '_rivross_event_location', true ); $mode = get_post_meta( $event_id, '_rivross_event_mode', true ); $time = get_post_meta( $event_id, '_rivross_event_time', true ); ?>
							<article <?php post_class( 'event-card' ); ?>>
								<a class="event-card__media" href="<?php echo esc_url( $details_url ); ?>">
									<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); else : ?><span class="event-card__placeholder" aria-hidden="true"><?php echo rivross_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><?php endif; ?>
								</a>
								<div class="event-card__date"><span><?php echo esc_html( $badge['month'] ); ?></span><strong><?php echo esc_html( $badge['day'] ); ?></strong><small><?php echo esc_html( $badge['year'] ); ?></small></div>
								<div class="event-card__body">
									<h3><a href="<?php echo esc_url( $details_url ); ?>"><?php the_title(); ?></a></h3>
									<div class="event-card__meta"><span><?php echo rivross_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( rivross_event_date_label( $event_id ) ); ?></span><span><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $location ); ?></span></div>
									<?php if ( $time || $mode ) : ?><div class="event-card__time"><?php echo rivross_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $time ); ?><?php if ( $mode ) : ?><b><?php echo esc_html( $mode ); ?></b><?php endif; ?></div><?php endif; ?>
									<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 27, '…' ) ); ?></p>
									<div class="event-card__actions"><a class="rivross-button rivross-button--outline-dark" href="<?php echo esc_url( $details_url ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_events_details_label', __( 'View Details', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><?php if ( $register_url && '#' !== $register_url ) : ?><a class="rivross-button rivross-button--outline-gold" href="<?php echo esc_url( $register_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( get_theme_mod( 'rivross_events_register_label', __( 'Register Now', 'rivross-corporate' ) ) ); ?></a><?php else : ?><a class="rivross-button rivross-button--outline-gold" href="<?php echo esc_url( home_url( '/contact-us/#contact-form' ) ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_events_register_label', __( 'Register Now', 'rivross-corporate' ) ) ); ?></a><?php endif; ?></div>
								</div>
							</article>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				<?php else : ?><div class="events-empty"><h3><?php esc_html_e( 'No upcoming events found', 'rivross-corporate' ); ?></h3><p><?php esc_html_e( 'Try another search or category.', 'rivross-corporate' ); ?></p></div><?php endif; ?>
				<?php if ( $events_query->max_num_pages > 1 ) : ?><nav class="events-pagination" aria-label="<?php esc_attr_e( 'Events pagination', 'rivross-corporate' ); ?>"><?php echo paginate_links( array( 'base' => add_query_arg( 'event_page', '%#%', $page_url ), 'format' => '', 'current' => $current_page, 'total' => $events_query->max_num_pages, 'type' => 'plain', 'add_args' => $calendar_query_args ) ); ?></nav><?php endif; ?>
			</div>

			<aside class="events-sidebar">
				<section class="event-calendar" aria-label="<?php echo esc_attr( get_theme_mod( 'rivross_events_calendar_title', __( 'Event Calendar', 'rivross-corporate' ) ) ); ?>">
					<div class="events-section-heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_events_calendar_title', __( 'Event Calendar', 'rivross-corporate' ) ) ); ?></h2></div>
					<div class="event-calendar__nav"><a href="<?php echo esc_url( $month_url( $previous_month ) ); ?>" aria-label="<?php esc_attr_e( 'Previous month', 'rivross-corporate' ); ?>">‹</a><strong><?php echo esc_html( $calendar_label ); ?></strong><a href="<?php echo esc_url( $month_url( $next_month ) ); ?>" aria-label="<?php esc_attr_e( 'Next month', 'rivross-corporate' ); ?>">›</a></div>
			<div class="event-calendar__weekdays"><?php foreach ( array( __( 'Sun', 'rivross-corporate' ), __( 'Mon', 'rivross-corporate' ), __( 'Tue', 'rivross-corporate' ), __( 'Wed', 'rivross-corporate' ), __( 'Thu', 'rivross-corporate' ), __( 'Fri', 'rivross-corporate' ), __( 'Sat', 'rivross-corporate' ) ) as $weekday ) : ?><span><?php echo esc_html( $weekday ); ?></span><?php endforeach; ?></div>
					<div class="event-calendar__days">
						<?php for ( $blank = 0; $blank < $calendar_start; $blank++ ) : ?><span class="is-empty" aria-hidden="true"></span><?php endfor; ?>
						<?php for ( $day = 1; $day <= $calendar_days; $day++ ) : $day_key = $calendar_date->format( 'Y-m-' ) . str_pad( (string) $day, 2, '0', STR_PAD_LEFT ); $has_event = isset( $calendar_events[ $day_key ] ); ?>
							<span class="<?php echo $has_event ? 'has-event' : ''; ?><?php echo $day_key === current_time( 'Y-m-d' ) ? ' is-today' : ''; ?>"><?php echo esc_html( $day ); ?><?php if ( $has_event ) : ?><i aria-hidden="true"></i><?php endif; ?></span>
						<?php endfor; ?>
					</div>
				</section>

				<section class="event-highlights">
					<div class="events-section-heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_events_highlights_title', __( 'Event Highlights', 'rivross-corporate' ) ) ); ?></h2></div>
					<div class="event-highlights__list"><?php foreach ( $highlights as $index => $highlight ) : $number = $index + 1; $icon = get_theme_mod( 'rivross_events_highlight_' . $number . '_icon', $highlight[0] ); $title = get_theme_mod( 'rivross_events_highlight_' . $number . '_title', $highlight[1] ); $description = get_theme_mod( 'rivross_events_highlight_' . $number . '_description', $highlight[2] ); ?><div class="event-highlight"><span class="event-highlight__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $icon ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><div><h3><?php echo esc_html( $title ); ?></h3><p><?php echo esc_html( $description ); ?></p></div></div><?php endforeach; ?></div>
				</section>
			</aside>
		</div>
	</section>

	<section class="events-why">
		<div class="rivross-container rivross-container--wide"><div class="events-centered-heading"><span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_events_why_eyebrow', __( 'Why Attend Our Events?', 'rivross-corporate' ) ) ); ?></span><h2><?php echo esc_html( get_theme_mod( 'rivross_events_why_title', __( 'Connect. Learn. Grow.', 'rivross-corporate' ) ) ); ?></h2></div><div class="events-why__grid"><?php foreach ( $why_items as $index => $item ) : $number = $index + 1; $icon = get_theme_mod( 'rivross_events_why_' . $number . '_icon', $item[0] ); $title = get_theme_mod( 'rivross_events_why_' . $number . '_title', $item[1] ); $description = get_theme_mod( 'rivross_events_why_' . $number . '_description', $item[2] ); ?><div class="events-why__item"><span class="events-why__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $icon ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><h3><?php echo esc_html( $title ); ?></h3><p><?php echo esc_html( $description ); ?></p></div><?php endforeach; ?></div></div>
	</section>

	<section class="events-newsletter">
		<div class="rivross-container rivross-container--wide events-newsletter__inner"><span class="events-newsletter__icon"><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><div><h2><?php echo esc_html( get_theme_mod( 'rivross_events_newsletter_title', __( 'Never Miss an Event', 'rivross-corporate' ) ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'rivross_events_newsletter_description', __( 'Subscribe to our event updates and be the first to know about upcoming opportunities.', 'rivross-corporate' ) ) ); ?></p></div><?php echo rivross_newsletter_notice(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><form class="events-newsletter__form" method="post" action="<?php echo esc_url( $page_url ); ?>"><?php echo rivross_newsletter_form_fields( 'events' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><label class="screen-reader-text" for="events-newsletter-email"><?php esc_html_e( 'Email address', 'rivross-corporate' ); ?></label><input id="events-newsletter-email" type="email" name="newsletter_email" placeholder="<?php echo esc_attr( get_theme_mod( 'rivross_events_newsletter_placeholder', __( 'Enter your email address', 'rivross-corporate' ) ) ); ?>" required><button class="rivross-button" type="submit"><?php echo esc_html( get_theme_mod( 'rivross_events_newsletter_button', __( 'Subscribe', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button><small><?php esc_html_e( 'We respect your privacy. Unsubscribe at any time.', 'rivross-corporate' ); ?></small></form></div>
	</section>
</div>

<?php get_footer(); ?>
