<?php
/**
 * Single event detail template.
 *
 * @package Rivross_Corporate
 */

get_header();

while ( have_posts() ) :
	the_post();
	$event_id       = get_the_ID();
	$asset_uri      = get_theme_file_uri( '/assets/images/events/' );
	$hero_image     = get_theme_mod( 'rivross_events_single_hero_image', $asset_uri . 'event-single-hero.png' );
	$badge          = rivross_event_date_badge( $event_id );
	$date_label     = rivross_event_date_label( $event_id );
	$location       = get_post_meta( $event_id, '_rivross_event_location', true );
	$time           = get_post_meta( $event_id, '_rivross_event_time', true );
	$mode           = get_post_meta( $event_id, '_rivross_event_mode', true );
	$language       = get_post_meta( $event_id, '_rivross_event_language', true );
	$dress_code     = get_post_meta( $event_id, '_rivross_event_dress_code', true );
	$register_url   = get_post_meta( $event_id, '_rivross_event_register_url', true );
	$contact_email  = get_post_meta( $event_id, '_rivross_event_contact_email', true );
	$contact_email  = $contact_email ? $contact_email : get_theme_mod( 'rivross_contact_email', 'rivrossgroup@gmail.com' );
	$language       = $language ? $language : __( 'English', 'rivross-corporate' );
	$dress_code     = $dress_code ? $dress_code : __( 'Business Attire', 'rivross-corporate' );
	$categories     = get_the_terms( $event_id, 'rivross_event_category' );
	$category_label = ( $categories && ! is_wp_error( $categories ) ) ? $categories[0]->name : __( 'RIVROSS Event', 'rivross-corporate' );
	$end_date       = get_post_meta( $event_id, '_rivross_event_end_date', true );
	$end_object     = $end_date ? DateTime::createFromFormat( 'Y-m-d', $end_date ) : false;
	$date_badge_day = $badge['day'];
	if ( $end_object && $end_object->format( 'Y-m-d' ) !== get_post_meta( $event_id, '_rivross_event_start_date', true ) ) {
		$date_badge_day .= '–' . $end_object->format( 'd' );
	}

	$agenda_defaults = array(
		array( 'microphone', __( 'Opening & Welcome', 'rivross-corporate' ), __( 'Opening remarks and keynote address', 'rivross-corporate' ), '10:00 AM – 11:00 AM' ),
		array( 'users', __( 'Leadership Panel', 'rivross-corporate' ), __( 'Panel discussion with industry leaders', 'rivross-corporate' ), '11:15 AM – 01:00 PM' ),
		array( 'handshake', __( 'Networking Dinner', 'rivross-corporate' ), __( 'Exclusive dinner and networking', 'rivross-corporate' ), '07:00 PM – 09:30 PM' ),
	);
	$agenda = array();
	foreach ( $agenda_defaults as $index => $default ) {
		$number = $index + 1;
		$agenda[] = array(
			'icon'        => get_post_meta( $event_id, '_rivross_event_agenda_' . $number . '_icon', true ) ?: $default[0],
			'title'       => get_post_meta( $event_id, '_rivross_event_agenda_' . $number . '_title', true ) ?: $default[1],
			'description' => get_post_meta( $event_id, '_rivross_event_agenda_' . $number . '_description', true ) ?: $default[2],
			'time'        => get_post_meta( $event_id, '_rivross_event_agenda_' . $number . '_time', true ) ?: $default[3],
		);
	}

	$expectations = array(
		array( 'users', __( 'Industry Experts', 'rivross-corporate' ), __( 'Learn from visionary leaders and proven experts.', 'rivross-corporate' ) ),
		array( 'chart', __( 'Market Insights', 'rivross-corporate' ), __( 'Gain exclusive insights into market trends and forecasts.', 'rivross-corporate' ) ),
		array( 'handshake', __( 'Networking', 'rivross-corporate' ), __( 'Connect with peers, investors and decision-makers.', 'rivross-corporate' ) ),
		array( 'lightbulb', __( 'New Opportunities', 'rivross-corporate' ), __( 'Discover collaborations and investment opportunities.', 'rivross-corporate' ) ),
	);
	$related_args = array(
		'post_type'      => 'rivross_event',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'post__not_in'   => array( $event_id ),
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_key'       => '_rivross_event_start_date',
		'meta_query'     => array(
			'relation' => 'OR',
			array( 'key' => '_rivross_event_status', 'value' => 'upcoming' ),
			array(
				'relation' => 'AND',
				array( 'key' => '_rivross_event_status', 'compare' => 'NOT EXISTS' ),
				array( 'key' => '_rivross_event_start_date', 'value' => current_time( 'Y-m-d' ), 'compare' => '>=', 'type' => 'DATE' ),
			),
		),
	);
	$related_query = new WP_Query( $related_args );
