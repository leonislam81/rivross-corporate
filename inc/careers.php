<?php
/**
 * RIVROSS Careers jobs content type and editable job fields.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Register the Careers jobs content type and department taxonomy. */
function rivross_register_job_content() {
	$labels = array(
		'name'               => __( 'Jobs', 'rivross-corporate' ),
		'singular_name'      => __( 'Job', 'rivross-corporate' ),
		'menu_name'          => __( 'Careers Jobs', 'rivross-corporate' ),
		'add_new'            => __( 'Add Job', 'rivross-corporate' ),
		'add_new_item'       => __( 'Add New Job', 'rivross-corporate' ),
		'edit_item'          => __( 'Edit Job', 'rivross-corporate' ),
		'new_item'           => __( 'New Job', 'rivross-corporate' ),
		'view_item'          => __( 'View Job', 'rivross-corporate' ),
		'search_items'       => __( 'Search Jobs', 'rivross-corporate' ),
		'not_found'          => __( 'No jobs found.', 'rivross-corporate' ),
		'not_found_in_trash' => __( 'No jobs found in Trash.', 'rivross-corporate' ),
	);

	register_post_type(
		'rivross_job',
		array(
			'labels'             => $labels,
			'public'             => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-businessperson',
			'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'has_archive'        => false,
			'rewrite'            => array( 'slug' => 'careers', 'with_front' => false ),
			'publicly_queryable' => true,
			'show_in_nav_menus'  => false,
		)
	);

	register_taxonomy(
		'rivross_job_department',
		'rivross_job',
		array(
			'labels'            => array(
				'name'          => __( 'Departments', 'rivross-corporate' ),
				'singular_name' => __( 'Department', 'rivross-corporate' ),
				'menu_name'     => __( 'Departments', 'rivross-corporate' ),
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
add_action( 'init', 'rivross_register_job_content' );

/** Return the editable field definitions used by the Job Details panel. */
function rivross_job_fields() {
	return array(
		'department'      => array( 'label' => __( 'Department', 'rivross-corporate' ), 'type' => 'text' ),
		'employment_type' => array( 'label' => __( 'Employment Type', 'rivross-corporate' ), 'type' => 'select', 'options' => array( 'Full Time', 'Part Time', 'Contract', 'Internship' ) ),
		'location'        => array( 'label' => __( 'Location', 'rivross-corporate' ), 'type' => 'text' ),
		'experience'      => array( 'label' => __( 'Experience', 'rivross-corporate' ), 'type' => 'text' ),
		'work_mode'       => array( 'label' => __( 'Work Mode', 'rivross-corporate' ), 'type' => 'select', 'options' => array( 'On-site', 'Hybrid', 'Remote' ) ),
		'deadline'        => array( 'label' => __( 'Application Deadline', 'rivross-corporate' ), 'type' => 'text' ),
		'job_code'        => array( 'label' => __( 'Job Reference', 'rivross-corporate' ), 'type' => 'text' ),
		'hero_image'      => array( 'label' => __( 'Job Hero Image', 'rivross-corporate' ), 'type' => 'url' ),
		'application_shortcode' => array( 'label' => __( 'Application Form Shortcode (optional)', 'rivross-corporate' ), 'type' => 'textarea' ),
		'application_email' => array( 'label' => __( 'Application Email', 'rivross-corporate' ), 'type' => 'email' ),
		'responsibilities' => array( 'label' => __( 'Key Responsibilities', 'rivross-corporate' ), 'type' => 'textarea' ),
		'requirements'    => array( 'label' => __( 'Requirements', 'rivross-corporate' ), 'type' => 'textarea' ),
	);
}

/** Read a Job custom field with a safe fallback. */
function rivross_job_meta( $job_id, $field, $default = '' ) {
	$value = get_post_meta( $job_id, '_rivross_job_' . $field, true );
	return '' !== $value ? $value : $default;
}

/** Resolve the image used by a job hero and related cards. */
function rivross_job_image_url( $job_id ) {
	$image = get_the_post_thumbnail_url( $job_id, 'large' );
	if ( $image ) {
		return $image;
	}
	$image = rivross_job_meta( $job_id, 'hero_image' );
	if ( $image ) {
		return esc_url( $image );
	}
	return get_theme_file_uri( '/assets/images/careers/careers-job-hero.png' );
}

/** Convert a newline-separated field to clean bullet items. */
function rivross_job_bullets( $job_id, $field, $defaults = array() ) {
	$raw   = rivross_job_meta( $job_id, $field );
	$items = preg_split( '/\r?\n|\|/', (string) $raw );
	$items = array_values( array_filter( array_map( 'trim', $items ) ) );
	return ! empty( $items ) ? $items : $defaults;
}

/** Return the four offer items shown on the Job Details page. */
function rivross_job_benefits( $job_id ) {
	$defaults = array(
		array( 'users', __( 'Competitive Compensation', 'rivross-corporate' ), __( 'Attractive salary package with performance bonuses.', 'rivross-corporate' ) ),
		array( 'heart', __( 'Health & Wellbeing', 'rivross-corporate' ), __( 'Comprehensive health insurance for you and your family.', 'rivross-corporate' ) ),
		array( 'chart', __( 'Career Growth', 'rivross-corporate' ), __( 'Opportunities to learn, lead and grow with us.', 'rivross-corporate' ) ),
		array( 'sprout', __( 'Meaningful Impact', 'rivross-corporate' ), __( 'Be part of a team building stronger communities.', 'rivross-corporate' ) ),
	);
	$benefits = array();
	$choices  = function_exists( 'rivross_icon_choices' ) ? rivross_icon_choices() : array();
	for ( $index = 1; $index <= 4; $index++ ) {
		$title       = rivross_job_meta( $job_id, 'benefit_' . $index . '_title' );
		$description = rivross_job_meta( $job_id, 'benefit_' . $index . '_description' );
		$icon        = rivross_job_meta( $job_id, 'benefit_' . $index . '_icon' );
		if ( '' === $title && isset( $defaults[ $index - 1 ] ) ) {
			$title = $defaults[ $index - 1 ][1];
		}
		if ( '' === $description && isset( $defaults[ $index - 1 ] ) ) {
			$description = $defaults[ $index - 1 ][2];
		}
		if ( '' === $icon && isset( $defaults[ $index - 1 ] ) ) {
			$icon = $defaults[ $index - 1 ][0];
		}
		$benefits[] = array( $choices && isset( $choices[ $icon ] ) ? $icon : ( $defaults[ $index - 1 ][0] ?? 'users' ), $title, $description );
	}
	return $benefits;
}

/** Render the reusable job cards shown in the Careers listing. */
function rivross_render_job_cards( $jobs ) {
	$contact_url = home_url( '/contact-us/#contact-form' );
	$empty       = get_theme_mod( 'rivross_careers_jobs_empty_message', __( 'No open positions are available right now. Please check back soon.', 'rivross-corporate' ) );

	ob_start();
	if ( empty( $jobs ) ) {
		echo '<p class="careers-jobs__empty">' . esc_html( $empty ) . '</p>';
	}

	foreach ( $jobs as $job ) {
		if ( ! is_object( $job ) ) {
			continue;
		}
		$job_id     = (int) $job->ID;
		$title      = get_the_title( $job );
		$location   = rivross_job_meta( $job_id, 'location', __( 'Dhaka, Bangladesh', 'rivross-corporate' ) );
		$experience = rivross_job_meta( $job_id, 'experience' );
		$type       = rivross_job_meta( $job_id, 'employment_type', __( 'Full Time', 'rivross-corporate' ) );
		$summary    = get_the_excerpt( $job ) ?: wp_trim_words( get_post_field( 'post_content', $job_id ), 22, '…' );
		$url        = get_permalink( $job );
		?>
		<article class="career-job-card">
			<div class="career-job-card__top"><h3><?php echo esc_html( $title ); ?></h3><span><?php echo esc_html( $type ); ?></span></div>
			<div class="career-job-card__meta"><span><?php echo rivross_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $location ); ?></span><span><?php echo rivross_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $experience ); ?></span></div>
			<p><?php echo esc_html( $summary ); ?></p>
			<a class="rivross-button rivross-button--outline-dark" href="<?php echo esc_url( $url ?: $contact_url ); ?>"><?php esc_html_e( 'View Details', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
		</article>
		<?php
	}
	return ob_get_clean();
}

/** Render numbered AJAX pagination for the Careers job listing. */
function rivross_render_jobs_pagination( $current, $total ) {
	$total = (int) $total;
	if ( $total < 1 ) {
		return '';
	}
	$total   = max( 1, $total );
	$current = max( 1, min( (int) $current, $total ) );

	$pages = $total <= 7 ? range( 1, $total ) : array( 1, 2, $current - 1, $current, $current + 1, $total - 1, $total );
	$pages = array_values( array_unique( array_filter( $pages, static function ( $page ) use ( $total ) { return $page >= 1 && $page <= $total; } ) ) );

	ob_start();
	?>
	<nav class="careers-jobs__pagination" aria-label="<?php esc_attr_e( 'Jobs pages', 'rivross-corporate' ); ?>">
		<button type="button" class="careers-jobs__page careers-jobs__page--arrow careers-jobs__page--prev" data-careers-jobs-page="<?php echo esc_attr( max( 1, $current - 1 ) ); ?>" aria-label="<?php esc_attr_e( 'Previous jobs page', 'rivross-corporate' ); ?>" <?php disabled( 1 === $current ); ?>>&lsaquo;</button>
		<?php
		$last_page = 0;
		foreach ( $pages as $page ) :
			if ( $last_page && $page > $last_page + 1 ) {
				echo '<span class="careers-jobs__ellipsis" aria-hidden="true">…</span>';
			}
			$last_page = $page;
			?>
			<button type="button" class="careers-jobs__page<?php echo $page === $current ? ' is-current' : ''; ?>" data-careers-jobs-page="<?php echo esc_attr( $page ); ?>"<?php echo $page === $current ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $page ); ?></button>
		<?php endforeach; ?>
		<button type="button" class="careers-jobs__page careers-jobs__page--arrow careers-jobs__page--next" data-careers-jobs-page="<?php echo esc_attr( min( $total, $current + 1 ) ); ?>" aria-label="<?php esc_attr_e( 'Next jobs page', 'rivross-corporate' ); ?>" <?php disabled( $current === $total ); ?>>&rsaquo;</button>
	</nav>
	<?php
	return ob_get_clean();
}

/** Return one page of Careers jobs to the frontend without reloading the page. */
function rivross_ajax_load_jobs() {
	/*
	 * This endpoint only returns already-published job cards and changes no
	 * data, so it deliberately does not embed a nonce in the cached Careers
	 * page. A nonce can expire while a full-page cache still serves the old
	 * HTML, which would break pagination after a period of inactivity.
	 */
	nocache_headers();

	$page  = isset( $_POST['page'] ) ? max( 1, absint( $_POST['page'] ) ) : 1;
	$query = new WP_Query(
		array(
			'post_type'           => 'rivross_job',
			'post_status'         => 'publish',
			'posts_per_page'      => 6,
			'paged'               => $page,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'ignore_sticky_posts' => true,
		)
	);

	if ( $page > 1 && ! $query->have_posts() ) {
		wp_send_json_error( array( 'message' => __( 'That jobs page is no longer available.', 'rivross-corporate' ) ), 404 );
	}

	wp_send_json_success(
		array(
			'html'       => rivross_render_job_cards( $query->posts ),
			'pagination' => rivross_render_jobs_pagination( $page, (int) $query->max_num_pages ),
		)
	);
}
add_action( 'wp_ajax_rivross_load_jobs', 'rivross_ajax_load_jobs' );
add_action( 'wp_ajax_nopriv_rivross_load_jobs', 'rivross_ajax_load_jobs' );

/** Keep nonce-bearing job forms fresh when a page-cache plugin is enabled. */
function rivross_job_form_cache_compatibility() {
	if ( ! is_singular( 'rivross_job' ) ) {
		return;
	}
	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}
	if ( ! defined( 'DONOTCACHEOBJECT' ) ) {
		define( 'DONOTCACHEOBJECT', true );
	}
	nocache_headers();
}
add_action( 'template_redirect', 'rivross_job_form_cache_compatibility', 1 );

/** Redirect an application request back to the relevant job form. */
function rivross_job_application_redirect( $job_id, $status ) {
	$url = $job_id ? get_permalink( $job_id ) : home_url( '/careers/' );
	$url = $url ? add_query_arg( 'application', sanitize_key( $status ), $url ) : home_url( '/careers/' );
	wp_safe_redirect( $url . '#career-application-form' );
	exit;
}

/** Receive the built-in job application form securely when no CF7 form is configured. */
function rivross_handle_job_application() {
	$job_id = isset( $_POST['job_id'] ) ? absint( $_POST['job_id'] ) : 0;
	$nonce  = isset( $_POST['rivross_application_nonce'] ) && is_scalar( $_POST['rivross_application_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['rivross_application_nonce'] ) ) : '';
	if ( ! $job_id || ! $nonce || ! wp_verify_nonce( $nonce, 'rivross_submit_job_application' ) ) {
		rivross_job_application_redirect( $job_id, 'error' );
	}
	if ( 'rivross_job' !== get_post_type( $job_id ) || 'publish' !== get_post_status( $job_id ) ) {
		rivross_job_application_redirect( $job_id, 'error' );
	}
	if ( ! empty( $_POST['rivross_website'] ) ) {
		rivross_job_application_redirect( $job_id, 'error' );
	}

	$name    = isset( $_POST['applicant_name'] ) ? sanitize_text_field( wp_unslash( $_POST['applicant_name'] ) ) : '';
	$email   = isset( $_POST['applicant_email'] ) ? sanitize_email( wp_unslash( $_POST['applicant_email'] ) ) : '';
	$phone   = isset( $_POST['applicant_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['applicant_phone'] ) ) : '';
	$message = isset( $_POST['applicant_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['applicant_message'] ) ) : '';
	if ( '' === $name || ! is_email( $email ) || '' === $phone ) {
		rivross_job_application_redirect( $job_id, 'error' );
	}

	$attachment = '';
	if ( isset( $_FILES['applicant_cv'] ) && is_array( $_FILES['applicant_cv'] ) && ! empty( $_FILES['applicant_cv']['name'] ) ) {
		$file = $_FILES['applicant_cv'];
		$mimes = array(
			'pdf'  => 'application/pdf',
			'doc'  => 'application/msword',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		);
		if ( ! isset( $file['error'], $file['size'], $file['tmp_name'] ) || UPLOAD_ERR_OK !== (int) $file['error'] || (int) $file['size'] > 5 * 1024 * 1024 ) {
			rivross_job_application_redirect( $job_id, 'error' );
		}
		$file_type = wp_check_filetype_and_ext( $file['tmp_name'], sanitize_file_name( $file['name'] ), $mimes );
		if ( empty( $file_type['ext'] ) || empty( $file_type['type'] ) ) {
			rivross_job_application_redirect( $job_id, 'error' );
		}
		require_once ABSPATH . 'wp-admin/includes/file.php';
		$upload = wp_handle_upload( $file, array( 'test_form' => false, 'mimes' => $mimes ) );
		if ( isset( $upload['error'] ) || empty( $upload['file'] ) ) {
			rivross_job_application_redirect( $job_id, 'error' );
		}
		$attachment = $upload['file'];
	}

	$recipient = sanitize_email( rivross_job_meta( $job_id, 'application_email', get_option( 'admin_email' ) ) );
	if ( ! is_email( $recipient ) ) {
		$recipient = sanitize_email( get_option( 'admin_email' ) );
	}
	$title   = get_the_title( $job_id );
	$subject = sprintf( __( 'New application for %s', 'rivross-corporate' ), $title );
	$reply_name = str_replace( array( "\r", "\n" ), '', $name );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $reply_name . ' <' . $email . '>' );
	$body    = implode( "\n", array(
		sprintf( __( 'Position: %s', 'rivross-corporate' ), $title ),
		sprintf( __( 'Name: %s', 'rivross-corporate' ), $name ),
		sprintf( __( 'Email: %s', 'rivross-corporate' ), $email ),
		sprintf( __( 'Phone: %s', 'rivross-corporate' ), $phone ),
		'', __( 'Message:', 'rivross-corporate' ),
		$message,
	) );
	$sent = wp_mail( $recipient, $subject, $body, $headers, $attachment ? array( $attachment ) : array() );
	if ( $attachment ) {
		wp_delete_file( $attachment );
	}
	rivross_job_application_redirect( $job_id, $sent ? 'sent' : 'error' );
}
add_action( 'admin_post_rivross_submit_job_application', 'rivross_handle_job_application' );
add_action( 'admin_post_nopriv_rivross_submit_job_application', 'rivross_handle_job_application' );

/** Add the editable Job Details panel. */
function rivross_add_job_meta_box() {
	add_meta_box( 'rivross_job_details', __( 'Job Details', 'rivross-corporate' ), 'rivross_render_job_meta_box', 'rivross_job', 'normal', 'high' );
}
add_action( 'add_meta_boxes_rivross_job', 'rivross_add_job_meta_box' );

/** Render the editable Job Details fields. */
function rivross_render_job_meta_box( $post ) {
	wp_nonce_field( 'rivross_save_job', 'rivross_job_nonce' );
	$fields = rivross_job_fields();
	echo '<p class="description">' . esc_html__( 'These fields power the Careers listing and individual Job Details page. Put one responsibility or requirement per line. Use Featured Image for the primary job image; Job Hero Image is the fallback.', 'rivross-corporate' ) . '</p>';
	echo '<table class="form-table"><tbody>';
	foreach ( $fields as $key => $field ) {
		$value = rivross_job_meta( $post->ID, $key );
		echo '<tr><th><label for="rivross_job_' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label></th><td>';
		if ( 'select' === $field['type'] ) {
			echo '<select class="regular-text" id="rivross_job_' . esc_attr( $key ) . '" name="rivross_job_' . esc_attr( $key ) . '">';
			foreach ( $field['options'] as $option ) {
				echo '<option value="' . esc_attr( $option ) . '" ' . selected( $value, $option, false ) . '>' . esc_html( $option ) . '</option>';
			}
			echo '</select>';
		} elseif ( 'textarea' === $field['type'] ) {
			echo '<textarea class="large-text" rows="4" id="rivross_job_' . esc_attr( $key ) . '" name="rivross_job_' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea>';
		} else {
			if ( 'hero_image' === $key ) {
				echo '<input class="regular-text rivross-media-input" type="url" id="rivross_job_' . esc_attr( $key ) . '" name="rivross_job_' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"> <button type="button" class="button rivross-media-button" data-target="rivross_job_' . esc_attr( $key ) . '">' . esc_html__( 'Choose / Upload Image', 'rivross-corporate' ) . '</button> <button type="button" class="button rivross-media-clear" data-target="rivross_job_' . esc_attr( $key ) . '">' . esc_html__( 'Clear', 'rivross-corporate' ) . '</button><div class="rivross-media-preview" data-preview-for="rivross_job_' . esc_attr( $key ) . '" style="display:none;max-width:180px;margin-top:8px;"></div>';
			} else {
				echo '<input class="regular-text" type="' . esc_attr( $field['type'] ) . '" id="rivross_job_' . esc_attr( $key ) . '" name="rivross_job_' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">';
			}
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
	echo '<h3>' . esc_html__( 'What We Offer', 'rivross-corporate' ) . '</h3><p class="description">' . esc_html__( 'Customize the four benefit cards shown below the requirements.', 'rivross-corporate' ) . '</p>';
	$choices = function_exists( 'rivross_icon_choices' ) ? rivross_icon_choices() : array( 'users' => __( 'People', 'rivross-corporate' ) );
	for ( $index = 1; $index <= 4; $index++ ) {
		$icon = rivross_job_meta( $post->ID, 'benefit_' . $index . '_icon', 'users' );
		echo '<p><strong>' . sprintf( esc_html__( 'Benefit %d', 'rivross-corporate' ), $index ) . '</strong><br><input class="regular-text" type="text" name="rivross_job_benefit_' . esc_attr( $index ) . '_title" value="' . esc_attr( rivross_job_meta( $post->ID, 'benefit_' . $index . '_title' ) ) . '" placeholder="Benefit title"> <input class="regular-text" type="text" name="rivross_job_benefit_' . esc_attr( $index ) . '_description" value="' . esc_attr( rivross_job_meta( $post->ID, 'benefit_' . $index . '_description' ) ) . '" placeholder="Short description"> <select name="rivross_job_benefit_' . esc_attr( $index ) . '_icon">';
		foreach ( $choices as $icon_value => $icon_label ) {
			echo '<option value="' . esc_attr( $icon_value ) . '" ' . selected( $icon, $icon_value, false ) . '>' . esc_html( $icon_label ) . '</option>';
		}
		echo '</select></p>';
	}
}

/** Save Job Details fields. */
function rivross_save_job_meta( $post_id ) {
	if ( ! isset( $_POST['rivross_job_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rivross_job_nonce'] ) ), 'rivross_save_job' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( rivross_job_fields() as $key => $field ) {
		$input_key = 'rivross_job_' . $key;
		if ( ! isset( $_POST[ $input_key ] ) ) {
			continue;
		}
		$raw   = wp_unslash( $_POST[ $input_key ] );
		if ( 'select' === $field['type'] ) {
			$value = in_array( $raw, $field['options'], true ) ? $raw : '';
		} else {
			$value = 'url' === $field['type'] ? esc_url_raw( $raw ) : ( 'email' === $field['type'] ? sanitize_email( $raw ) : ( 'textarea' === $field['type'] ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw ) ) );
		}
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_rivross_job_' . $key );
		} else {
			update_post_meta( $post_id, '_rivross_job_' . $key, $value );
		}
	}
	$choices = function_exists( 'rivross_icon_choices' ) ? rivross_icon_choices() : array();
	for ( $index = 1; $index <= 4; $index++ ) {
		foreach ( array( 'title', 'description' ) as $field ) {
			$key   = 'rivross_job_benefit_' . $index . '_' . $field;
			$value = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
			if ( '' === $value ) {
				delete_post_meta( $post_id, '_rivross_job_benefit_' . $index . '_' . $field );
			} else {
				update_post_meta( $post_id, '_rivross_job_benefit_' . $index . '_' . $field, $value );
			}
		}
		$key  = 'rivross_job_benefit_' . $index . '_icon';
		$icon = isset( $_POST[ $key ] ) ? sanitize_key( wp_unslash( $_POST[ $key ] ) ) : '';
		if ( $icon && isset( $choices[ $icon ] ) ) {
			update_post_meta( $post_id, '_rivross_job_benefit_' . $index . '_icon', $icon );
		}
	}
}
add_action( 'save_post_rivross_job', 'rivross_save_job_meta' );

/** Add the most useful job fields to the dashboard list view. */
function rivross_job_admin_columns( $columns ) {
	$columns['job_department'] = __( 'Department', 'rivross-corporate' );
	$columns['job_location']   = __( 'Location', 'rivross-corporate' );
	$columns['job_type']       = __( 'Employment', 'rivross-corporate' );
	$columns['job_work_mode']  = __( 'Work Mode', 'rivross-corporate' );
	return $columns;
}
add_filter( 'manage_rivross_job_posts_columns', 'rivross_job_admin_columns' );

function rivross_job_admin_column_content( $column, $post_id ) {
	if ( 'job_department' === $column ) {
		echo esc_html( rivross_job_meta( $post_id, 'department' ) );
	} elseif ( 'job_location' === $column ) {
		echo esc_html( rivross_job_meta( $post_id, 'location' ) );
	} elseif ( 'job_type' === $column ) {
		echo esc_html( rivross_job_meta( $post_id, 'employment_type' ) );
	} elseif ( 'job_work_mode' === $column ) {
		echo esc_html( rivross_job_meta( $post_id, 'work_mode' ) );
	}
}
add_action( 'manage_rivross_job_posts_custom_column', 'rivross_job_admin_column_content', 10, 2 );

/** Create the dedicated general application page used by the Careers CTA. */
function rivross_seed_general_application_page() {
	$page = get_page_by_path( 'submit-your-cv' );
	if ( $page ) {
		if ( 'page-general-application.php' !== get_page_template_slug( $page->ID ) ) {
			update_post_meta( $page->ID, '_wp_page_template', 'page-general-application.php' );
		}
		return;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'  => __( 'Submit Your CV', 'rivross-corporate' ),
			'post_name'   => 'submit-your-cv',
			'post_type'   => 'page',
			'post_status' => 'publish',
		)
	);
	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_post_meta( $page_id, '_wp_page_template', 'page-general-application.php' );
	}
}
add_action( 'init', 'rivross_seed_general_application_page', 20 );

/** Create the Contact Form 7 form that receives general CV submissions. */
function rivross_seed_general_application_form() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) || ! empty( WPCF7_ContactForm::find( array( 'title' => 'RIVROSS General Application', 'posts_per_page' => 1 ) ) ) ) {
		return;
	}

	$icon = static function ( $name ) {
		return function_exists( 'rivross_icon' ) ? rivross_icon( $name ) : '';
	};
	$form_markup = '<div class="career-general-cf7-fields">'
		. '<div class="career-general-cf7-field"><label><span class="career-general-cf7-label">Full Name <b>*</b></span><span class="career-general-cf7-control"><span class="career-general-cf7-icon">' . $icon( 'users' ) . '</span>[text* applicant-name autocomplete:name placeholder "Full Name"]</span></label></div>'
		. '<div class="career-general-cf7-field"><label><span class="career-general-cf7-label">Email Address <b>*</b></span><span class="career-general-cf7-control"><span class="career-general-cf7-icon">' . $icon( 'mail' ) . '</span>[email* applicant-email autocomplete:email placeholder "Email Address"]</span></label></div>'
		. '<div class="career-general-cf7-field"><label><span class="career-general-cf7-label">Phone Number</span><span class="career-general-cf7-control"><span class="career-general-cf7-icon">' . $icon( 'phone' ) . '</span>[tel applicant-phone autocomplete:tel placeholder "Phone Number"]</span></label></div>'
		. '<div class="career-general-cf7-field"><label><span class="career-general-cf7-label">Position of Interest</span><span class="career-general-cf7-control"><span class="career-general-cf7-icon">' . $icon( 'briefcase' ) . '</span>[text applicant-position placeholder "Position you are interested in"]</span></label></div>'
		. '<div class="career-general-cf7-field career-general-cf7-field--file"><label><span class="career-general-cf7-label">CV / Resume <b>*</b></span><span class="career-general-cf7-control"><span class="career-general-cf7-icon">' . $icon( 'file' ) . '</span>[file* applicant-cv limit:5mb filetypes:pdf|doc|docx]</span></label><small>PDF, DOC or DOCX · 5MB maximum</small></div>'
		. '<div class="career-general-cf7-field career-general-cf7-field--message"><label><span class="career-general-cf7-label">Short Message</span><span class="career-general-cf7-control"><span class="career-general-cf7-icon career-general-cf7-icon--top">' . $icon( 'news' ) . '</span>[textarea applicant-message placeholder "Tell us a little about yourself..."]</span></label></div>'
		. '<div class="career-general-cf7-submit">[submit class:rivross-button "Submit Your CV →"]</div>'
		. '</div>';

	$form = WPCF7_ContactForm::get_template( array( 'title' => 'RIVROSS General Application' ) );
	$mail = (array) $form->prop( 'mail' );
	$recipient = get_theme_mod( 'rivross_contact_email', get_option( 'admin_email' ) );
	$mail['subject']            = 'General CV submission from [applicant-name]';
	$mail['sender']             = 'RIVROSS Website <wordpress@' . wp_parse_url( home_url(), PHP_URL_HOST ) . '>';
	$mail['recipient']          = sanitize_email( $recipient );
	$mail['body']               = "Name: [applicant-name]\nEmail: [applicant-email]\nPhone: [applicant-phone]\nPosition of interest: [applicant-position]\n\nMessage:\n[applicant-message]";
	$mail['additional_headers'] = 'Reply-To: [applicant-email]';
	$mail['attachments']        = '[applicant-cv]';
	$form->set_properties( array( 'form' => $form_markup, 'mail' => $mail ) );
	$form->save();
}
add_action( 'init', 'rivross_seed_general_application_form', 25 );

/** Seed the six roles from the Careers mockup when no job content exists. */
function rivross_seed_jobs() {
	if ( get_option( 'rivross_jobs_seeded' ) ) {
		return;
	}
	$departments = array( 'Project Management', 'Investment & Advisory', 'Marketing & Communications', 'Engineering & Construction', 'People & Culture', 'Business Development' );
	foreach ( $departments as $department ) {
		if ( ! term_exists( $department, 'rivross_job_department' ) ) {
			wp_insert_term( $department, 'rivross_job_department' );
		}
	}
	$hero = get_theme_file_uri( '/assets/images/careers/careers-job-hero.png' );
	$jobs = array(
		array(
			'slug' => 'senior-project-manager', 'title' => 'Senior Project Manager', 'department' => 'Project Management', 'type' => 'Full Time', 'location' => 'Dhaka, Bangladesh', 'experience' => '5+ Years Experience', 'mode' => 'On-site', 'deadline' => 'June 30, 2026', 'code' => 'RIV-CAR-001',
			'excerpt' => 'Lead and deliver large-scale real estate projects from concept to completion.',
			'content' => 'We are seeking an experienced and driven Senior Project Manager to lead large-scale real estate development projects from concept to completion. You will oversee project planning, design coordination, construction execution and stakeholder management, ensuring delivery on time, within budget and to the highest quality standards.',
			'responsibilities' => "Lead and manage the full project lifecycle from feasibility and planning to handover.\nCoordinate with architects, consultants, contractors and internal teams.\nDevelop and monitor project schedules, budgets and resource plans.\nEnsure compliance with regulatory requirements, safety standards and quality benchmarks.\nIdentify and manage project risks, issues and change requests.\nProvide regular progress updates to senior management and stakeholders.",
			'requirements' => "Bachelor's degree in Civil Engineering, Construction Management or a related field.\nMinimum 5+ years of experience in real estate development or large-scale construction projects.\nStrong knowledge of project management methods and industry best practices.\nExcellent leadership, communication and stakeholder management skills.\nProficiency in project management software and MS Office.",
		),
		array(
			'slug' => 'investment-analyst', 'title' => 'Investment Analyst', 'department' => 'Investment & Advisory', 'type' => 'Full Time', 'location' => 'Dhaka, Bangladesh', 'experience' => '2–4 Years Experience', 'mode' => 'Hybrid', 'deadline' => 'July 15, 2026', 'code' => 'RIV-CAR-002',
			'excerpt' => 'Analyze investment opportunities and support strategic decision-making.',
			'content' => 'Join our investment team to evaluate opportunities across real estate and emerging business ventures. You will turn market research and financial analysis into clear recommendations for sustainable growth.',
			'responsibilities' => "Build financial models and investment analysis for new opportunities.\nResearch market trends, comparable projects and competitive landscapes.\nPrepare investment memos, presentations and portfolio updates.\nSupport due diligence, valuation and scenario planning.\nCollaborate with project and finance teams on strategic initiatives.",
			'requirements' => "Bachelor's degree in Finance, Economics, Business or a related field.\n2–4 years of experience in investment, corporate finance or real estate analysis.\nAdvanced Excel and strong financial modelling skills.\nClear written and verbal communication.\nCuriosity, integrity and a practical problem-solving mindset.",
		),
		array(
			'slug' => 'marketing-executive', 'title' => 'Marketing Executive', 'department' => 'Marketing & Communications', 'type' => 'Full Time', 'location' => 'Dhaka, Bangladesh', 'experience' => '2–3 Years Experience', 'mode' => 'On-site', 'deadline' => 'July 20, 2026', 'code' => 'RIV-CAR-003',
			'excerpt' => 'Drive brand awareness and create impactful marketing campaigns.',
			'content' => 'Help shape how RIVROSS connects with clients, partners and communities. This role blends campaign planning, content creation and performance reporting across our business verticals.',
			'responsibilities' => "Plan and execute integrated marketing campaigns.\nCreate clear content for digital, print and event channels.\nCoordinate agencies, vendors and internal stakeholders.\nTrack campaign performance and prepare monthly reports.\nSupport launches, events and brand partnerships.",
			'requirements' => "Bachelor's degree in Marketing, Communications or a related discipline.\n2–3 years of hands-on marketing experience.\nStrong writing, presentation and coordination skills.\nComfort with social media and basic analytics tools.\nAn eye for detail and a thoughtful, collaborative approach.",
		),
		array(
			'slug' => 'civil-engineer', 'title' => 'Civil Engineer', 'department' => 'Engineering & Construction', 'type' => 'Full Time', 'location' => 'Dhaka, Bangladesh', 'experience' => '3–5 Years Experience', 'mode' => 'On-site', 'deadline' => 'August 01, 2026', 'code' => 'RIV-CAR-004',
			'excerpt' => 'Oversee construction activities and ensure quality and safety standards.',
			'content' => 'Work alongside project teams to deliver dependable construction outcomes. You will monitor site activities, coordinate technical documentation and uphold our standards for quality, safety and responsible development.',
			'responsibilities' => "Review drawings, specifications and construction plans.\nSupervise site activities and contractor progress.\nCoordinate inspections, materials and technical approvals.\nMaintain quality, safety and compliance records.\nReport progress, risks and corrective actions to project leadership.",
			'requirements' => "Bachelor's degree in Civil Engineering.\n3–5 years of experience in building or infrastructure projects.\nKnowledge of Bangladesh building codes and site practices.\nStrong documentation and coordination skills.\nWillingness to work across project sites when needed.",
		),
		array(
			'slug' => 'hr-business-partner', 'title' => 'HR Business Partner', 'department' => 'People & Culture', 'type' => 'Full Time', 'location' => 'Dhaka, Bangladesh', 'experience' => '3+ Years Experience', 'mode' => 'Hybrid', 'deadline' => 'August 10, 2026', 'code' => 'RIV-CAR-005',
			'excerpt' => 'Partner with teams to foster a high-performance and engaged culture.',
			'content' => 'Build the people practices that help RIVROSS grow responsibly. You will partner with leaders and teams on talent, performance, employee experience and a culture grounded in our values.',
			'responsibilities' => "Advise managers on people planning and employee relations.\nLead hiring, onboarding and performance cycles.\nDevelop learning and engagement initiatives.\nMaintain clear HR policies and people data.\nSupport a respectful, inclusive employee experience.",
			'requirements' => "Bachelor's degree in Human Resources, Business or a related field.\n3+ years of progressive HR experience.\nStrong relationship-building and communication skills.\nWorking knowledge of employment practices and HR systems.\nDiscretion, empathy and sound judgement.",
		),
		array(
			'slug' => 'business-development-manager', 'title' => 'Business Development Manager', 'department' => 'Business Development', 'type' => 'Full Time', 'location' => 'Dhaka, Bangladesh', 'experience' => '5+ Years Experience', 'mode' => 'On-site', 'deadline' => 'August 15, 2026', 'code' => 'RIV-CAR-006',
			'excerpt' => 'Identify new business opportunities and build strong client relationships.',
			'content' => 'Grow RIVROSS through thoughtful partnerships and a clear understanding of client needs. You will build a strong pipeline across real estate, travel, tea and future ventures.',
			'responsibilities' => "Research markets, sectors and prospective partners.\nBuild and maintain a qualified business pipeline.\nLead proposals, presentations and commercial negotiations.\nCoordinate with delivery teams to shape client solutions.\nTrack partnerships, forecasts and growth opportunities.",
			'requirements' => "Bachelor's degree in Business, Marketing or a related field.\n5+ years of business development or consultative sales experience.\nA proven record of building long-term client relationships.\nConfident presentation and negotiation skills.\nCommercial curiosity and disciplined follow-through.",
		),
	);
	foreach ( $jobs as $job ) {
		$existing = get_page_by_path( $job['slug'], OBJECT, 'rivross_job' );
		if ( $existing ) {
			continue;
		}
		$post_id = wp_insert_post( array( 'post_type' => 'rivross_job', 'post_status' => 'publish', 'post_title' => $job['title'], 'post_name' => $job['slug'], 'post_excerpt' => $job['excerpt'], 'post_content' => $job['content'] ) );
		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}
		wp_set_object_terms( $post_id, $job['department'], 'rivross_job_department' );
		$meta = array( 'department' => $job['department'], 'employment_type' => $job['type'], 'location' => $job['location'], 'experience' => $job['experience'], 'work_mode' => $job['mode'], 'deadline' => $job['deadline'], 'job_code' => $job['code'], 'hero_image' => $hero, 'application_email' => 'rivrossgroup@gmail.com', 'responsibilities' => $job['responsibilities'], 'requirements' => $job['requirements'] );
		foreach ( $meta as $key => $value ) {
			update_post_meta( $post_id, '_rivross_job_' . $key, $value );
		}
	}
	update_option( 'rivross_jobs_seeded', 1 );
}
add_action( 'init', 'rivross_seed_jobs', 30 );

/** Flush the careers job routes after a theme activation. */
function rivross_flush_job_rewrites() {
	rivross_register_job_content();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'rivross_flush_job_rewrites' );
