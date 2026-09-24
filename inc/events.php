<?php
/**
 * RIVROSS Events content type and event-specific fields.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Register the Events content type and its categories. */
function rivross_register_event_post_type() {
	$labels = array(
		'name'               => __( 'Events', 'rivross-corporate' ),
		'singular_name'      => __( 'Event', 'rivross-corporate' ),
		'menu_name'          => __( 'Events', 'rivross-corporate' ),
		'add_new'            => __( 'Add Event', 'rivross-corporate' ),
		'add_new_item'       => __( 'Add New Event', 'rivross-corporate' ),
		'edit_item'          => __( 'Edit Event', 'rivross-corporate' ),
		'new_item'           => __( 'New Event', 'rivross-corporate' ),
		'view_item'          => __( 'View Event', 'rivross-corporate' ),
		'search_items'       => __( 'Search Events', 'rivross-corporate' ),
		'not_found'          => __( 'No events found.', 'rivross-corporate' ),
		'not_found_in_trash' => __( 'No events found in Trash.', 'rivross-corporate' ),
	);

	register_post_type(
		'rivross_event',
		array(
			'labels'             => $labels,
			'public'             => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-calendar-alt',
			'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'has_archive'        => false,
			'rewrite'            => array( 'slug' => 'events', 'with_front' => false ),
			'publicly_queryable' => true,
			'show_in_nav_menus'  => false,
		)
	);

	register_taxonomy(
		'rivross_event_category',
		'rivross_event',
		array(
			'labels'            => array(
				'name'          => __( 'Event Categories', 'rivross-corporate' ),
				'singular_name' => __( 'Event Category', 'rivross-corporate' ),
				'menu_name'     => __( 'Categories', 'rivross-corporate' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'hierarchical'      => true,
			'rewrite'           => false,
			'show_admin_column' => true,
		)
	);
}
add_action( 'init', 'rivross_register_event_post_type' );

/** Let editors choose the icon shown beside each category filter. */
function rivross_event_category_icon_field( $term = null ) {
	/* The add-form hook passes the taxonomy slug as its first argument; only
	 * read term metadata when the edit-form hook gives us a WP_Term object. */
	$is_term = is_object( $term ) && isset( $term->term_id );
	$icon    = $is_term ? get_term_meta( $term->term_id, '_rivross_event_category_icon', true ) : '';
	$choices = function_exists( 'rivross_icon_choices' ) ? rivross_icon_choices() : array( 'calendar' => __( 'Calendar', 'rivross-corporate' ) );
	if ( $is_term ) :
		wp_nonce_field( 'rivross_save_event_category_icon', 'rivross_event_category_icon_nonce' );
		?>
		<tr class="form-field"><th scope="row"><label for="rivross_event_category_icon"><?php esc_html_e( 'Category Icon', 'rivross-corporate' ); ?></label></th><td><select name="rivross_event_category_icon" id="rivross_event_category_icon">
		<?php foreach ( $choices as $value => $label ) : ?><option value="<?php echo esc_attr( $value ); ?>" <?php selected( $icon, $value ); ?>><?php echo esc_html( $label ); ?></option><?php endforeach; ?>
		</select><p class="description"><?php esc_html_e( 'This icon appears in the Events page category filter.', 'rivross-corporate' ); ?></p></td></tr>
		<?php
	else :
		wp_nonce_field( 'rivross_save_event_category_icon', 'rivross_event_category_icon_nonce' );
		?>
		<div class="form-field"><label for="rivross_event_category_icon"><?php esc_html_e( 'Category Icon', 'rivross-corporate' ); ?></label><select name="rivross_event_category_icon" id="rivross_event_category_icon">
		<?php foreach ( $choices as $value => $label ) : ?><option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option><?php endforeach; ?>
		</select><p class="description"><?php esc_html_e( 'This icon appears in the Events page category filter.', 'rivross-corporate' ); ?></p></div>
		<?php
	endif;
}
add_action( 'rivross_event_category_add_form_fields', 'rivross_event_category_icon_field' );
add_action( 'rivross_event_category_edit_form_fields', 'rivross_event_category_icon_field' );

function rivross_save_event_category_icon( $term_id ) {
	if ( ! isset( $_POST['rivross_event_category_icon_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rivross_event_category_icon_nonce'] ) ), 'rivross_save_event_category_icon' ) ) {
		return;
	}
	$choices = function_exists( 'rivross_icon_choices' ) ? rivross_icon_choices() : array();
	$icon    = isset( $_POST['rivross_event_category_icon'] ) ? sanitize_key( wp_unslash( $_POST['rivross_event_category_icon'] ) ) : '';
	if ( $icon && isset( $choices[ $icon ] ) ) {
		update_term_meta( $term_id, '_rivross_event_category_icon', $icon );
	} else {
		delete_term_meta( $term_id, '_rivross_event_category_icon' );
	}
}
add_action( 'created_rivross_event_category', 'rivross_save_event_category_icon' );
add_action( 'edited_rivross_event_category', 'rivross_save_event_category_icon' );