?>
	<section class="event-single-hero" style="--event-single-hero-image: url('<?php echo esc_url( $hero_image ); ?>');">
		<div class="rivross-container rivross-container--wide event-single-hero__inner">
			<nav class="events-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rivross-corporate' ); ?></a><span aria-hidden="true">›</span>
				<a href="<?php echo esc_url( home_url( '/events/' ) ); ?>"><?php esc_html_e( 'Events', 'rivross-corporate' ); ?></a><span aria-hidden="true">›</span><span><?php echo esc_html( $category_label ); ?></span>
			</nav>
			<div class="event-single-hero__copy">
				<span class="rivross-eyebrow"><?php echo esc_html( $category_label ); ?></span>
				<h1><?php the_title(); ?></h1>
				<span class="events-hero__rule"></span>
				<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34, '…' ) ); ?></p>
			</div>
		</div>
	</section>

	<section class="event-single-main">
		<div class="rivross-container rivross-container--wide event-single-main__grid">
			<article class="event-single-primary">
				<?php if ( has_post_thumbnail() ) : ?><figure class="event-single-featured"><?php the_post_thumbnail( 'full' ); ?></figure><?php endif; ?>
				<div class="event-single-overview"><span class="rivross-eyebrow"><?php echo esc_html( get_theme_mod( 'rivross_events_single_overview_eyebrow', __( 'Event Overview', 'rivross-corporate' ) ) ); ?></span><h2><?php echo esc_html( get_theme_mod( 'rivross_events_single_overview_title', __( 'Ideas that shape tomorrow.', 'rivross-corporate' ) ) ); ?></h2><div class="event-single-content__text"><?php the_content(); ?></div></div>
				<div class="event-single-agenda"><div class="event-single-heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_events_single_agenda_title', __( 'Summit Agenda Highlights', 'rivross-corporate' ) ) ); ?></h2><span></span></div><div class="event-single-agenda__list"><?php foreach ( $agenda as $item ) : ?><div class="event-single-agenda__item"><span class="event-single-agenda__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $item['icon'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><div><h3><?php echo esc_html( $item['title'] ); ?></h3><p><?php echo esc_html( $item['description'] ); ?></p></div><time><?php echo esc_html( $item['time'] ); ?></time><span class="event-single-agenda__arrow" aria-hidden="true">›</span></div><?php endforeach; ?></div></div>
			</article>

			<aside class="event-single-aside">
				<section class="event-single-register"><div class="event-single-register__date"><span><?php echo esc_html( $badge['month'] ); ?></span><strong><?php echo esc_html( $date_badge_day ); ?></strong><small><?php echo esc_html( $badge['year'] ); ?></small></div><a class="rivross-button" href="<?php echo esc_url( $register_url && '#' !== $register_url ? $register_url : home_url( '/contact-us/#contact-form' ) ); ?>"<?php echo $register_url && '#' !== $register_url ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( get_theme_mod( 'rivross_events_single_register_label', __( 'Register Now', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><hr><p><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( get_theme_mod( 'rivross_events_single_question_label', __( 'Have questions?', 'rivross-corporate' ) ) ); ?></a></p><a class="event-single-register__email" href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a></section>
				<section class="event-single-details"><div class="event-single-heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_events_single_details_title', __( 'Event Details', 'rivross-corporate' ) ) ); ?></h2><span></span></div><dl><div><dt><?php echo rivross_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></dt><dd><b><?php esc_html_e( 'Date', 'rivross-corporate' ); ?></b><span><?php echo esc_html( $date_label ); ?></span></dd></div><div><dt><?php echo rivross_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></dt><dd><b><?php esc_html_e( 'Time', 'rivross-corporate' ); ?></b><span><?php echo esc_html( $time ); ?></span></dd></div><div><dt><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></dt><dd><b><?php esc_html_e( 'Venue', 'rivross-corporate' ); ?></b><span><?php echo esc_html( $location ); ?></span></dd></div><div><dt><?php echo rivross_icon( 'users' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></dt><dd><b><?php esc_html_e( 'Format', 'rivross-corporate' ); ?></b><span><?php echo esc_html( $mode ); ?></span></dd></div><div><dt><?php echo rivross_icon( 'globe' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></dt><dd><b><?php esc_html_e( 'Language', 'rivross-corporate' ); ?></b><span><?php echo esc_html( $language ); ?></span></dd></div><div><dt><?php echo rivross_icon( 'suitcase' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></dt><dd><b><?php esc_html_e( 'Dress Code', 'rivross-corporate' ); ?></b><span><?php echo esc_html( $dress_code ); ?></span></dd></div></dl></section>
				<a class="event-single-back" href="<?php echo esc_url( home_url( '/events/' ) ); ?>">← <?php esc_html_e( 'Back to all events', 'rivross-corporate' ); ?></a>
			</aside>
		</div>
	</section>

	<section class="event-single-expectations"><div class="rivross-container rivross-container--wide"><div class="events-centered-heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_events_single_expectations_title', __( 'What to Expect', 'rivross-corporate' ) ) ); ?></h2></div><div class="event-single-expectations__grid"><?php foreach ( $expectations as $index => $item ) : $number = $index + 1; $icon = get_theme_mod( 'rivross_events_single_expect_' . $number . '_icon', $item[0] ); $title = get_theme_mod( 'rivross_events_single_expect_' . $number . '_title', $item[1] ); $description = get_theme_mod( 'rivross_events_single_expect_' . $number . '_description', $item[2] ); ?><div class="event-single-expectation"><span><?php echo rivross_icon( rivross_sanitize_icon_choice( $icon ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><h3><?php echo esc_html( $title ); ?></h3><p><?php echo esc_html( $description ); ?></p></div><?php endforeach; ?></div></div></section>

	<?php if ( $related_query->have_posts() ) : ?><section class="event-single-related"><div class="rivross-container rivross-container--wide"><div class="event-single-heading"><h2><?php echo esc_html( get_theme_mod( 'rivross_events_single_related_title', __( 'Related Events', 'rivross-corporate' ) ) ); ?></h2><span></span><a href="<?php echo esc_url( home_url( '/events/' ) ); ?>"><?php esc_html_e( 'View all events', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div><div class="event-single-related__grid"><?php while ( $related_query->have_posts() ) : $related_query->the_post(); $related_id = get_the_ID(); ?><article class="event-related-card"><a href="<?php the_permalink(); ?>" class="event-related-card__media"><?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); else : ?><span><?php echo rivross_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><?php endif; ?></a><div class="event-related-card__body"><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( rivross_event_date_label( $related_id ) ); ?><?php if ( get_post_meta( $related_id, '_rivross_event_location', true ) ) : ?> <span>•</span> <?php echo esc_html( get_post_meta( $related_id, '_rivross_event_location', true ) ); ?><?php endif; ?></p><a class="event-related-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View Details', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div></article><?php endwhile; wp_reset_postdata(); ?></div></div></section><?php endif; ?>

	<section class="events-newsletter"><div class="rivross-container rivross-container--wide events-newsletter__inner"><span class="events-newsletter__icon"><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><div><h2><?php echo esc_html( get_theme_mod( 'rivross_events_newsletter_title', __( 'Never Miss an Event', 'rivross-corporate' ) ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'rivross_events_newsletter_description', __( 'Subscribe to our event updates and be the first to know about upcoming opportunities.', 'rivross-corporate' ) ) ); ?></p></div><?php echo rivross_newsletter_notice(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><form class="events-newsletter__form" method="post" action="<?php echo esc_url( home_url( '/events/' ) ); ?>"><?php echo rivross_newsletter_form_fields( 'event' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><label class="screen-reader-text" for="event-single-newsletter-email"><?php esc_html_e( 'Email address', 'rivross-corporate' ); ?></label><input id="event-single-newsletter-email" type="email" name="newsletter_email" placeholder="<?php echo esc_attr( get_theme_mod( 'rivross_events_newsletter_placeholder', __( 'Enter your email address', 'rivross-corporate' ) ) ); ?>" required><button class="rivross-button" type="submit"><?php echo esc_html( get_theme_mod( 'rivross_events_newsletter_button', __( 'Subscribe', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button><small><?php esc_html_e( 'We respect your privacy. Unsubscribe at any time.', 'rivross-corporate' ); ?></small></form></div></section>
<?php endwhile; ?>

<?php get_footer(); ?>