/** Add the editable Event details panel. */
function rivross_add_event_meta_box() {
	add_meta_box(
		'rivross_event_details',
		__( 'Event Details', 'rivross-corporate' ),
		'rivross_render_event_meta_box',
		'rivross_event',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_rivross_event', 'rivross_add_event_meta_box' );

/** Render Event custom fields. */
function rivross_render_event_meta_box( $post ) {
	wp_nonce_field( 'rivross_save_event', 'rivross_event_nonce' );
	$fields = array(
		'start_date'  => get_post_meta( $post->ID, '_rivross_event_start_date', true ),
		'end_date'    => get_post_meta( $post->ID, '_rivross_event_end_date', true ),
		'time'        => get_post_meta( $post->ID, '_rivross_event_time', true ),
		'location'    => get_post_meta( $post->ID, '_rivross_event_location', true ),
		'mode'        => get_post_meta( $post->ID, '_rivross_event_mode', true ),
		'status'      => get_post_meta( $post->ID, '_rivross_event_status', true ),
		'language'    => get_post_meta( $post->ID, '_rivross_event_language', true ),
		'dress_code'  => get_post_meta( $post->ID, '_rivross_event_dress_code', true ),
		'contact_email' => get_post_meta( $post->ID, '_rivross_event_contact_email', true ),
		'register_url' => get_post_meta( $post->ID, '_rivross_event_register_url', true ),
		'details_url' => get_post_meta( $post->ID, '_rivross_event_details_url', true ),
	);
	?>
	<p class="description"><?php esc_html_e( 'Event cards, filters and the calendar are generated from these fields. Use the Featured Image panel for the event artwork.', 'rivross-corporate' ); ?></p>
	<table class="form-table" role="presentation">
		<tr><th><label for="rivross_event_start_date"><?php esc_html_e( 'Start Date', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="date" id="rivross_event_start_date" name="rivross_event_start_date" value="<?php echo esc_attr( $fields['start_date'] ); ?>"></td></tr>
		<tr><th><label for="rivross_event_end_date"><?php esc_html_e( 'End Date', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="date" id="rivross_event_end_date" name="rivross_event_end_date" value="<?php echo esc_attr( $fields['end_date'] ); ?>"></td></tr>
		<tr><th><label for="rivross_event_time"><?php esc_html_e( 'Time', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_event_time" name="rivross_event_time" value="<?php echo esc_attr( $fields['time'] ); ?>" placeholder="10:00 AM – 05:00 PM"></td></tr>
		<tr><th><label for="rivross_event_location"><?php esc_html_e( 'Location', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_event_location" name="rivross_event_location" value="<?php echo esc_attr( $fields['location'] ); ?>" placeholder="Dhaka, Bangladesh"></td></tr>
		<tr><th><label for="rivross_event_mode"><?php esc_html_e( 'Event Mode', 'rivross-corporate' ); ?></label></th><td><select id="rivross_event_mode" name="rivross_event_mode"><option value="Physical" <?php selected( 'Physical', $fields['mode'] ); ?>><?php esc_html_e( 'Physical', 'rivross-corporate' ); ?></option><option value="Online" <?php selected( 'Online', $fields['mode'] ); ?>><?php esc_html_e( 'Online', 'rivross-corporate' ); ?></option></select></td></tr>
		<tr><th><label for="rivross_event_status"><?php esc_html_e( 'Status', 'rivross-corporate' ); ?></label></th><td><select id="rivross_event_status" name="rivross_event_status"><option value="" <?php selected( '', $fields['status'] ); ?>><?php esc_html_e( 'Automatic from date', 'rivross-corporate' ); ?></option><option value="upcoming" <?php selected( 'upcoming', $fields['status'] ); ?>><?php esc_html_e( 'Upcoming', 'rivross-corporate' ); ?></option><option value="past" <?php selected( 'past', $fields['status'] ); ?>><?php esc_html_e( 'Past', 'rivross-corporate' ); ?></option></select></td></tr>
		<tr><th><label for="rivross_event_language"><?php esc_html_e( 'Language', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_event_language" name="rivross_event_language" value="<?php echo esc_attr( $fields['language'] ); ?>" placeholder="English"></td></tr>
		<tr><th><label for="rivross_event_dress_code"><?php esc_html_e( 'Dress Code', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_event_dress_code" name="rivross_event_dress_code" value="<?php echo esc_attr( $fields['dress_code'] ); ?>" placeholder="Business Attire"></td></tr>
		<tr><th><label for="rivross_event_contact_email"><?php esc_html_e( 'Event Contact Email', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="email" id="rivross_event_contact_email" name="rivross_event_contact_email" value="<?php echo esc_attr( $fields['contact_email'] ); ?>" placeholder="events@rivross.com"></td></tr>
		<tr><th colspan="2"><h3><?php esc_html_e( 'Agenda Highlights', 'rivross-corporate' ); ?></h3><p class="description"><?php esc_html_e( 'These three rows appear on the event details page. Leave a field blank to use the branded default.', 'rivross-corporate' ); ?></p></th></tr>
		<?php $icon_choices = function_exists( 'rivross_icon_choices' ) ? rivross_icon_choices() : array( 'calendar' => __( 'Calendar', 'rivross-corporate' ) ); for ( $agenda_index = 1; $agenda_index <= 3; $agenda_index++ ) : $agenda_icon = get_post_meta( $post->ID, '_rivross_event_agenda_' . $agenda_index . '_icon', true ); ?>
		<tr><th><label for="rivross_event_agenda_<?php echo esc_attr( $agenda_index ); ?>_title"><?php printf( esc_html__( 'Agenda %d', 'rivross-corporate' ), $agenda_index ); ?></label></th><td><input class="regular-text" type="text" id="rivross_event_agenda_<?php echo esc_attr( $agenda_index ); ?>_title" name="rivross_event_agenda_<?php echo esc_attr( $agenda_index ); ?>_title" value="<?php echo esc_attr( get_post_meta( $post->ID, '_rivross_event_agenda_' . $agenda_index . '_title', true ) ); ?>" placeholder="Opening & Welcome"><input class="regular-text" type="text" name="rivross_event_agenda_<?php echo esc_attr( $agenda_index ); ?>_description" value="<?php echo esc_attr( get_post_meta( $post->ID, '_rivross_event_agenda_' . $agenda_index . '_description', true ) ); ?>" placeholder="Short description"><input class="regular-text" type="text" name="rivross_event_agenda_<?php echo esc_attr( $agenda_index ); ?>_time" value="<?php echo esc_attr( get_post_meta( $post->ID, '_rivross_event_agenda_' . $agenda_index . '_time', true ) ); ?>" placeholder="10:00 AM – 11:00 AM"><select name="rivross_event_agenda_<?php echo esc_attr( $agenda_index ); ?>_icon"><?php foreach ( $icon_choices as $icon_value => $icon_label ) : ?><option value="<?php echo esc_attr( $icon_value ); ?>" <?php selected( $agenda_icon, $icon_value ); ?>><?php echo esc_html( $icon_label ); ?></option><?php endforeach; ?></select></td></tr>
		<?php endfor; ?>
		<tr><th><label for="rivross_event_register_url"><?php esc_html_e( 'Registration URL', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="url" id="rivross_event_register_url" name="rivross_event_register_url" value="<?php echo esc_attr( $fields['register_url'] ); ?>" placeholder="https://example.com/register"></td></tr>
		<tr><th><label for="rivross_event_details_url"><?php esc_html_e( 'Details URL', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="url" id="rivross_event_details_url" name="rivross_event_details_url" value="<?php echo esc_attr( $fields['details_url'] ); ?>" placeholder="Leave blank to use the event page"></td></tr>
	</table>
	<?php
}

/** Save Event custom fields. */
function rivross_save_event_meta( $post_id ) {
	if ( ! isset( $_POST['rivross_event_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rivross_event_nonce'] ) ), 'rivross_save_event' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_fields = array( 'start_date', 'end_date', 'time', 'location', 'language', 'dress_code' );
	foreach ( $text_fields as $field ) {
		$key   = 'rivross_event_' . $field;
		$value = isset( $_POST[ $key ] ) ? ( in_array( $field, array( 'start_date', 'end_date' ), true ) ? rivross_sanitize_date_value( wp_unslash( $_POST[ $key ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) ) : '';
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_rivross_event_' . $field );
		} else {
			update_post_meta( $post_id, '_rivross_event_' . $field, $value );
		}
	}
	$select_fields = array(
		'mode'   => array( 'Physical', 'Online' ),
		'status' => array( '', 'upcoming', 'past' ),
	);
	foreach ( $select_fields as $field => $allowed ) {
		$key   = 'rivross_event_' . $field;
		$value = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
		$value = in_array( $value, $allowed, true ) ? $value : '';
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_rivross_event_' . $field );
		} else {
			update_post_meta( $post_id, '_rivross_event_' . $field, $value );
		}
	}
	$contact_email = isset( $_POST['rivross_event_contact_email'] ) ? sanitize_email( wp_unslash( $_POST['rivross_event_contact_email'] ) ) : '';
	if ( '' === $contact_email ) {
		delete_post_meta( $post_id, '_rivross_event_contact_email' );
	} else {
		update_post_meta( $post_id, '_rivross_event_contact_email', $contact_email );
	}

	$url_fields = array( 'register_url', 'details_url' );
	foreach ( $url_fields as $field ) {
		$key   = 'rivross_event_' . $field;
		$value = isset( $_POST[ $key ] ) ? esc_url_raw( wp_unslash( $_POST[ $key ] ) ) : '';
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_rivross_event_' . $field );
		} else {
			update_post_meta( $post_id, '_rivross_event_' . $field, $value );
		}
	}

	$icon_choices = function_exists( 'rivross_icon_choices' ) ? rivross_icon_choices() : array();
	for ( $agenda_index = 1; $agenda_index <= 3; $agenda_index++ ) {
		$prefix = 'rivross_event_agenda_' . $agenda_index . '_';
		foreach ( array( 'title', 'description', 'time' ) as $field ) {
			$key   = $prefix . $field;
			$value = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
			if ( '' === $value ) {
				delete_post_meta( $post_id, '_rivross_event_agenda_' . $agenda_index . '_' . $field );
			} else {
				update_post_meta( $post_id, '_rivross_event_agenda_' . $agenda_index . '_' . $field, $value );
			}
		}
		$icon = isset( $_POST[ $prefix . 'icon' ] ) ? sanitize_key( wp_unslash( $_POST[ $prefix . 'icon' ] ) ) : '';
		if ( $icon && isset( $icon_choices[ $icon ] ) ) {
			update_post_meta( $post_id, '_rivross_event_agenda_' . $agenda_index . '_icon', $icon );
		} else {
			delete_post_meta( $post_id, '_rivross_event_agenda_' . $agenda_index . '_icon' );
		}
	}
}
add_action( 'save_post_rivross_event', 'rivross_save_event_meta' );

/** Return the event status, respecting an explicit admin override. */
function rivross_event_status( $post_id ) {
	$status = get_post_meta( $post_id, '_rivross_event_status', true );
	if ( in_array( $status, array( 'upcoming', 'past' ), true ) ) {
		return $status;
	}
	$start_date = get_post_meta( $post_id, '_rivross_event_start_date', true );
	return $start_date && $start_date < current_time( 'Y-m-d' ) ? 'past' : 'upcoming';
}

/** Return an event date label for cards and detail pages. */
function rivross_event_date_label( $post_id ) {
	$start = get_post_meta( $post_id, '_rivross_event_start_date', true );
	$end   = get_post_meta( $post_id, '_rivross_event_end_date', true );
	if ( ! $start ) {
		return '';
	}
	$start_date = DateTime::createFromFormat( 'Y-m-d', $start );
	$end_date   = $end ? DateTime::createFromFormat( 'Y-m-d', $end ) : false;
	if ( ! $start_date ) {
		return '';
	}
	if ( $end_date && $end_date->format( 'Y-m-d' ) !== $start_date->format( 'Y-m-d' ) ) {
		return $start_date->format( 'M j' ) . '–' . $end_date->format( 'M j, Y' );
	}
	return $start_date->format( 'M j, Y' );
}

/** Return the date badge parts used by the archive cards. */
function rivross_event_date_badge( $post_id ) {
	$start = get_post_meta( $post_id, '_rivross_event_start_date', true );
	$date  = $start ? DateTime::createFromFormat( 'Y-m-d', $start ) : false;
	return $date ? array( 'month' => strtoupper( $date->format( 'M' ) ), 'day' => $date->format( 'd' ), 'year' => $date->format( 'Y' ) ) : array( 'month' => '', 'day' => '', 'year' => '' );
}

/** Seed useful demo categories and events once after the theme is activated. */
function rivross_seed_event_content() {
	$categories = array(
		'conferences' => array( 'Conferences', 'users' ),
		'exhibitions' => array( 'Exhibitions', 'building' ),
		'webinars'    => array( 'Webinars', 'grid' ),
		'networking'  => array( 'Networking', 'handshake' ),
		'seminars'    => array( 'Seminars', 'briefcase' ),
	);
	foreach ( $categories as $slug => $category ) {
		$term = term_exists( $slug, 'rivross_event_category' );
		if ( ! $term ) {
			$term = wp_insert_term( $category[0], 'rivross_event_category', array( 'slug' => $slug ) );
		}
		if ( ! is_wp_error( $term ) ) {
			$term_id = is_array( $term ) ? $term['term_id'] : $term;
			update_term_meta( $term_id, '_rivross_event_category_icon', $category[1] );
		}
	}

	$events = array(
		array( 'rivross-annual-leadership-summit-2026', 'RIVROSS Annual Leadership Summit 2026', 'conferences', '2026-10-24', '2026-10-25', 'Dubai, UAE', 'Physical', '10:00 AM – 05:00 PM', 'A two-day summit bringing together industry leaders to discuss innovation, sustainability and the future of real estate.', 'users' ),
		array( 'real-estate-investment-forum-2026', 'Real Estate Investment Forum 2026', 'conferences', '2026-11-18', '', 'Singapore', 'Physical', '09:30 AM – 04:30 PM', 'Explore emerging markets, investment strategies and high-growth opportunities in the global real estate sector.', 'chart' ),
		array( 'rivross-property-expo-2026', 'RIVROSS Property Expo 2026', 'exhibitions', '2026-12-12', '2026-12-14', 'Dhaka, Bangladesh', 'Physical', '10:00 AM – 08:00 PM', 'Our flagship exhibition showcasing premium projects, innovative solutions and exclusive offers.', 'building' ),
		array( 'sustainability-in-real-estate-webinar', 'Sustainability in Real Estate Webinar', 'webinars', '2027-01-26', '', 'Online', 'Online', '03:00 PM – 04:30 PM', 'A live webinar with experts sharing insights on building sustainable and resilient communities.', 'leaf' ),
		array( 'partner-networking-evening-2027', 'Partner Networking Evening 2027', 'networking', '2027-02-19', '', 'Dhaka, Bangladesh', 'Physical', '06:00 PM – 09:00 PM', 'Connect with investors, partners and the people shaping RIVROSS growth across industries.', 'handshake' ),
		array( 'tea-business-supply-chain-seminar', 'Tea Business & Supply Chain Seminar', 'seminars', '2027-03-14', '', 'Sylhet, Bangladesh', 'Physical', '10:00 AM – 02:00 PM', 'A focused seminar on responsible sourcing, supply chain resilience and new tea market opportunities.', 'sprout' ),
		array( 'travel-tourism-growth-forum-2027', 'Travel & Tourism Growth Forum 2027', 'conferences', '2027-04-09', '', 'Kuala Lumpur, Malaysia', 'Physical', '09:00 AM – 05:00 PM', 'Meet tourism leaders and discover partnerships that connect people, places and possibilities.', 'plane' ),		
		array( 'community-impact-showcase-2027', 'Community Impact Showcase 2027', 'exhibitions', '2027-05-21', '', 'Dhaka, Bangladesh', 'Physical', '11:00 AM – 06:00 PM', 'See how our projects and partners are creating lasting value for the communities we serve.', 'award' ),
		array( 'future-ventures-demo-day-2027', 'Future Ventures Demo Day 2027', 'seminars', '2027-06-16', '', 'Singapore', 'Physical', '01:00 PM – 06:00 PM', 'A curated showcase of bold ideas, emerging ventures and the next generation of opportunity.', 'target' ),
		array( 'green-cities-roundtable-2027', 'Green Cities Roundtable 2027', 'networking', '2027-07-28', '', 'Dubai, UAE', 'Physical', '10:00 AM – 01:30 PM', 'A practical conversation about sustainable urban development and responsible growth.', 'leaf' ),
	);

	foreach ( $events as $event ) {
		if ( get_page_by_path( $event[0], OBJECT, 'rivross_event' ) ) {
			continue;
		}
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'rivross_event',
				'post_status'  => 'publish',
				'post_name'    => $event[0],
				'post_title'   => $event[1],
				'post_excerpt' => $event[8],
				'post_content' => '<p>' . esc_html( $event[8] ) . '</p><p>Join the RIVROSS team and our invited speakers for practical insights, meaningful conversations and new opportunities.</p>',
			)
		);
		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}
		wp_set_object_terms( $post_id, $event[2], 'rivross_event_category' );
		update_post_meta( $post_id, '_rivross_event_start_date', $event[3] );
		update_post_meta( $post_id, '_rivross_event_end_date', $event[4] );
		update_post_meta( $post_id, '_rivross_event_location', $event[5] );
		update_post_meta( $post_id, '_rivross_event_mode', $event[6] );
		update_post_meta( $post_id, '_rivross_event_time', $event[7] );
		update_post_meta( $post_id, '_rivross_event_status', 'upcoming' );
		update_post_meta( $post_id, '_rivross_event_register_url', '#' );
		update_post_meta( $post_id, '_rivross_event_icon', $event[9] );
	}
}
add_action( 'after_switch_theme', 'rivross_seed_event_content' );

/** Add useful Event columns to the admin list. */
function rivross_event_admin_columns( $columns ) {
	$columns['event_date']     = __( 'Event Date', 'rivross-corporate' );
	$columns['event_location'] = __( 'Location', 'rivross-corporate' );
	$columns['event_status']   = __( 'Status', 'rivross-corporate' );
	return $columns;
}
add_filter( 'manage_rivross_event_posts_columns', 'rivross_event_admin_columns' );

function rivross_event_admin_column_content( $column, $post_id ) {
	if ( 'event_date' === $column ) {
		echo esc_html( rivross_event_date_label( $post_id ) );
	} elseif ( 'event_location' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_rivross_event_location', true ) );
	} elseif ( 'event_status' === $column ) {
		echo esc_html( ucfirst( rivross_event_status( $post_id ) ) );
	}
}
add_action( 'manage_rivross_event_posts_custom_column', 'rivross_event_admin_column_content', 10, 2 );
