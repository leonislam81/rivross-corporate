<?php
/**
 * RIVROSS design system controls.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rivross_sanitize_font_choice( $value ) {
	$allowed = array( 'Montserrat', 'Inter', 'Playfair Display', 'Cormorant Garamond' );
	return in_array( $value, $allowed, true ) ? $value : 'Montserrat';
}

/**
 * Keep typography controls within practical, readable ranges.
 *
 * @param mixed $value Submitted customizer value.
 * @return float
 */
function rivross_sanitize_font_size( $value ) {
	$value = is_numeric( $value ) ? (float) $value : 16;
	return min( 96, max( 8, $value ) );
}

/**
 * Keep line-height controls within a readable range.
 *
 * @param mixed $value Submitted customizer value.
 * @return float
 */
function rivross_sanitize_line_height( $value ) {
	$value = is_numeric( $value ) ? (float) $value : 1.65;
	return min( 3, max( 1, $value ) );
}

/**
 * Return the icon names supported by the theme's inline icon library.
 *
 * @return array<string,string>
 */
function rivross_icon_choices() {
	return array(
		'building'  => __( 'Building', 'rivross-corporate' ),
		'eye'       => __( 'Eye', 'rivross-corporate' ),
		'target'    => __( 'Target', 'rivross-corporate' ),
		'flag'      => __( 'Flag', 'rivross-corporate' ),
		'users'     => __( 'Users', 'rivross-corporate' ),
		'handshake' => __( 'Handshake', 'rivross-corporate' ),
		'chart'     => __( 'Growth chart', 'rivross-corporate' ),
		'shield'    => __( 'Shield', 'rivross-corporate' ),
		'plane'     => __( 'Plane', 'rivross-corporate' ),
		'leaf'      => __( 'Leaf', 'rivross-corporate' ),
		'award'     => __( 'Award', 'rivross-corporate' ),
		'gear'      => __( 'Gear', 'rivross-corporate' ),
		'headset'   => __( 'Headset', 'rivross-corporate' ),
		'sprout'    => __( 'Sprout', 'rivross-corporate' ),
		'hotel'     => __( 'Hotel', 'rivross-corporate' ),
		'suitcase'  => __( 'Suitcase', 'rivross-corporate' ),
		'kaaba'     => __( 'Kaaba', 'rivross-corporate' ),
		'briefcase' => __( 'Briefcase', 'rivross-corporate' ),
		'globe'     => __( 'Globe', 'rivross-corporate' ),
		'phone'     => __( 'Phone', 'rivross-corporate' ),
		'mail'      => __( 'Mail', 'rivross-corporate' ),
		'pin'       => __( 'Location pin', 'rivross-corporate' ),
		'clock'     => __( 'Clock', 'rivross-corporate' ),
		'download'  => __( 'Download', 'rivross-corporate' ),
		'check'     => __( 'Check mark', 'rivross-corporate' ),
		'grid'      => __( 'Grid', 'rivross-corporate' ),
		'folder'    => __( 'Folder', 'rivross-corporate' ),
		'calendar'  => __( 'Calendar', 'rivross-corporate' ),
		'search'    => __( 'Search', 'rivross-corporate' ),
		'news'      => __( 'News', 'rivross-corporate' ),
		'lightbulb' => __( 'Lightbulb', 'rivross-corporate' ),
		'microphone' => __( 'Microphone', 'rivross-corporate' ),
		'heart'     => __( 'Heart', 'rivross-corporate' ),
		'bed'       => __( 'Bed', 'rivross-corporate' ),
		'bath'      => __( 'Bath', 'rivross-corporate' ),
		'car'       => __( 'Car', 'rivross-corporate' ),
		'ruler'     => __( 'Ruler', 'rivross-corporate' ),
		'money'     => __( 'Money', 'rivross-corporate' ),
		'map'       => __( 'Map', 'rivross-corporate' ),
		'image'     => __( 'Image', 'rivross-corporate' ),
		'file'      => __( 'File', 'rivross-corporate' ),
	);
}

/**
 * Sanitize an icon name selected in the Customizer.
 *
 * @param mixed $value Submitted icon name.
 * @return string
 */
function rivross_sanitize_icon_choice( $value ) {
	$choices = rivross_icon_choices();
	return isset( $choices[ $value ] ) ? $value : 'building';
}

/**
 * Give every Customizer field a short, practical editing hint.
 *
 * Keeping these hints in one place makes the large page settings panel easier
 * to use without forcing every page template to duplicate help copy.
 *
 * @param string $setting_id Setting ID.
 * @param string $type       Control type.
 * @return string
 */
function rivross_customizer_field_description( $setting_id, $type ) {
	$setting_id = (string) $setting_id;

	if ( 'image' === $type ) {
		return __( 'Choose an existing image from the Media Library or upload a new one. Use a clear, landscape image for banners.', 'rivross-corporate' );
	}

	if ( 'url' === $type ) {
		return __( 'Use a full link such as https://example.com/page/ or a local path such as /contact-us/.', 'rivross-corporate' );
	}

	if ( 'email' === $type ) {
		return __( 'Use a valid email address. It will be used for contact links and form notifications.', 'rivross-corporate' );
	}

	if ( 'number' === $type ) {
		return __( 'Enter a value within the range shown below the field.', 'rivross-corporate' );
	}

	if ( 'checkbox' === $type ) {
		return __( 'Turn this option on or off. The preview updates after you publish.', 'rivross-corporate' );
	}

	if ( 'select' === $type && false !== strpos( $setting_id, '_icon' ) ) {
		return __( 'Choose an icon from the list. Keep icon styles consistent within a section.', 'rivross-corporate' );
	}

	if ( 'select' === $type && false !== strpos( $setting_id, 'carousel' ) ) {
		return __( 'Choose how this carousel behaves at this screen size.', 'rivross-corporate' );
	}

	if ( 'select' === $type ) {
		return __( 'Choose one option from the list.', 'rivross-corporate' );
	}

	if ( 'textarea' === $type ) {
		return __( 'Keep the copy concise and easy to scan. Line breaks are supported.', 'rivross-corporate' );
	}

	/* Give long, repeated content fields a useful hint without adding noise to
	 * the one-off controls that already have their own descriptions. */
	if ( false !== strpos( $setting_id, '_label' ) ) {
		return __( 'Short text shown inside a button, link or label.', 'rivross-corporate' );
	}

	return __( 'This text appears on the public website.', 'rivross-corporate' );
}

/**
 * Active callbacks keep related controls visible only when they apply.
 *
 * @return bool
 */
function rivross_customizer_is_under_construction() {
	return 'under-construction' === get_theme_mod( 'rivross_maintenance_variant', 'under-construction' );
}

/**
 * @return bool
 */
function rivross_customizer_is_coming_soon() {
	return 'coming-soon' === get_theme_mod( 'rivross_maintenance_variant', 'under-construction' );
}

/**
 * @return bool
 */
function rivross_customizer_hero_carousel_enabled() {
	return (bool) get_theme_mod( 'rivross_home_hero_carousel_enabled', true );
}

/**
 * @return bool
 */
function rivross_customizer_leadership_carousel_enabled() {
	return (bool) get_theme_mod( 'rivross_home_leadership_carousel_enabled', true );
}

/**
 * @return bool
 */
function rivross_customizer_partners_carousel_enabled() {
	return (bool) get_theme_mod( 'rivross_home_partners_carousel_enabled', true );
}

/**
 * Sanitize the ordered list of partner logo URLs selected in the gallery control.
 *
 * @param mixed $value Submitted JSON or array of image URLs.
 * @return string
 */
function rivross_sanitize_partner_logo_gallery( $value ) {
	if ( is_string( $value ) ) {
		$value = json_decode( wp_unslash( $value ), true );
	}
	if ( ! is_array( $value ) ) {
		return '[]';
	}

	$logos = array();
	foreach ( $value as $logo ) {
		if ( is_array( $logo ) && isset( $logo['url'] ) ) {
			$logo = $logo['url'];
		}
		$logo = esc_url_raw( (string) $logo );
		if ( '' !== $logo && ! in_array( $logo, $logos, true ) ) {
			$logos[] = $logo;
		}
		if ( count( $logos ) >= 8 ) {
			break;
		}
	}

	return wp_json_encode( $logos );
}

/**
 * Keep the homepage news feed compact and performant.
 *
 * @param mixed $value Submitted item count.
 * @return int
 */
function rivross_sanitize_news_count( $value ) {
	return min( 12, max( 1, absint( $value ) ) );
}

/**
 * Register a standard text, textarea, URL, select or image setting/control.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @param string               $setting_id Setting ID.
 * @param mixed                $default Default value.
 * @param string               $label Control label.
 * @param string               $section Section ID.
 * @param string               $type Control type.
 * @param callable|string      $sanitize Sanitization callback.
 * @param array                $extra Optional control arguments.
 * @return void
 */
function rivross_add_theme_control( $wp_customize, $setting_id, $default, $label, $section, $type = 'text', $sanitize = 'sanitize_text_field', $extra = array() ) {
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		)
	);

	$control_args = array_merge(
		array(
			'label'   => $label,
			'section' => $section,
			'type'    => $type,
		),
		$extra
	);

	if ( ! isset( $control_args['description'] ) || '' === trim( (string) $control_args['description'] ) ) {
		$control_args['description'] = rivross_customizer_field_description( $setting_id, $type );
	}

	$default_input_attrs = array();
	if ( 'textarea' === $type ) {
		$default_input_attrs = array( 'rows' => 4 );
	} elseif ( 'url' === $type ) {
		$default_input_attrs = array( 'placeholder' => 'https://example.com/page/' );
	} elseif ( 'email' === $type ) {
		$default_input_attrs = array( 'placeholder' => 'name@example.com' );
	}
	if ( ! empty( $default_input_attrs ) ) {
		$control_args['input_attrs'] = array_merge( $default_input_attrs, isset( $control_args['input_attrs'] ) ? (array) $control_args['input_attrs'] : array() );
	}

	if ( 'image' === $type && ! isset( $control_args['button_labels'] ) ) {
		$control_args['button_labels'] = array(
			'select'  => __( 'Choose image', 'rivross-corporate' ),
			'change'  => __( 'Replace image', 'rivross-corporate' ),
			'remove'  => __( 'Remove image', 'rivross-corporate' ),
			'default' => __( 'Use default image', 'rivross-corporate' ),
		);
	}

	if ( 'rivross_partner_gallery' === $type ) {
		$wp_customize->add_control( new Rivross_Partner_Gallery_Control( $wp_customize, $setting_id, $control_args ) );
	} elseif ( 'image' === $type ) {
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting_id, $control_args ) );
	} else {
		$wp_customize->add_control( $setting_id, $control_args );
	}
}

/**
 * Customizer control for selecting an ordered batch of partner logos.
 */
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Rivross_Partner_Gallery_Control' ) ) {
	class Rivross_Partner_Gallery_Control extends WP_Customize_Control {
		/**
		 * Control type used by the Customizer pane.
		 *
		 * @var string
		 */
		public $type = 'rivross-partner-gallery';

		/**
		 * Render the bulk logo picker markup.
		 *
		 * @return void
		 */
		public function render_content() {
			$value = (string) $this->value();
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php if ( $this->description ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>
			<div class="rivross-partner-gallery" data-setting-id="<?php echo esc_attr( $this->id ); ?>" data-max="8">
				<input class="rivross-partner-gallery__value" type="hidden" value="<?php echo esc_attr( $value ); ?>" <?php $this->link(); ?> />
				<div class="rivross-partner-gallery__actions">
					<button class="button button-primary rivross-partner-gallery__choose" type="button"><?php esc_html_e( 'Choose logo images', 'rivross-corporate' ); ?></button>
					<button class="button rivross-partner-gallery__clear" type="button" hidden><?php esc_html_e( 'Clear all', 'rivross-corporate' ); ?></button>
				</div>
				<p class="rivross-partner-gallery__hint"><?php esc_html_e( 'Select multiple images at once. They are placed in the same order as selected, from Partner 1 onward. Up to 8 logos are supported.', 'rivross-corporate' ); ?></p>
				<p class="rivross-partner-gallery__status" role="status" aria-live="polite"></p>
				<ol class="rivross-partner-gallery__previews" aria-label="<?php esc_attr_e( 'Selected partner logos', 'rivross-corporate' ); ?>"></ol>
			</div>
			<?php
		}
	}
}

function rivross_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'rivross_theme_settings',
		array(
			'title'       => __( 'RIVROSS Theme Settings', 'rivross-corporate' ),
			'description' => __( 'Edit the website from one place. Open Page Settings to choose a page, then update its content, images, links and display options. For projects, properties, events, jobs and leadership profiles, use the matching Dashboard menu.', 'rivross-corporate' ),
			'priority'    => 30,
		)
	);

	$wp_customize->add_section(
		'rivross_site_access',
		array(
			'title'       => __( 'Site Access & Launch Mode', 'rivross-corporate' ),
			'description' => __( 'Temporarily show a branded Under Construction or Coming Soon screen to public visitors. Edit each screen\'s copy below. Administrators keep full access to the website and dashboard.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 5,
		)
	);
	rivross_add_theme_control( $wp_customize, 'rivross_maintenance_enabled', false, __( 'Enable restricted site mode', 'rivross-corporate' ), 'rivross_site_access', 'checkbox', 'absint' );
	rivross_add_theme_control(
		$wp_customize,
		'rivross_maintenance_variant',
		'under-construction',
		__( 'Public screen style', 'rivross-corporate' ),
		'rivross_site_access',
		'select',
		'rivross_sanitize_maintenance_variant',
		array(
			'choices' => array(
				'under-construction' => __( 'Under Construction', 'rivross-corporate' ),
				'coming-soon'       => __( 'Coming Soon', 'rivross-corporate' ),
			),
		)
	);

	$maintenance_copy_fields = array(
		'rivross_maintenance_uc_status'        => array( 'Under Construction', __( 'Under Construction Status Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_uc_eyebrow'       => array( 'RIVROSS Company Limited', __( 'Under Construction Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_uc_heading_1'      => array( 'Under', __( 'Under Construction Heading 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_uc_heading_2'      => array( 'Construction', __( 'Under Construction Heading 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_uc_description'   => array( 'We’re building something exceptional. Our new website is coming soon. Please check back shortly.', __( 'Under Construction Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_maintenance_uc_progress_label' => array( 'Site Progress', __( 'Progress Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_uc_progress'      => array( 75, __( 'Progress Percentage', 'rivross-corporate' ), 'number', 'rivross_sanitize_maintenance_percentage' ),
		'rivross_maintenance_uc_launch_label'  => array( 'Launching Soon', __( 'Launch Note', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_uc_button_label'  => array( 'Back to Home', __( 'Contact Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_status'        => array( 'Coming Soon', __( 'Coming Soon Status Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_eyebrow'       => array( 'We’re preparing something exceptional.', __( 'Coming Soon Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_heading_1'      => array( 'Coming', __( 'Coming Soon Heading 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_heading_2'      => array( 'Soon', __( 'Coming Soon Heading 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_description'   => array( 'Our new website is almost ready. Please check back soon.', __( 'Coming Soon Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_maintenance_cs_days'          => array( '00', __( 'Countdown Days', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_days_label'    => array( 'Days', __( 'Countdown Days Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_hours'         => array( '00', __( 'Countdown Hours', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_hours_label'   => array( 'Hours', __( 'Countdown Hours Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_minutes'       => array( '00', __( 'Countdown Minutes', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_minutes_label' => array( 'Minutes', __( 'Countdown Minutes Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_seconds'       => array( '00', __( 'Countdown Seconds', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_seconds_label' => array( 'Seconds', __( 'Countdown Seconds Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_notify_label'  => array( 'Contact us to receive launch updates', __( 'Notify Message', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_maintenance_cs_button_label'  => array( 'Back to Home', __( 'Coming Soon Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
	);

	foreach ( $maintenance_copy_fields as $setting_id => $field ) {
		$active_callback = false !== strpos( $setting_id, '_uc_' ) ? 'rivross_customizer_is_under_construction' : 'rivross_customizer_is_coming_soon';
		$extra = array( 'active_callback' => $active_callback );
		if ( 'rivross_maintenance_uc_progress' === $setting_id ) {
			$extra['input_attrs'] = array( 'min' => 0, 'max' => 100, 'step' => 1 );
		}
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_site_access', $field[2], $field[3], $extra );
	}

	$wp_customize->add_section(
		'rivross_home_page',
		array(
			'title'       => __( 'Hero & General', 'rivross-corporate' ),
			'description' => __( 'Set fallback hero content and carousel behavior for the homepage. Manage individual slides from Dashboard → Hero Slides.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 10,
		)
	);

	$home_fields = array(
		'rivross_home_hero_kicker'        => array( 'RIVROSS Company Limited', __( 'Hero Kicker', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_hero_line_1'        => array( 'Building Businesses.', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_hero_line_2'        => array( 'Creating Opportunities.', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_hero_description'  => array( 'RIVROSS Company Limited is a diversified business organization operating across Real Estate, Travel & Tourism, Tea Business and future business ventures.', __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_home_hero_primary_label' => array( 'Explore Our Businesses', __( 'Primary Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_hero_secondary_label' => array( 'Contact Us', __( 'Secondary Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
	);

	foreach ( $home_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_home_page', $field[2], $field[3] );
	}

	$home_media_fields = array(
		'rivross_home_hero_image'        => array( get_theme_file_uri( '/assets/images/home/hero-city.png' ), __( 'Hero Background Image', 'rivross-corporate' ) ),
		'rivross_home_hero_primary_url'  => array( '#businesses', __( 'Primary Button URL', 'rivross-corporate' ) ),
		'rivross_home_hero_secondary_url' => array( '#contact', __( 'Secondary Button URL', 'rivross-corporate' ) ),
	);

	foreach ( $home_media_fields as $setting_id => $field ) {
		$type     = 'rivross_home_hero_image' === $setting_id ? 'image' : 'url';
		$sanitize = 'rivross_home_hero_image' === $setting_id ? 'esc_url_raw' : 'esc_url_raw';
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_home_page', $type, $sanitize );
	}

	$hero_carousel_fields = array(
		'rivross_home_hero_carousel_enabled' => array( true, __( 'Enable Hero Carousel', 'rivross-corporate' ) ),
		'rivross_home_hero_carousel_autoplay' => array( true, __( 'Autoplay Hero Slides', 'rivross-corporate' ) ),
		'rivross_home_hero_carousel_arrows'  => array( false, __( 'Show Hero Previous / Next Arrows', 'rivross-corporate' ) ),
		'rivross_home_hero_carousel_dots'    => array( true, __( 'Show Hero Slide Dots', 'rivross-corporate' ) ),
	);

	foreach ( $hero_carousel_fields as $setting_id => $field ) {
		$extra = 'rivross_home_hero_carousel_enabled' !== $setting_id ? array( 'active_callback' => 'rivross_customizer_hero_carousel_enabled' ) : array();
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_home_page', 'checkbox', 'absint', $extra );
	}

	rivross_add_theme_control(
		$wp_customize,
		'rivross_home_hero_carousel_interval',
		6000,
		__( 'Hero Autoplay Interval (milliseconds)', 'rivross-corporate' ),
		'rivross_home_page',
		'number',
		'absint',
		array(
			'input_attrs' => array(
				'min'  => 2500,
				'max'  => 15000,
				'step' => 500,
			),
			'active_callback' => 'rivross_customizer_hero_carousel_enabled',
			'description' => __( 'Use 2500–15000 milliseconds. Autoplay also pauses while the hero is hovered or focused.', 'rivross-corporate' ),
		)
	);

	$wp_customize->add_section(
		'rivross_home_about',
		array(
			'title'       => __( 'Home — About & Strengths', 'rivross-corporate' ),
			'description' => __( 'Edit the About RIVROSS introduction and each strength item, including its icon.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 15,
		)
	);

	$about_fields = array(
		'rivross_home_about_eyebrow'     => array( 'Who We Are', __( 'About Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_about_title'       => array( 'About RIVROSS', __( 'About Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_about_description' => array( 'RIVROSS Company Limited is a dynamic and forward-thinking organization committed to delivering value through multiple business sectors. Our goal is to create sustainable growth, professional service and long-term partnerships.', __( 'About Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_home_about_button_label' => array( 'Read More About Us', __( 'About Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_about_button_url'   => array( '#about', __( 'About Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
	);

	foreach ( $about_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_home_about', $field[2], $field[3] );
	}

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
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_home_strength_' . $number . '_icon', $strength[0], sprintf( __( 'Strength %d Icon', 'rivross-corporate' ), $number ), 'rivross_home_about', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_home_strength_' . $number . '_title', $strength[1], sprintf( __( 'Strength %d Title', 'rivross-corporate' ), $number ), 'rivross_home_about' );
		rivross_add_theme_control( $wp_customize, 'rivross_home_strength_' . $number . '_description', $strength[2], sprintf( __( 'Strength %d Description', 'rivross-corporate' ), $number ), 'rivross_home_about', 'textarea', 'sanitize_textarea_field' );
	}

	$wp_customize->add_section(
		'rivross_home_businesses',
		array(
			'title'       => __( 'Home — Business Verticals', 'rivross-corporate' ),
			'description' => __( 'Edit the three business cards, including their images, icons, copy and links.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 20,
		)
	);

	rivross_add_theme_control( $wp_customize, 'rivross_home_businesses_eyebrow', 'Our Core Businesses', __( 'Section Eyebrow', 'rivross-corporate' ), 'rivross_home_businesses' );
	rivross_add_theme_control( $wp_customize, 'rivross_home_businesses_title', 'Our Business Verticals', __( 'Section Title', 'rivross-corporate' ), 'rivross_home_businesses' );

	$business_defaults = array(
		array( 'business-real-estate.png', 'building', 'Real Estate', 'Property development, sales, investment opportunities and project marketing.', 'Explore Real Estate', home_url( '/real-estate/' ) ),
		array( 'business-travel.png', 'plane', 'Travel & Tourism', 'Air ticketing, hotel booking, tour packages, Hajj & Umrah and corporate travel services.', 'Explore Travel', home_url( '/travel-tourism/' ) ),
		array( 'business-tea.png', 'leaf', 'Tea Business', 'Tea supply, wholesale, distribution and supply across Bangladesh.', 'Explore Tea Business', home_url( '/tea-business/' ) ),
	);

	foreach ( $business_defaults as $index => $business ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_home_business_' . $number . '_image', get_theme_file_uri( '/assets/images/home/' . $business[0] ), sprintf( __( 'Business %d Image', 'rivross-corporate' ), $number ), 'rivross_home_businesses', 'image', 'esc_url_raw' );
		rivross_add_theme_control( $wp_customize, 'rivross_home_business_' . $number . '_icon', $business[1], sprintf( __( 'Business %d Icon', 'rivross-corporate' ), $number ), 'rivross_home_businesses', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_home_business_' . $number . '_title', $business[2], sprintf( __( 'Business %d Title', 'rivross-corporate' ), $number ), 'rivross_home_businesses' );
		rivross_add_theme_control( $wp_customize, 'rivross_home_business_' . $number . '_description', $business[3], sprintf( __( 'Business %d Description', 'rivross-corporate' ), $number ), 'rivross_home_businesses', 'textarea', 'sanitize_textarea_field' );
		rivross_add_theme_control( $wp_customize, 'rivross_home_business_' . $number . '_button_label', $business[4], sprintf( __( 'Business %d Button Label', 'rivross-corporate' ), $number ), 'rivross_home_businesses' );
		rivross_add_theme_control( $wp_customize, 'rivross_home_business_' . $number . '_button_url', $business[5], sprintf( __( 'Business %d Button URL', 'rivross-corporate' ), $number ), 'rivross_home_businesses', 'url', 'esc_url_raw' );
	}

	$wp_customize->add_section(
		'rivross_home_services',
		array(
			'title'       => __( 'Home — Why RIVROSS & Services', 'rivross-corporate' ),
			'description' => __( 'Edit the Why Choose RIVROSS items and the six travel service tiles, including their icons and links.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 30,
		)
	);

	rivross_add_theme_control( $wp_customize, 'rivross_home_why_eyebrow', 'Why Choose RIVROSS?', __( 'Why Section Heading', 'rivross-corporate' ), 'rivross_home_services' );

	$why_defaults = array(
		array( 'award', 'Professional Management' ),
		array( 'gear', 'Quality Services' ),
		array( 'shield', 'Customer Satisfaction' ),
		array( 'headset', 'Reliable Support' ),
		array( 'sprout', 'Sustainable Growth' ),
	);

	foreach ( $why_defaults as $index => $why ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_home_why_' . $number . '_icon', $why[0], sprintf( __( 'Why Item %d Icon', 'rivross-corporate' ), $number ), 'rivross_home_services', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_home_why_' . $number . '_label', $why[1], sprintf( __( 'Why Item %d Label', 'rivross-corporate' ), $number ), 'rivross_home_services' );
	}

	$service_defaults = array(
		array( 'plane', 'Air Ticket', '#travel' ),
		array( 'hotel', 'Hotel Booking', '#travel' ),
		array( 'suitcase', 'Tour Packages', '#travel' ),
		array( 'kaaba', 'Hajj & Umrah', '#travel' ),
		array( 'briefcase', 'Corporate Travel', '#travel' ),
		array( 'globe', 'Visa Assistance', '#travel' ),
	);

	rivross_add_theme_control( $wp_customize, 'rivross_home_services_title', 'Travel Services', __( 'Services Section Title', 'rivross-corporate' ), 'rivross_home_services' );
	rivross_add_theme_control( $wp_customize, 'rivross_home_services_view_all_label', 'View All Services', __( 'Services View-All Label', 'rivross-corporate' ), 'rivross_home_services' );
	rivross_add_theme_control( $wp_customize, 'rivross_home_services_view_all_url', '#travel', __( 'Services View-All URL', 'rivross-corporate' ), 'rivross_home_services', 'url', 'esc_url_raw' );

	foreach ( $service_defaults as $index => $service ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_home_service_' . $number . '_icon', $service[0], sprintf( __( 'Service %d Icon', 'rivross-corporate' ), $number ), 'rivross_home_services', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_home_service_' . $number . '_label', $service[1], sprintf( __( 'Service %d Label', 'rivross-corporate' ), $number ), 'rivross_home_services' );
		rivross_add_theme_control( $wp_customize, 'rivross_home_service_' . $number . '_url', $service[2], sprintf( __( 'Service %d URL', 'rivross-corporate' ), $number ), 'rivross_home_services', 'url', 'esc_url_raw' );
	}

	$wp_customize->add_section(
		'rivross_home_showcase',
		array(
			'title'       => __( 'Home — Showcase & Partners', 'rivross-corporate' ),
		'description' => __( 'Edit the showcase headings and view-all links. Five polished demo logos are added to the Media Library automatically; replace them with your official partner images from the Media Library. Empty slots stay hidden. Property and project cards automatically show the latest published entries from their dashboards.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 40,
		)
	);

	$showcase_fields = array(
		'rivross_home_properties_title'       => array( 'Featured Properties', __( 'Properties Section Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_properties_view_all_label' => array( 'View All Properties', __( 'Properties View-All Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
	'rivross_home_properties_view_all_url' => array( home_url( '/real-estate/' ), __( 'Properties View-All URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_home_projects_title'          => array( 'Our Projects', __( 'Projects Section Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_projects_view_all_label' => array( 'View All Projects', __( 'Projects View-All Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
	'rivross_home_projects_view_all_url'   => array( home_url( '/projects/' ), __( 'Projects View-All URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_home_partners_title'          => array( 'Our Partners', __( 'Partners Section Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
	);

	foreach ( $showcase_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_home_showcase', $field[2], $field[3] );
	}

	/* Partner logos are selected from the Media Library. The first five slots
	 * start with bundled demo marks and can be replaced with official logos. */
	$partner_logo_defaults = rivross_get_partner_logo_default_urls();
	rivross_add_theme_control(
		$wp_customize,
		'rivross_home_partner_logo_gallery',
		wp_json_encode( array_values( $partner_logo_defaults ) ),
		__( 'Partner Logos — Bulk Upload', 'rivross-corporate' ),
		'rivross_home_showcase',
		'rivross_partner_gallery',
		'rivross_sanitize_partner_logo_gallery',
		array(
			'description' => __( 'Choose multiple logo images in one gallery action. The selected order becomes Partner 1, Partner 2, Partner 3 and so on. Five demo marks are already available in the Media Library and ready to replace.', 'rivross-corporate' ),
			'priority'    => 20,
		)
	);

	$partner_carousel_fields = array(
		'rivross_home_partners_carousel_enabled'  => array( true, __( 'Enable Partners Logo Carousel', 'rivross-corporate' ), 'checkbox', 'absint' ),
		'rivross_home_partners_carousel_autoplay' => array( true, __( 'Autoplay Partners Carousel', 'rivross-corporate' ), 'checkbox', 'absint' ),
		'rivross_home_partners_carousel_arrows'   => array( false, __( 'Show Partners Previous / Next Arrows', 'rivross-corporate' ), 'checkbox', 'absint' ),
		'rivross_home_partners_carousel_dots'     => array( true, __( 'Show Partners Carousel Dots', 'rivross-corporate' ), 'checkbox', 'absint' ),
	);
	foreach ( $partner_carousel_fields as $setting_id => $field ) {
		$extra = 'rivross_home_partners_carousel_enabled' !== $setting_id ? array( 'active_callback' => 'rivross_customizer_partners_carousel_enabled' ) : array();
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_home_showcase', $field[2], $field[3], $extra );
	}
	rivross_add_theme_control(
		$wp_customize,
		'rivross_home_partners_carousel_interval',
		5000,
		__( 'Partners Carousel Interval (ms)', 'rivross-corporate' ),
		'rivross_home_showcase',
		'number',
		'absint',
		array(
			'active_callback' => 'rivross_customizer_partners_carousel_enabled',
			'input_attrs'     => array( 'min' => 2000, 'max' => 15000, 'step' => 500 ),
		)
	);
		rivross_add_theme_control(
		$wp_customize,
		'rivross_home_partners_carousel_desktop',
		4,
		__( 'Partner Logos on Desktop', 'rivross-corporate' ),
		'rivross_home_showcase',
		'select',
		'absint',
		array(
			'choices'         => array( 1 => '1 logo', 2 => '2 logos', 3 => '3 logos', 4 => '4 logos', 5 => '5 logos' ),
			'active_callback' => 'rivross_customizer_partners_carousel_enabled',
		)
	);
	rivross_add_theme_control(
		$wp_customize,
		'rivross_home_partners_carousel_tablet',
		3,
		__( 'Partner Logos on Tablet', 'rivross-corporate' ),
		'rivross_home_showcase',
		'select',
		'absint',
		array(
			'choices'         => array( 1 => '1 logo', 2 => '2 logos', 3 => '3 logos' ),
			'active_callback' => 'rivross_customizer_partners_carousel_enabled',
		)
	);
	rivross_add_theme_control(
		$wp_customize,
		'rivross_home_partners_carousel_mobile',
		2,
		__( 'Partner Logos on Mobile', 'rivross-corporate' ),
		'rivross_home_showcase',
		'select',
		'absint',
		array(
			'choices'         => array( 1 => '1 logo', 2 => '2 logos' ),
			'active_callback' => 'rivross_customizer_partners_carousel_enabled',
		)
	);

	$wp_customize->add_section(
		'rivross_home_leadership',
		array(
			'title'       => __( 'Home — News & Leadership', 'rivross-corporate' ),
			'description' => __( 'Edit the news heading, item count, category filter and leadership carousel behavior here. News articles are managed from Dashboard → Posts and leader profiles from Dashboard → Leadership.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 50,
		)
	);

	$news_leadership_fields = array(
		'rivross_home_news_title'          => array( 'Latest News & Updates', __( 'News Section Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_news_view_all_label' => array( 'View All News', __( 'News View-All Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_news_view_all_url'   => array( home_url( '/news-media/' ), __( 'News View-All URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_home_news_read_more_label' => array( 'Read More', __( 'News Read-More Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_news_count'           => array( 3, __( 'Number of News Items', 'rivross-corporate' ), 'number', 'rivross_sanitize_news_count' ),
		'rivross_home_leadership_title'    => array( 'Our Leadership', __( 'Leadership Section Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_leadership_view_all_label' => array( 'View All Members', __( 'Leadership View-All Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_home_leadership_view_all_url'   => array( home_url( '/management/' ), __( 'Leadership View-All URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
	);

	foreach ( $news_leadership_fields as $setting_id => $field ) {
		$extra = 'rivross_home_news_count' === $setting_id ? array( 'input_attrs' => array( 'min' => 1, 'max' => 12, 'step' => 1 ) ) : array();
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_home_leadership', $field[2], $field[3], $extra );
	}
	$home_news_category_choices = array( '' => __( 'All categories', 'rivross-corporate' ) );
	foreach ( get_categories( array( 'hide_empty' => false ) ) as $home_news_category_term ) {
		$home_news_category_choices[ $home_news_category_term->slug ] = $home_news_category_term->name;
	}
	rivross_add_theme_control( $wp_customize, 'rivross_home_news_category', '', __( 'News Category Filter', 'rivross-corporate' ), 'rivross_home_leadership', 'select', 'sanitize_title', array( 'choices' => $home_news_category_choices ) );

	/* The profiles themselves are managed as Leadership entries. These controls only shape the carousel presentation. */
	rivross_add_theme_control( $wp_customize, 'rivross_home_leadership_carousel_enabled', true, __( 'Enable Leadership Carousel', 'rivross-corporate' ), 'rivross_home_leadership', 'checkbox', 'absint' );
	rivross_add_theme_control( $wp_customize, 'rivross_home_leadership_carousel_autoplay', true, __( 'Autoplay Carousel', 'rivross-corporate' ), 'rivross_home_leadership', 'checkbox', 'absint', array( 'active_callback' => 'rivross_customizer_leadership_carousel_enabled' ) );
	rivross_add_theme_control(
		$wp_customize,
		'rivross_home_leadership_carousel_interval',
		5000,
		__( 'Autoplay Interval (milliseconds)', 'rivross-corporate' ),
		'rivross_home_leadership',
		'number',
		'absint',
		array(
			'input_attrs' => array(
				'min'  => 2000,
				'max'  => 15000,
				'step' => 500,
			),
			'active_callback' => 'rivross_customizer_leadership_carousel_enabled',
			'description' => __( 'Use 2000–15000 milliseconds. Autoplay pauses while a visitor hovers or focuses the carousel.', 'rivross-corporate' ),
		)
	);
	rivross_add_theme_control( $wp_customize, 'rivross_home_leadership_carousel_arrows', false, __( 'Show Previous / Next Arrows', 'rivross-corporate' ), 'rivross_home_leadership', 'checkbox', 'absint', array( 'active_callback' => 'rivross_customizer_leadership_carousel_enabled' ) );
	rivross_add_theme_control( $wp_customize, 'rivross_home_leadership_carousel_dots', true, __( 'Show Carousel Dots', 'rivross-corporate' ), 'rivross_home_leadership', 'checkbox', 'absint', array( 'active_callback' => 'rivross_customizer_leadership_carousel_enabled' ) );
	rivross_add_theme_control(
		$wp_customize,
		'rivross_home_leadership_carousel_desktop',
		4,
		__( 'Cards per View — Desktop', 'rivross-corporate' ),
		'rivross_home_leadership',
		'select',
		'absint',
		array( 'choices' => array( 1 => '1 card', 2 => '2 cards', 3 => '3 cards', 4 => '4 cards' ), 'active_callback' => 'rivross_customizer_leadership_carousel_enabled' )
	);
	rivross_add_theme_control(
		$wp_customize,
		'rivross_home_leadership_carousel_tablet',
		2,
		__( 'Cards per View — Tablet', 'rivross-corporate' ),
		'rivross_home_leadership',
		'select',
		'absint',
		array( 'choices' => array( 1 => '1 card', 2 => '2 cards', 3 => '3 cards' ), 'active_callback' => 'rivross_customizer_leadership_carousel_enabled' )
	);
	rivross_add_theme_control(
		$wp_customize,
		'rivross_home_leadership_carousel_mobile',
		2,
		__( 'Cards per View — Mobile', 'rivross-corporate' ),
		'rivross_home_leadership',
		'select',
		'absint',
		array( 'choices' => array( 1 => '1 card', 2 => '2 cards' ), 'active_callback' => 'rivross_customizer_leadership_carousel_enabled' )
	);

	$wp_customize->add_section(
		'rivross_about_page',
		array(
			'title'       => __( 'About Us Page Settings', 'rivross-corporate' ),
			'description' => __( 'Control every About Us section, including copy, images and icons. Leader profiles are managed from Dashboard → Leadership.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 70,
		)
	);

	$about_page_fields = array(
		'rivross_about_hero_image'       => array( get_theme_file_uri( '/assets/images/home/hero-city.png' ), __( 'Hero Background Image', 'rivross-corporate' ), 'image', 'esc_url_raw' ),
		'rivross_about_breadcrumb_home'  => array( 'Home', __( 'Breadcrumb Home Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_about_breadcrumb_page'  => array( 'About Us', __( 'Breadcrumb Page Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_about_hero_line_1'      => array( 'About', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_about_hero_line_2'      => array( 'RIVROSS', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_about_hero_description' => array( "Driven by vision. Guided by values.\nCommitted to building a better tomorrow.", __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
	);

	foreach ( $about_page_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_about_page', $field[2], $field[3] );
	}

	$about_intro_fields = array(
		'rivross_about_intro_eyebrow'       => array( 'Who We Are', __( 'Intro Eyebrow', 'rivross-corporate' ) ),
		'rivross_about_intro_title'         => array( "Building Businesses.\nCreating Opportunities.", __( 'Intro Title', 'rivross-corporate' ) ),
		'rivross_about_intro_paragraph_1'   => array( 'RIVROSS Company Limited is a diversified business organization operating across Real Estate, Travel & Tourism, Tea Business and future business ventures.', __( 'Intro Paragraph 1', 'rivross-corporate' ) ),
		'rivross_about_intro_paragraph_2'   => array( 'Our goal is to deliver sustainable growth, professional service and long-term partnerships while creating value for our clients, partners and the communities we serve.', __( 'Intro Paragraph 2', 'rivross-corporate' ) ),
		'rivross_about_intro_button_label'  => array( 'Download Corporate Profile', __( 'Intro Button Label', 'rivross-corporate' ) ),
		'rivross_about_intro_button_url'    => array( '#contact', __( 'Intro Button URL', 'rivross-corporate' ) ),
	);

	foreach ( $about_intro_fields as $setting_id => $field ) {
		$type     = false !== strpos( $setting_id, 'paragraph' ) || 'rivross_about_intro_title' === $setting_id ? 'textarea' : ( false !== strpos( $setting_id, 'url' ) ? 'url' : 'text' );
		$sanitize = 'textarea' === $type ? 'sanitize_textarea_field' : ( 'url' === $type ? 'esc_url_raw' : 'sanitize_text_field' );
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_about_page', $type, $sanitize );
	}

	$about_pillars = array(
		array( 'eye', 'Our Vision', 'To be a leading diversified business organization recognized for excellence, innovation and sustainable growth.' ),
		array( 'target', 'Our Mission', 'To create long-term value through quality services, trusted partnerships and responsible business practices.' ),
		array( 'flag', 'Our Purpose', 'To empower people and businesses by providing opportunities that inspire growth and success.' ),
		array( 'shield', 'Our Promise', 'We are committed to professionalism, integrity and delivering value that exceeds expectations.' ),
	);

	foreach ( $about_pillars as $index => $pillar ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_about_pillar_' . $number . '_icon', $pillar[0], sprintf( __( 'Pillar %d Icon', 'rivross-corporate' ), $number ), 'rivross_about_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_about_pillar_' . $number . '_title', $pillar[1], sprintf( __( 'Pillar %d Title', 'rivross-corporate' ), $number ), 'rivross_about_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_about_pillar_' . $number . '_description', $pillar[2], sprintf( __( 'Pillar %d Description', 'rivross-corporate' ), $number ), 'rivross_about_page', 'textarea', 'sanitize_textarea_field' );
	}

	rivross_add_theme_control( $wp_customize, 'rivross_about_values_eyebrow', 'Our Core Values', __( 'Values Eyebrow', 'rivross-corporate' ), 'rivross_about_page' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_values_title', 'The Values That Define Us', __( 'Values Title', 'rivross-corporate' ), 'rivross_about_page' );

	$about_values = array(
		array( 'shield', 'Integrity', 'We uphold the highest standards of honesty and transparency.' ),
		array( 'award', 'Excellence', 'We are committed to delivering quality in everything we do.' ),
		array( 'gear', 'Innovation', 'We embrace innovation to create sustainable solutions.' ),
		array( 'users', 'Teamwork', 'We believe in the power of collaboration and shared success.' ),
		array( 'leaf', 'Responsibility', 'We act responsibly towards our stakeholders and the environment.' ),
		array( 'handshake', 'Respect', 'We value people and build relationships based on respect.' ),
	);

	foreach ( $about_values as $index => $value ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_about_value_' . $number . '_icon', $value[0], sprintf( __( 'Value %d Icon', 'rivross-corporate' ), $number ), 'rivross_about_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_about_value_' . $number . '_title', $value[1], sprintf( __( 'Value %d Title', 'rivross-corporate' ), $number ), 'rivross_about_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_about_value_' . $number . '_description', $value[2], sprintf( __( 'Value %d Description', 'rivross-corporate' ), $number ), 'rivross_about_page', 'textarea', 'sanitize_textarea_field' );
	}

	rivross_add_theme_control( $wp_customize, 'rivross_about_journey_eyebrow', 'Our Journey', __( 'Journey Eyebrow', 'rivross-corporate' ), 'rivross_about_page' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_journey_title', 'Milestones of Growth', __( 'Journey Title', 'rivross-corporate' ), 'rivross_about_page' );

	$about_journey = array(
		array( 'building', '2010', 'Foundation', 'RIVROSS Company Limited was founded with a vision to build lasting value.' ),
		array( 'handshake', '2012', 'First Partnerships', 'Established strategic partnerships and expanded our business network.' ),
		array( 'building', '2015', 'Business Expansion', 'Expanded into Real Estate and Travel & Tourism sectors.' ),
		array( 'leaf', '2018', 'Tea Business', 'Ventured into Tea Business to diversify and strengthen our portfolio.' ),
		array( 'globe', '2021', 'Regional Growth', 'Strengthened our presence across Bangladesh and beyond.' ),
		array( 'award', '2024+', 'Looking Ahead', 'Continuing our journey towards sustainable growth.' ),
	);

	foreach ( $about_journey as $index => $milestone ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_about_journey_' . $number . '_icon', $milestone[0], sprintf( __( 'Milestone %d Icon', 'rivross-corporate' ), $number ), 'rivross_about_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_about_journey_' . $number . '_year', $milestone[1], sprintf( __( 'Milestone %d Year', 'rivross-corporate' ), $number ), 'rivross_about_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_about_journey_' . $number . '_title', $milestone[2], sprintf( __( 'Milestone %d Title', 'rivross-corporate' ), $number ), 'rivross_about_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_about_journey_' . $number . '_description', $milestone[3], sprintf( __( 'Milestone %d Description', 'rivross-corporate' ), $number ), 'rivross_about_page', 'textarea', 'sanitize_textarea_field' );
	}

	rivross_add_theme_control( $wp_customize, 'rivross_about_leadership_eyebrow', 'Leadership That Inspires', __( 'Leadership Eyebrow', 'rivross-corporate' ), 'rivross_about_page' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_leadership_title', 'Guided by Experience. Driven by Purpose.', __( 'Leadership Title', 'rivross-corporate' ), 'rivross_about_page' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_leadership_promo_title', 'Meet Our Leadership', __( 'Leadership Promo Title', 'rivross-corporate' ), 'rivross_about_page', 'textarea', 'sanitize_textarea_field' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_leadership_promo_description', 'Learn more about our experienced leadership team.', __( 'Leadership Promo Description', 'rivross-corporate' ), 'rivross_about_page', 'textarea', 'sanitize_textarea_field' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_leadership_promo_label', 'View All Members', __( 'Leadership Promo Button Label', 'rivross-corporate' ), 'rivross_about_page' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_leadership_promo_url', home_url( '/management/' ), __( 'Leadership Promo Button URL', 'rivross-corporate' ), 'rivross_about_page', 'url', 'esc_url_raw' );

	rivross_add_theme_control( $wp_customize, 'rivross_about_cta_icon', 'phone', __( 'About CTA Icon', 'rivross-corporate' ), 'rivross_about_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
	rivross_add_theme_control( $wp_customize, 'rivross_about_cta_eyebrow', "Let's Build Something Great Together", __( 'About CTA Eyebrow', 'rivross-corporate' ), 'rivross_about_page' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_cta_title', "Let's Build Something Great Together", __( 'About CTA Title', 'rivross-corporate' ), 'rivross_about_page' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_cta_description', 'We are always open to new opportunities, partnerships and business collaborations.', __( 'About CTA Description', 'rivross-corporate' ), 'rivross_about_page', 'textarea', 'sanitize_textarea_field' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_cta_primary_label', 'Send an Inquiry', __( 'About CTA Primary Button Label', 'rivross-corporate' ), 'rivross_about_page' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_cta_primary_url', '#contact', __( 'About CTA Primary Button URL', 'rivross-corporate' ), 'rivross_about_page', 'url', 'esc_url_raw' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_cta_secondary_label', 'Contact Us', __( 'About CTA Secondary Button Label', 'rivross-corporate' ), 'rivross_about_page' );
	rivross_add_theme_control( $wp_customize, 'rivross_about_cta_secondary_url', '#contact', __( 'About CTA Secondary Button URL', 'rivross-corporate' ), 'rivross_about_page', 'url', 'esc_url_raw' );

	$wp_customize->add_section(
		'rivross_companies_page',
		array(
			'title'       => __( 'Our Companies Page Settings', 'rivross-corporate' ),
			'description' => __( 'Control every static section of the Our Companies page, including card images, copy, statistics and icons.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 75,
		)
	);

	$companies_page_fields = array(
		'rivross_companies_hero_image'       => array( get_theme_file_uri( '/assets/images/companies/companies-hero.png' ), __( 'Hero Background Image', 'rivross-corporate' ), 'image', 'esc_url_raw' ),
		'rivross_companies_breadcrumb_home'  => array( 'Home', __( 'Breadcrumb Home Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_companies_breadcrumb_page'  => array( 'Our Companies', __( 'Breadcrumb Page Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_companies_hero_line_1'      => array( 'Our', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_companies_hero_line_2'      => array( 'Companies', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_companies_hero_description' => array( 'RIVROSS Company Limited operates through diverse business verticals, each committed to excellence and driven by our core values.', __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_companies_intro_eyebrow'    => array( 'Diversified Businesses', __( 'Intro Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_companies_intro_title'      => array( 'One Vision. Multiple Businesses.', __( 'Intro Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_companies_intro_description' => array( 'Our diverse business portfolio allows us to create value across industries and deliver sustainable growth for our clients, partners and communities.', __( 'Intro Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
	);

	foreach ( $companies_page_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_companies_page', $field[2], $field[3] );
	}

	$companies_business_defaults = array(
		array( 'business-real-estate.png', 'building', 'Real Estate', 'From residential to commercial developments, we build premium properties and communities that stand the test of time.', array( 'Property Development', 'Sales & Marketing', 'Investment Opportunities', 'Property Management' ), 'Explore Real Estate', home_url( '/real-estate/' ) ),
		array( 'business-travel.png', 'plane', 'Travel & Tourism', 'We offer comprehensive travel solutions and unforgettable experiences around the world with reliability and care.', array( 'Air Ticketing', 'Hotel Booking', 'Tour Packages', 'Hajj & Umrah', 'Corporate Travel' ), 'Explore Travel & Tourism', home_url( '/travel-tourism/' ) ),
		array( 'business-tea.png', 'leaf', 'Tea Business', 'Delivering the finest quality tea sourced from the best gardens of Bangladesh to local and international markets.', array( 'Tea Sourcing', 'Wholesale Supply', 'Distribution', 'Corporate Supply' ), 'Explore Tea Business', home_url( '/tea-business/' ) ),
	);

	foreach ( $companies_business_defaults as $index => $business ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_companies_business_' . $number . '_image', get_theme_file_uri( '/assets/images/companies/' . $business[0] ), sprintf( __( 'Business %d Image', 'rivross-corporate' ), $number ), 'rivross_companies_page', 'image', 'esc_url_raw' );
		rivross_add_theme_control( $wp_customize, 'rivross_companies_business_' . $number . '_icon', $business[1], sprintf( __( 'Business %d Icon', 'rivross-corporate' ), $number ), 'rivross_companies_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_companies_business_' . $number . '_title', $business[2], sprintf( __( 'Business %d Title', 'rivross-corporate' ), $number ), 'rivross_companies_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_companies_business_' . $number . '_description', $business[3], sprintf( __( 'Business %d Description', 'rivross-corporate' ), $number ), 'rivross_companies_page', 'textarea', 'sanitize_textarea_field' );
		for ( $feature_index = 0; $feature_index < 5; $feature_index++ ) {
			$feature_default = isset( $business[4][ $feature_index ] ) ? $business[4][ $feature_index ] : '';
			rivross_add_theme_control( $wp_customize, 'rivross_companies_business_' . $number . '_feature_' . ( $feature_index + 1 ), $feature_default, sprintf( __( 'Business %d Feature %d', 'rivross-corporate' ), $number, $feature_index + 1 ), 'rivross_companies_page' );
		}
		rivross_add_theme_control( $wp_customize, 'rivross_companies_business_' . $number . '_button_label', $business[5], sprintf( __( 'Business %d Button Label', 'rivross-corporate' ), $number ), 'rivross_companies_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_companies_business_' . $number . '_button_url', $business[6], sprintf( __( 'Business %d Button URL', 'rivross-corporate' ), $number ), 'rivross_companies_page', 'url', 'esc_url_raw' );
	}

	$companies_stat_defaults = array(
		array( 'building', '3+', 'Business Verticals', 'Strong & Growing' ),
		array( 'chart', '100+', 'Projects Completed', 'Across Sectors' ),
		array( 'users', '50+', 'Expert Professionals', 'Dedicated Team' ),
		array( 'globe', '500+', 'Happy Clients', 'Worldwide' ),
	);

	foreach ( $companies_stat_defaults as $index => $stat ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_companies_stat_' . $number . '_icon', $stat[0], sprintf( __( 'Statistic %d Icon', 'rivross-corporate' ), $number ), 'rivross_companies_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_companies_stat_' . $number . '_value', $stat[1], sprintf( __( 'Statistic %d Value', 'rivross-corporate' ), $number ), 'rivross_companies_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_companies_stat_' . $number . '_title', $stat[2], sprintf( __( 'Statistic %d Title', 'rivross-corporate' ), $number ), 'rivross_companies_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_companies_stat_' . $number . '_subtitle', $stat[3], sprintf( __( 'Statistic %d Subtitle', 'rivross-corporate' ), $number ), 'rivross_companies_page' );
	}

	rivross_add_theme_control( $wp_customize, 'rivross_companies_cta_icon', 'users', __( 'Inquiry CTA Icon', 'rivross-corporate' ), 'rivross_companies_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
	rivross_add_theme_control( $wp_customize, 'rivross_companies_cta_title', 'Looking for Business Opportunities?', __( 'Inquiry CTA Title', 'rivross-corporate' ), 'rivross_companies_page' );
	rivross_add_theme_control( $wp_customize, 'rivross_companies_cta_description', 'Partner with us and be a part of our growth journey.', __( 'Inquiry CTA Description', 'rivross-corporate' ), 'rivross_companies_page', 'textarea', 'sanitize_textarea_field' );
	rivross_add_theme_control( $wp_customize, 'rivross_companies_cta_button_label', 'Send an Inquiry', __( 'Inquiry CTA Button Label', 'rivross-corporate' ), 'rivross_companies_page' );
	rivross_add_theme_control( $wp_customize, 'rivross_companies_cta_button_url', '#contact', __( 'Inquiry CTA Button URL', 'rivross-corporate' ), 'rivross_companies_page', 'url', 'esc_url_raw' );

	$wp_customize->add_section(
		'rivross_news_media_page',
		array(
			'title'       => __( 'News & Media Page Settings', 'rivross-corporate' ),
			'description' => __( 'Control the News & Media archive and single article presentation. Article content, categories, reading time and feature images are managed from Dashboard → Posts.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 78,
		)
	);

	$news_media_fields = array(
		'rivross_news_hero_image'        => array( get_theme_file_uri( '/assets/images/news/news-hero.png' ), __( 'Hero Background Image', 'rivross-corporate' ), 'image', 'esc_url_raw' ),
		'rivross_news_breadcrumb_home'   => array( 'Home', __( 'Breadcrumb Home Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_breadcrumb_page'   => array( 'News & Media', __( 'Breadcrumb Page Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_hero_line_1'       => array( 'News & Insights', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_hero_line_2'       => array( 'Stay Informed, Stay Ahead', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_hero_description'  => array( 'Explore the latest updates, market trends, company announcements and real estate insights from RIVROSS and the industry.', __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_news_all_label'         => array( 'All News', __( 'All News Filter Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_search_placeholder' => array( 'Search articles...', __( 'Search Placeholder', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_read_more_label'   => array( 'Read More', __( 'Article Read-More Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_subscribe_title'   => array( 'Stay Updated with RIVROSS', __( 'Newsletter Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_subscribe_text'    => array( 'Subscribe to our newsletter and get the latest news, insights and exclusive updates straight to your inbox.', __( 'Newsletter Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_news_subscribe_placeholder' => array( 'Enter your email address', __( 'Newsletter Email Placeholder', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_subscribe_button'   => array( 'Subscribe', __( 'Newsletter Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_article_author_default' => array( 'RIVROSS Insights', __( 'Single Article Author Fallback', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_article_subheading' => array( 'A market shaped by confidence and change', __( 'Single Article Section Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_article_callout' => array( 'Smart growth starts with a clear view of people, place and opportunity.', __( 'Single Article Callout', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_news_popular_title' => array( 'Popular Insights', __( 'Single Article Popular Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_news_related_title' => array( 'Related Insights', __( 'Single Article Related Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
	);

	foreach ( $news_media_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_news_media_page', $field[2], $field[3] );
	}

	$wp_customize->add_section(
		'rivross_events_page',
		array(
			'title'       => __( 'Events Page Settings', 'rivross-corporate' ),
			'description' => __( 'Control the Events archive and single event details page. Event posts, dates, overview content and agenda rows are managed from Dashboard → Events.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 78,
		)
	);

	$events_page_fields = array(
		'rivross_events_hero_image'              => array( get_theme_file_uri( '/assets/images/events/events-hero.png' ), __( 'Hero Background Image', 'rivross-corporate' ), 'image', 'esc_url_raw' ),
		'rivross_events_breadcrumb_home'         => array( 'Home', __( 'Breadcrumb Home Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_breadcrumb_parent'       => array( 'News & Media', __( 'Breadcrumb Parent Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_breadcrumb_page'         => array( 'Events', __( 'Breadcrumb Page Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_hero_line_1'             => array( 'Events That Inspire,', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_hero_line_2'             => array( 'Connections That Last', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_hero_description'       => array( 'Join us at our upcoming events, summits and exhibitions where ideas meet opportunities and partnerships are built.', __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_events_search_placeholder'     => array( 'Search events...', __( 'Search Placeholder', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_upcoming_title'         => array( 'Upcoming Events', __( 'Upcoming Events Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_calendar_title'         => array( 'Event Calendar', __( 'Calendar Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_highlights_title'       => array( 'Event Highlights', __( 'Highlights Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_why_eyebrow'            => array( 'Why Attend Our Events?', __( 'Why Attend Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_why_title'              => array( 'Connect. Learn. Grow.', __( 'Why Attend Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_details_label'          => array( 'View Details', __( 'Details Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_register_label'         => array( 'Register Now', __( 'Register Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_newsletter_title'       => array( 'Never Miss an Event', __( 'Newsletter Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_newsletter_description' => array( 'Subscribe to our event updates and be the first to know about upcoming opportunities.', __( 'Newsletter Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_events_newsletter_placeholder' => array( 'Enter your email address', __( 'Newsletter Email Placeholder', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_newsletter_button'      => array( 'Subscribe', __( 'Newsletter Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_single_hero_image'      => array( get_theme_file_uri( '/assets/images/events/event-single-hero.png' ), __( 'Single Event Hero Image', 'rivross-corporate' ), 'image', 'esc_url_raw' ),
		'rivross_events_single_overview_eyebrow' => array( 'Event Overview', __( 'Single Event Overview Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_single_overview_title'  => array( 'Ideas that shape tomorrow.', __( 'Single Event Overview Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_single_agenda_title'    => array( 'Summit Agenda Highlights', __( 'Single Event Agenda Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_single_register_label'  => array( 'Register Now', __( 'Single Event Register Button', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_single_question_label'  => array( 'Have questions?', __( 'Single Event Question Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_single_details_title'   => array( 'Event Details', __( 'Single Event Details Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_single_expectations_title' => array( 'What to Expect', __( 'Single Event Expectations Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_events_single_related_title'    => array( 'Related Events', __( 'Single Event Related Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
	);
	foreach ( $events_page_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_events_page', $field[2], $field[3] );
	}

	$event_highlight_defaults = array(
		array( 'users', 'Industry Experts', 'Learn from leading professionals and thought leaders.' ),
		array( 'handshake', 'Networking Opportunities', 'Connect with potential partners, investors and collaborators.' ),
		array( 'chart', 'Exclusive Insights', 'Gain access to market trends, research and future opportunities.' ),
		array( 'lightbulb', 'Innovative Solutions', 'Discover the latest technologies and sustainable practices.' ),
	);
	foreach ( $event_highlight_defaults as $index => $highlight ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_events_highlight_' . $number . '_icon', $highlight[0], sprintf( __( 'Highlight %d Icon', 'rivross-corporate' ), $number ), 'rivross_events_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_events_highlight_' . $number . '_title', $highlight[1], sprintf( __( 'Highlight %d Title', 'rivross-corporate' ), $number ), 'rivross_events_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_events_highlight_' . $number . '_description', $highlight[2], sprintf( __( 'Highlight %d Description', 'rivross-corporate' ), $number ), 'rivross_events_page', 'textarea', 'sanitize_textarea_field' );
	}

	$event_why_defaults = array(
		array( 'users', 'Expand Your Network', 'Meet industry leaders, investors and decision-makers.' ),
		array( 'chart', 'Stay Informed', 'Stay ahead with the latest trends and market insights.' ),
		array( 'lightbulb', 'Get Inspired', 'Gain new perspectives and ideas from experts.' ),
		array( 'handshake', 'Build Partnerships', 'Create meaningful relationships that drive success.' ),
		array( 'target', 'Drive Growth', 'Unlock opportunities that accelerate your business.' ),
	);
	foreach ( $event_why_defaults as $index => $item ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_events_why_' . $number . '_icon', $item[0], sprintf( __( 'Why Item %d Icon', 'rivross-corporate' ), $number ), 'rivross_events_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_events_why_' . $number . '_title', $item[1], sprintf( __( 'Why Item %d Title', 'rivross-corporate' ), $number ), 'rivross_events_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_events_why_' . $number . '_description', $item[2], sprintf( __( 'Why Item %d Description', 'rivross-corporate' ), $number ), 'rivross_events_page', 'textarea', 'sanitize_textarea_field' );
	}

	$event_expectation_defaults = array(
		array( 'users', 'Industry Experts', 'Learn from visionary leaders and proven experts.' ),
		array( 'chart', 'Market Insights', 'Gain exclusive insights into market trends and forecasts.' ),
		array( 'handshake', 'Networking', 'Connect with peers, investors and decision-makers.' ),
		array( 'lightbulb', 'New Opportunities', 'Discover collaborations and investment opportunities.' ),
	);
	foreach ( $event_expectation_defaults as $index => $item ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_events_single_expect_' . $number . '_icon', $item[0], sprintf( __( 'Single Event Expectation %d Icon', 'rivross-corporate' ), $number ), 'rivross_events_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_events_single_expect_' . $number . '_title', $item[1], sprintf( __( 'Single Event Expectation %d Title', 'rivross-corporate' ), $number ), 'rivross_events_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_events_single_expect_' . $number . '_description', $item[2], sprintf( __( 'Single Event Expectation %d Description', 'rivross-corporate' ), $number ), 'rivross_events_page', 'textarea', 'sanitize_textarea_field' );
	}

	$wp_customize->add_section(
		'rivross_contact_page',
		array(
			'title'       => __( 'Contact Us Page Settings', 'rivross-corporate' ),
			'description' => __( 'Control every static Contact Us section, including hero content, contact cards, location, FAQs and call to action.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 78,
		)
	);

	$contact_page_fields = array(
		'rivross_contact_hero_image'        => array( get_theme_file_uri( '/assets/images/contact/contact-hero.png' ), __( 'Hero Background Image', 'rivross-corporate' ), 'image', 'esc_url_raw' ),
		'rivross_contact_breadcrumb_home'   => array( 'Home', __( 'Breadcrumb Home Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_breadcrumb_page'   => array( 'Contact Us', __( 'Breadcrumb Page Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_hero_line_1'       => array( 'Get In Touch', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_hero_line_2'       => array( 'With Rivross', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_hero_description' => array( "We're here to answer your questions, listen to your ideas and help you find the perfect solution for your real estate needs.", __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_contact_call_icon'         => array( 'phone', __( 'Call Card Icon', 'rivross-corporate' ), 'select', 'rivross_sanitize_icon_choice' ),
		'rivross_contact_call_title'       => array( 'Call Us', __( 'Call Card Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_call_phone'       => array( '01796-565279', __( 'Call Card Phone', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_call_meta'        => array( 'Sat - Thu (10:00 AM - 07:00 PM)', __( 'Call Card Supporting Text', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_email_icon'        => array( 'mail', __( 'Email Card Icon', 'rivross-corporate' ), 'select', 'rivross_sanitize_icon_choice' ),
		'rivross_contact_email_title'      => array( 'Email Us', __( 'Email Card Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_email_address'    => array( 'rivrossgroup@gmail.com', __( 'Email Card Address', 'rivross-corporate' ), 'email', 'sanitize_email' ),
		'rivross_contact_email_meta'       => array( 'We reply within 24 hours', __( 'Email Card Supporting Text', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_visit_icon'        => array( 'pin', __( 'Visit Card Icon', 'rivross-corporate' ), 'select', 'rivross_sanitize_icon_choice' ),
		'rivross_contact_visit_title'      => array( 'Visit Us', __( 'Visit Card Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_visit_address'    => array( '3/3 Matirari, Jamebagh, Jurabagh, Dhaka-1204, Bangladesh', __( 'Visit Card Address', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_contact_visit_meta'       => array( '', __( 'Visit Card Supporting Text', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_hours_icon'        => array( 'clock', __( 'Hours Card Icon', 'rivross-corporate' ), 'select', 'rivross_sanitize_icon_choice' ),
		'rivross_contact_hours_title'      => array( 'Office Hours', __( 'Hours Card Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_hours'            => array( 'Saturday - Thursday', __( 'Office Hours Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_hours_meta'       => array( '10:00 AM - 07:00 PM', __( 'Office Hours Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_form_heading'     => array( 'Send Us a Message', __( 'Form Section Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_form_privacy'     => array( 'Your information is safe with us. We respect your privacy.', __( 'Form Privacy Note', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_map_label'        => array( 'Our Office Location', __( 'Map Section Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_map_address'      => array( '3/3 Matirari, Jamebagh, Jurabagh, Dhaka-1204, Bangladesh', __( 'Map Address', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_contact_map_url'          => array( 'https://maps.google.com/?q=Jatrabari,Dhaka', __( 'Get Directions URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_contact_faq_eyebrow'      => array( 'FAQ', __( 'FAQ Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_faq_heading'      => array( 'Frequently Asked Questions', __( 'FAQ Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_faq_description'  => array( 'Find quick answers to common questions about our services and processes.', __( 'FAQ Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
	);

	foreach ( $contact_page_fields as $setting_id => $field ) {
		$extra = 'select' === $field[2] ? array( 'choices' => rivross_icon_choices() ) : array();
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_contact_page', $field[2], $field[3], $extra );
	}

	$contact_faq_defaults = array(
		array( 'What types of properties do you deal with?', 'We help clients explore residential and commercial property opportunities through our real estate team.' ),
		array( 'How can I schedule a property visit?', 'Send us your preferred date through the form and our team will confirm a convenient time.' ),
		array( 'Do you provide financing support?', 'We can guide you through available options and connect you with the appropriate partners.' ),
		array( 'How can I list my property with Rivross?', 'Share your property details and our team will contact you about the next steps.' ),
		array( 'What documents are required to purchase a property?', 'The required documents depend on the property and transaction; our team will provide a checklist.' ),
	);
	foreach ( $contact_faq_defaults as $index => $faq ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_contact_faq_' . $number . '_question', $faq[0], sprintf( __( 'FAQ %d Question', 'rivross-corporate' ), $number ), 'rivross_contact_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_contact_faq_' . $number . '_answer', $faq[1], sprintf( __( 'FAQ %d Answer', 'rivross-corporate' ), $number ), 'rivross_contact_page', 'textarea', 'sanitize_textarea_field' );
	}

	$contact_cta_fields = array(
		'rivross_contact_cta_heading'        => array( 'Ready to Find Your Dream Property?', __( 'CTA Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_cta_description'    => array( 'Our experts are ready to help you make the right move.', __( 'CTA Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_contact_cta_primary_label'  => array( 'Explore Properties', __( 'CTA Primary Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_cta_primary_url'    => array( '#properties', __( 'CTA Primary Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_contact_cta_secondary_label' => array( 'Schedule a Consultation', __( 'CTA Secondary Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_contact_cta_secondary_url'   => array( '#contact-form', __( 'CTA Secondary Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
	);
	foreach ( $contact_cta_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_contact_page', $field[2], $field[3] );
	}

	$wp_customize->add_section(
		'rivross_management_page',
		array(
			'title'       => __( 'Leadership Page Settings', 'rivross-corporate' ),
			'description' => __( 'Control the Leadership page hero, team layout, statistics, commitment block and CTA. Leader profiles are managed from Dashboard → Leadership.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 79,
		)
	);

	$management_page_fields = array(
		'rivross_management_hero_image'        => array( get_theme_file_uri( '/assets/images/leadership/leadership-hero.png' ), __( 'Hero Background Image', 'rivross-corporate' ), 'image', 'esc_url_raw' ),
		'rivross_management_breadcrumb_home'   => array( 'Home', __( 'Breadcrumb Home Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_breadcrumb_page'   => array( 'Management', __( 'Breadcrumb Page Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_hero_line_1'       => array( 'Our Leadership,', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_hero_line_2'       => array( 'Your Trust', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_hero_description' => array( 'A team of visionary leaders and industry experts working together to build a better future with integrity, innovation and excellence.', __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_management_intro_eyebrow'    => array( 'Our Management Team', __( 'Team Section Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_intro_title'      => array( 'Experience. Vision. Leadership.', __( 'Team Section Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_intro_description' => array( 'Our management team brings together decades of experience in real estate, development, finance and operations to drive sustainable growth and lasting value.', __( 'Team Section Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
	);

	foreach ( $management_page_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_management_page', $field[2], $field[3] );
	}

	$management_stat_defaults = array(
		array( 'users', '100+', 'Team Members', '' ),
		array( 'briefcase', '25+', 'Years of Combined', 'Experience' ),
		array( 'building', '50+', 'Successful', 'Projects' ),
		array( 'award', 'Awards', 'For Excellence in', 'Real Estate' ),
	);
	foreach ( $management_stat_defaults as $index => $stat ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_management_stat_' . $number . '_icon', $stat[0], sprintf( __( 'Statistic %d Icon', 'rivross-corporate' ), $number ), 'rivross_management_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_management_stat_' . $number . '_value', $stat[1], sprintf( __( 'Statistic %d Value', 'rivross-corporate' ), $number ), 'rivross_management_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_management_stat_' . $number . '_title', $stat[2], sprintf( __( 'Statistic %d Title', 'rivross-corporate' ), $number ), 'rivross_management_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_management_stat_' . $number . '_subtitle', $stat[3], sprintf( __( 'Statistic %d Subtitle', 'rivross-corporate' ), $number ), 'rivross_management_page' );
	}

	$management_commitment_fields = array(
		'rivross_management_commitment_image'       => array( get_theme_file_uri( '/assets/images/leadership/leadership-commitment.png' ), __( 'Commitment Image', 'rivross-corporate' ), 'image', 'esc_url_raw' ),
		'rivross_management_commitment_eyebrow'     => array( 'Our Commitment', __( 'Commitment Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_commitment_title'       => array( 'Building a Legacy of Trust and Excellence', __( 'Commitment Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_commitment_description' => array( 'At RIVROSS, our leadership is committed to creating value for our clients, partners and communities through transparency, innovation and sustainable growth.', __( 'Commitment Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_management_commitment_button_label' => array( 'Learn More About Us', __( 'Commitment Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_commitment_button_url'   => array( home_url( '/about-us/' ), __( 'Commitment Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
	);
	foreach ( $management_commitment_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_management_page', $field[2], $field[3] );
	}

	$management_cta_fields = array(
		'rivross_management_cta_heading'        => array( "Let's Build Something Great Together", __( 'CTA Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_cta_description'    => array( 'Partner with our experienced leadership team and turn your vision into reality.', __( 'CTA Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_management_cta_primary_label'  => array( 'Discuss Your Project', __( 'CTA Primary Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_cta_primary_url'    => array( home_url( '/contact-us/' ), __( 'CTA Primary Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_management_cta_secondary_label' => array( 'Contact Us', __( 'CTA Secondary Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_management_cta_secondary_url'   => array( home_url( '/contact-us/' ), __( 'CTA Secondary Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
	);
	foreach ( $management_cta_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_management_page', $field[2], $field[3] );
	}

	$wp_customize->add_section(
		'rivross_careers_page',
		array(
			'title'       => __( 'Careers Page Settings', 'rivross-corporate' ),
			'description' => __( 'Control Careers page copy, imagery and section labels here. Job cards and job details are managed from Dashboard → Careers Jobs.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 79,
		)
	);

	$careers_page_fields = array(
		'rivross_careers_hero_image'       => array( get_theme_file_uri( '/assets/images/careers/careers-hero.png' ), __( 'Hero Background Image', 'rivross-corporate' ), 'image', 'esc_url_raw' ),
		'rivross_careers_breadcrumb_home'  => array( 'Home', __( 'Breadcrumb Home Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_breadcrumb_page'  => array( 'Careers', __( 'Breadcrumb Page Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_hero_line_1'      => array( 'Build Your Career.', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_hero_line_2'      => array( 'Build a Better Tomorrow.', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_hero_description' => array( 'At RIVROSS, we empower people to grow, innovate and make a lasting impact in real estate and beyond.', __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_careers_hero_button_label' => array( 'Explore Opportunities', __( 'Hero Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_hero_button_url'   => array( '#open-positions', __( 'Hero Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_careers_about_image'       => array( get_theme_file_uri( '/assets/images/careers/careers-collaboration.png' ), __( 'About Careers Image', 'rivross-corporate' ), 'image', 'esc_url_raw' ),
		'rivross_careers_about_eyebrow'     => array( 'About Careers at RIVROSS', __( 'About Careers Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_about_title'       => array( 'Where Ambition Meets Opportunity', __( 'About Careers Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_about_description' => array( 'We are more than a real estate company; we are a team of visionaries, problem-solvers and change-makers. Join us and be part of a dynamic environment where your ideas shape iconic projects and communities.', __( 'About Careers Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_careers_about_button_label' => array( 'Learn More About Us', __( 'About Careers Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_about_button_url'   => array( home_url( '/about-us/' ), __( 'About Careers Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_careers_why_title'         => array( 'Why Join RIVROSS?', __( 'Why Join Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_jobs_title'        => array( 'Open Positions', __( 'Open Positions Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_jobs_empty_message' => array( 'No open positions are available right now. Please check back soon.', __( 'Empty Jobs Message', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_careers_process_title'    => array( 'Our Hiring Process', __( 'Hiring Process Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_process_description' => array( 'Simple, transparent and focused on finding the right fit.', __( 'Hiring Process Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_careers_testimonials_title' => array( 'Hear From Our Team', __( 'Testimonials Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_cta_background_image' => array( get_theme_file_uri( '/assets/images/careers/careers-job-hero.png' ), __( 'CTA Background Image', 'rivross-corporate' ), 'image', 'esc_url_raw' ),
		'rivross_careers_cta_heading'       => array( 'Ready to Take the Next Step?', __( 'CTA Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_cta_description'   => array( 'Explore opportunities and build a career that makes a difference.', __( 'CTA Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_careers_cta_primary_label' => array( 'Browse All Jobs', __( 'CTA Primary Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_cta_primary_url'   => array( '#open-positions', __( 'CTA Primary Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_careers_cta_secondary_label' => array( 'Submit Your CV', __( 'CTA Secondary Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_careers_cta_secondary_url'   => array( home_url( '/submit-your-cv/' ), __( 'CTA Secondary Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
	);
	foreach ( $careers_page_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_careers_page', $field[2], $field[3] );
	}

	$careers_value_defaults = array(
		array( 'users', 'People First', 'We value our people and their well-being.' ),
		array( 'lightbulb', 'Innovation', 'We encourage new ideas and creative thinking.' ),
		array( 'target', 'Excellence', 'We are committed to quality in everything we do.' ),
		array( 'handshake', 'Integrity', 'We do the right thing, always.' ),
		array( 'chart', 'Growth', 'We grow together and celebrate success.' ),
		array( 'sprout', 'Sustainability', 'We build responsibly for a better future.' ),
	);
	foreach ( $careers_value_defaults as $index => $value ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_careers_value_' . $number . '_icon', $value[0], sprintf( __( 'Value %d Icon', 'rivross-corporate' ), $number ), 'rivross_careers_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_careers_value_' . $number . '_title', $value[1], sprintf( __( 'Value %d Title', 'rivross-corporate' ), $number ), 'rivross_careers_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_careers_value_' . $number . '_description', $value[2], sprintf( __( 'Value %d Description', 'rivross-corporate' ), $number ), 'rivross_careers_page', 'textarea', 'sanitize_textarea_field' );
	}

	$careers_why_defaults = array(
		array( 'chart', 'Career Growth', 'Access learning, mentorship and advancement opportunities.' ),
		array( 'money', 'Competitive Rewards', 'We offer market-competitive salaries and performance bonuses.' ),
		array( 'heart', 'Work-Life Balance', 'Flexible policies and a culture that respects your personal time.' ),
		array( 'shield', 'Health & Wellness', 'Comprehensive health coverage and wellness programs.' ),
		array( 'users', 'Great Culture', 'Collaborative, inclusive and supportive work environment.' ),
	);
	foreach ( $careers_why_defaults as $index => $item ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_careers_why_' . $number . '_icon', $item[0], sprintf( __( 'Why Join %d Icon', 'rivross-corporate' ), $number ), 'rivross_careers_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_careers_why_' . $number . '_title', $item[1], sprintf( __( 'Why Join %d Title', 'rivross-corporate' ), $number ), 'rivross_careers_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_careers_why_' . $number . '_description', $item[2], sprintf( __( 'Why Join %d Description', 'rivross-corporate' ), $number ), 'rivross_careers_page', 'textarea', 'sanitize_textarea_field' );
	}

	$careers_process_defaults = array(
		array( 'file', 'Apply Online', 'Submit your application through our career portal.' ),
		array( 'users', 'Initial Screening', 'Our team reviews your application and experience.' ),
		array( 'microphone', 'Interviews', 'Meet with our team to discuss your skills and aspirations.' ),
		array( 'award', 'Offer & Onboarding', 'Receive your offer and begin your journey with us.' ),
	);
	foreach ( $careers_process_defaults as $index => $step ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_careers_process_' . $number . '_icon', $step[0], sprintf( __( 'Hiring Step %d Icon', 'rivross-corporate' ), $number ), 'rivross_careers_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_careers_process_' . $number . '_title', $step[1], sprintf( __( 'Hiring Step %d Title', 'rivross-corporate' ), $number ), 'rivross_careers_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_careers_process_' . $number . '_description', $step[2], sprintf( __( 'Hiring Step %d Description', 'rivross-corporate' ), $number ), 'rivross_careers_page', 'textarea', 'sanitize_textarea_field' );
	}

	$careers_testimonial_defaults = array(
		array( get_theme_file_uri( '/assets/images/home/leadership-director.png' ), 'Tanvir Ahmed', 'Project Manager', 'RIVROSS has given me the platform to grow professionally while working on some of the most exciting projects in the industry.' ),
		array( get_theme_file_uri( '/assets/images/leadership/leadership-marketing.png' ), 'Faria Islam', 'Marketing Manager', 'The supportive culture and learning opportunities here make every day challenging and rewarding.' ),
		array( get_theme_file_uri( '/assets/images/home/leadership-beard.png' ), 'Imtiaz Uddin', 'Business Development Manager', 'I love being part of a team that is passionate about building a better future for our clients and communities.' ),
	);
	foreach ( $careers_testimonial_defaults as $index => $testimonial ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_careers_testimonial_' . $number . '_image', $testimonial[0], sprintf( __( 'Testimonial %d Photo', 'rivross-corporate' ), $number ), 'rivross_careers_page', 'image', 'esc_url_raw' );
		rivross_add_theme_control( $wp_customize, 'rivross_careers_testimonial_' . $number . '_name', $testimonial[1], sprintf( __( 'Testimonial %d Name', 'rivross-corporate' ), $number ), 'rivross_careers_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_careers_testimonial_' . $number . '_role', $testimonial[2], sprintf( __( 'Testimonial %d Role', 'rivross-corporate' ), $number ), 'rivross_careers_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_careers_testimonial_' . $number . '_quote', $testimonial[3], sprintf( __( 'Testimonial %d Quote', 'rivross-corporate' ), $number ), 'rivross_careers_page', 'textarea', 'sanitize_textarea_field' );
	}

	$wp_customize->add_section(
		'rivross_other_pages',
		array(
			'title'       => __( 'Inner Page Defaults', 'rivross-corporate' ),
			'description' => __( 'Set the shared title and subtitle for inner-page templates.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 80,
		)
	);

	$inner_page_fields = array(
		'rivross_inner_page_title'    => array( 'RIVROSS Company Limited', __( 'Inner Page Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_inner_page_subtitle' => array( 'Building Businesses. Creating Opportunities.', __( 'Inner Page Subtitle', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
	);

	foreach ( $inner_page_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_other_pages', $field[2], $field[3] );
	}

	$wp_customize->add_section(
		'rivross_header_settings',
		array(
			'title'       => __( 'Header Settings', 'rivross-corporate' ),
			'description' => __( 'Manage the header inquiry button. Change the logo from Site Identity and the menu from Menus.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 90,
		)
	);

	rivross_add_theme_control( $wp_customize, 'rivross_header_inquiry_label', 'Inquiry', __( 'Inquiry Button Label', 'rivross-corporate' ), 'rivross_header_settings' );
	rivross_add_theme_control( $wp_customize, 'rivross_inquiry_url', home_url( '/#contact' ), __( 'Inquiry Button URL', 'rivross-corporate' ), 'rivross_header_settings', 'url', 'esc_url_raw' );

	$wp_customize->add_section(
		'rivross_design_system',
		array(
			'title'       => __( 'Global Design System', 'rivross-corporate' ),
			'description' => __( 'Adjust the global RIVROSS palette and typography. These values will be used by the theme sections.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 110,
		)
	);

	$colors = array(
		'rivross_color_navy'       => array( '#061a36', __( 'Primary Navy', 'rivross-corporate' ), __( 'Main brand color for headers, hero sections and primary buttons.', 'rivross-corporate' ) ),
		'rivross_color_navy_2'     => array( '#0b2a4a', __( 'Secondary Navy', 'rivross-corporate' ), __( 'Supporting navy used for cards, overlays and secondary sections.', 'rivross-corporate' ) ),
		'rivross_color_gold'       => array( '#c9962d', __( 'Brand Gold', 'rivross-corporate' ), __( 'Primary accent for buttons, highlights and key interface details.', 'rivross-corporate' ) ),
		'rivross_color_gold_light' => array( '#e8c06a', __( 'Light Gold', 'rivross-corporate' ), __( 'Soft accent used for hover states and fine decorative details.', 'rivross-corporate' ) ),
		'rivross_color_ink'        => array( '#17243a', __( 'Body Text', 'rivross-corporate' ), __( 'Default text color on light backgrounds. Keep sufficient contrast for readability.', 'rivross-corporate' ) ),
		'rivross_color_surface'    => array( '#f7f8fa', __( 'Surface Background', 'rivross-corporate' ), __( 'Light section and card background used throughout the website.', 'rivross-corporate' ) ),
	);

	foreach ( $colors as $setting_id => $color ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $color[0],
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$setting_id,
				array(
					'label'       => $color[1],
					'description' => $color[2],
					'section'     => 'rivross_design_system',
				)
			)
		);
	}

	$wp_customize->add_setting(
		'rivross_font_body',
		array(
			'default'           => 'Montserrat',
			'sanitize_callback' => 'rivross_sanitize_font_choice',
		)
	);
	$wp_customize->add_control(
		'rivross_font_body',
		array(
			'label'       => __( 'Body and Navigation Font', 'rivross-corporate' ),
			'description' => __( 'Choose the clean sans-serif font used for paragraphs, navigation and interface text.', 'rivross-corporate' ),
			'section'     => 'rivross_design_system',
			'type'        => 'select',
			'choices'     => array(
				'Montserrat' => 'Montserrat',
				'Inter'      => 'Inter',
			),
		)
	);

	$wp_customize->add_setting(
		'rivross_font_display',
		array(
			'default'           => 'Cormorant Garamond',
			'sanitize_callback' => 'rivross_sanitize_font_choice',
		)
	);
	$wp_customize->add_control(
		'rivross_font_display',
		array(
			'label'       => __( 'Heading Font', 'rivross-corporate' ),
			'description' => __( 'Choose the editorial serif font used for page titles and section headings.', 'rivross-corporate' ),
			'section'     => 'rivross_design_system',
			'type'        => 'select',
			'choices'     => array(
				'Cormorant Garamond' => 'Cormorant Garamond',
				'Playfair Display'   => 'Playfair Display',
			),
		)
	);

	$typography_fields = array(
		'rivross_font_size_body'    => array( 16, __( 'Body Font Size (px)', 'rivross-corporate' ), 12, 24, 1, 'rivross_sanitize_font_size' ),
		'rivross_line_height_body'  => array( 1.65, __( 'Body Line Height', 'rivross-corporate' ), 1, 2.4, 0.05, 'rivross_sanitize_line_height' ),
		'rivross_font_size_nav'     => array( 11, __( 'Navigation Font Size (px)', 'rivross-corporate' ), 9, 18, 1, 'rivross_sanitize_font_size' ),
		'rivross_font_size_button'  => array( 12, __( 'Button Font Size (px)', 'rivross-corporate' ), 9, 20, 1, 'rivross_sanitize_font_size' ),
		'rivross_font_size_eyebrow' => array( 12, __( 'Eyebrow / Label Size (px)', 'rivross-corporate' ), 9, 20, 1, 'rivross_sanitize_font_size' ),
		'rivross_font_size_h1'      => array( 77, __( 'Main Heading Size (px)', 'rivross-corporate' ), 36, 96, 1, 'rivross_sanitize_font_size' ),
		'rivross_font_size_h2'      => array( 56, __( 'Section Heading Size (px)', 'rivross-corporate' ), 28, 80, 1, 'rivross_sanitize_font_size' ),
		'rivross_font_size_h3'      => array( 38, __( 'Subheading Size (px)', 'rivross-corporate' ), 20, 60, 1, 'rivross_sanitize_font_size' ),
		'rivross_font_size_card'    => array( 20, __( 'Card Heading Size (px)', 'rivross-corporate' ), 12, 36, 1, 'rivross_sanitize_font_size' ),
		'rivross_font_size_hero'    => array( 64, __( 'Hero Heading Size (px)', 'rivross-corporate' ), 32, 96, 1, 'rivross_sanitize_font_size' ),
		'rivross_font_size_small'   => array( 12, __( 'Small / Meta Text Size (px)', 'rivross-corporate' ), 9, 18, 1, 'rivross_sanitize_font_size' ),
	);

	foreach ( $typography_fields as $setting_id => $field ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $field[0],
				'sanitize_callback' => $field[5],
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$setting_id,
			array(
				'label'       => $field[1],
				'description' => 'rivross_line_height_body' === $setting_id ? __( 'Use a value between 1 and 2.4. Changes apply across the theme.', 'rivross-corporate' ) : __( 'Use pixels for font sizes. Changes apply across the theme.', 'rivross-corporate' ),
				'section'     => 'rivross_design_system',
				'type'        => 'number',
				'input_attrs' => array(
					'min'  => $field[2],
					'max'  => $field[3],
					'step' => $field[4],
				),
			)
		);
	}

	$wp_customize->add_section(
		'rivross_real_estate_page',
		array(
			'title'       => __( 'Real Estate Page Settings', 'rivross-corporate' ),
			'description' => __( 'Control the property portal hero, labels and investment strip. Add and edit properties from Dashboard → Properties.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 90,
		)
	);
	$real_estate_fields = array(
		'rivross_real_estate_breadcrumb_home' => array( 'Home', __( 'Breadcrumb Home', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_real_estate_breadcrumb_parent' => array( 'Our Companies', __( 'Breadcrumb Parent', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_real_estate_breadcrumb_page' => array( 'Real Estate', __( 'Breadcrumb Page', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_real_estate_hero_line_1' => array( 'Properties', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_real_estate_hero_line_2' => array( 'Find Your Perfect Property', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_real_estate_hero_description' => array( 'Explore our wide range of residential, commercial and land properties in prime locations.', __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_real_estate_newsletter_title' => array( 'Get Latest Property Updates', __( 'Newsletter Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_real_estate_newsletter_description' => array( 'Subscribe to get the best property deals and updates.', __( 'Newsletter Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
	);
	foreach ( $real_estate_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_real_estate_page', $field[2], $field[3] );
	}
	rivross_add_theme_control( $wp_customize, 'rivross_real_estate_hero_image', get_theme_file_uri( '/assets/images/real-estate/real-estate-hero.png' ), __( 'Hero Background Image', 'rivross-corporate' ), 'rivross_real_estate_page', 'image', 'esc_url_raw' );
	rivross_add_theme_control( $wp_customize, 'rivross_real_estate_why_heading', 'Why Invest With RIVROSS Real Estate?', __( 'Investment Strip Heading', 'rivross-corporate' ), 'rivross_real_estate_page' );

	$real_estate_why = array(
		array( 'pin', 'Prime Locations', 'Properties in the most desirable areas.' ),
		array( 'shield', 'Trusted Developer', 'Commitment to quality, transparency and trust.' ),
		array( 'money', 'High ROI', 'Strong rental yield and capital appreciation.' ),
		array( 'file', 'Legal Security', '100% legal property with clear documentation.' ),
		array( 'headset', 'After Sales Support', 'Dedicated support even after possession.' ),
	);
	foreach ( $real_estate_why as $index => $item ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_real_estate_why_' . $number . '_icon', $item[0], sprintf( __( 'Investment Benefit %d Icon', 'rivross-corporate' ), $number ), 'rivross_real_estate_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_real_estate_why_' . $number . '_title', $item[1], sprintf( __( 'Investment Benefit %d Title', 'rivross-corporate' ), $number ), 'rivross_real_estate_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_real_estate_why_' . $number . '_description', $item[2], sprintf( __( 'Investment Benefit %d Description', 'rivross-corporate' ), $number ), 'rivross_real_estate_page', 'textarea', 'sanitize_textarea_field' );
	}

	$wp_customize->add_section(
		'rivross_projects_page',
		array(
			'title'       => __( 'Projects Page Settings', 'rivross-corporate' ),
			'description' => __( 'Control the Projects showcase hero and CTA. Manage project cards from Dashboard → Projects.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 95,
		)
	);
	$projects_fields = array(
		'rivross_projects_hero_line_1' => array( 'Our Projects,', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_projects_hero_line_2' => array( 'Building Better Tomorrows', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_projects_hero_description' => array( 'Discover our diverse portfolio of real estate developments that redefine modern living and create lasting value.', __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_projects_cta_title' => array( 'Let’s Build Something Great Together', __( 'CTA Title', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_projects_cta_description' => array( 'Have a project in mind? Partner with RIVROSS for trusted development and outstanding results.', __( 'CTA Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
	);
	foreach ( $projects_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_projects_page', $field[2], $field[3] );
	}
	rivross_add_theme_control( $wp_customize, 'rivross_projects_hero_image', get_theme_file_uri( '/assets/images/projects/projects-hero.png' ), __( 'Hero Background Image', 'rivross-corporate' ), 'rivross_projects_page', 'image', 'esc_url_raw' );

	$wp_customize->add_section(
		'rivross_travel_page',
		array(
			'title'       => __( 'Travel & Tourism Page Settings', 'rivross-corporate' ),
			'description' => __( 'Control every travel page section, service card, icon and image from one place.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 97,
		)
	);
	$travel_fields = array(
		'rivross_travel_breadcrumb_home'       => array( 'Home', __( 'Breadcrumb Home', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_breadcrumb_page'       => array( 'Travel & Tourism', __( 'Breadcrumb Page', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_hero_kicker'           => array( 'RIVROSS Travel & Tourism', __( 'Hero Kicker', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_hero_line_1'           => array( 'Travel Beyond Limits,', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_hero_line_2'           => array( 'Experience the World', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_hero_description'      => array( 'From air tickets to unforgettable journeys, we provide complete travel solutions tailored to your needs.', __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_travel_hero_button_label'     => array( 'Plan Your Journey', __( 'Hero Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_hero_button_url'       => array( '#travel-inquiry', __( 'Hero Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_travel_services_eyebrow'      => array( 'Our Services', __( 'Services Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_services_title'        => array( 'Complete Travel Solutions', __( 'Services Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_why_eyebrow'           => array( 'Why Choose RIVROSS?', __( 'Commitment Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_why_title'             => array( 'Your Journey, Our Commitment', __( 'Commitment Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_cta_title'             => array( 'Ready to Explore the World?', __( 'CTA Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_cta_description'       => array( 'Let us handle the details while you enjoy the experience.', __( 'CTA Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_travel_cta_button_label'      => array( 'Inquire Now', __( 'CTA Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_cta_button_url'        => array( '#travel-inquiry', __( 'CTA Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_travel_inquiry_eyebrow'       => array( 'Plan Your Journey With Us', __( 'Inquiry Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_travel_inquiry_description'   => array( 'Share your travel plans and we\'ll get back to you with the best options.', __( 'Inquiry Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
	);
	foreach ( $travel_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_travel_page', $field[2], $field[3] );
	}
	rivross_add_theme_control( $wp_customize, 'rivross_travel_hero_image', get_theme_file_uri( '/assets/images/travel/travel-hero.png' ), __( 'Hero Background Image', 'rivross-corporate' ), 'rivross_travel_page', 'image', 'esc_url_raw' );
	rivross_add_theme_control( $wp_customize, 'rivross_travel_why_image', get_theme_file_uri( '/assets/images/travel/travel-journey.png' ), __( 'Commitment Section Image', 'rivross-corporate' ), 'rivross_travel_page', 'image', 'esc_url_raw' );

	$travel_benefits = array(
		array( 'award', 'Best Prices', 'Competitive fares and best value' ),
		array( 'headset', 'Trusted Support', '24/7 assistance every step of the way' ),
		array( 'globe', 'Global Network', 'Partners worldwide to serve you better' ),
		array( 'shield', 'Safe & Secure', 'Your journey is our priority' ),
		array( 'target', 'Customized Trips', 'Tailored solutions for every traveler' ),
	);
	foreach ( $travel_benefits as $index => $item ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_travel_benefit_' . $number . '_icon', $item[0], sprintf( __( 'Benefit %d Icon', 'rivross-corporate' ), $number ), 'rivross_travel_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_travel_benefit_' . $number . '_title', $item[1], sprintf( __( 'Benefit %d Title', 'rivross-corporate' ), $number ), 'rivross_travel_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_travel_benefit_' . $number . '_description', $item[2], sprintf( __( 'Benefit %d Description', 'rivross-corporate' ), $number ), 'rivross_travel_page', 'textarea', 'sanitize_textarea_field' );
	}
	$travel_services = array(
		array( 'plane', 'service-air-ticketing.png', 'Air Ticketing', 'Domestic & international flight tickets with best prices and offers.' ),
		array( 'hotel', 'service-hotel-booking.png', 'Hotel Booking', 'Comfortable stays worldwide at exclusive rates.' ),
		array( 'suitcase', 'service-tour-packages.png', 'Tour Packages', 'Handpicked packages for leisure, adventure and group tours.' ),
		array( 'kaaba', 'service-hajj-umrah.png', 'Hajj & Umrah', 'Complete Hajj & Umrah services with care and guidance.' ),
		array( 'briefcase', 'service-corporate-travel.png', 'Corporate Travel', 'Business travel solutions designed for your corporate needs.' ),
	);
	foreach ( $travel_services as $index => $item ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_travel_service_' . $number . '_icon', $item[0], sprintf( __( 'Service %d Icon', 'rivross-corporate' ), $number ), 'rivross_travel_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_travel_service_' . $number . '_image', get_theme_file_uri( '/assets/images/travel/' . $item[1] ), sprintf( __( 'Service %d Image', 'rivross-corporate' ), $number ), 'rivross_travel_page', 'image', 'esc_url_raw' );
		rivross_add_theme_control( $wp_customize, 'rivross_travel_service_' . $number . '_title', $item[2], sprintf( __( 'Service %d Title', 'rivross-corporate' ), $number ), 'rivross_travel_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_travel_service_' . $number . '_description', $item[3], sprintf( __( 'Service %d Description', 'rivross-corporate' ), $number ), 'rivross_travel_page', 'textarea', 'sanitize_textarea_field' );
	}
	$travel_why_points = array(
		'Transparent pricing with no hidden charges',
		'Experienced team and 24/7 support',
		'Reliable partners worldwide',
		'Safe, secure and comfortable travel',
		'Thousands of happy travelers',
	);
	foreach ( $travel_why_points as $index => $point ) {
		rivross_add_theme_control( $wp_customize, 'rivross_travel_why_point_' . ( $index + 1 ), $point, sprintf( __( 'Commitment Point %d', 'rivross-corporate' ), $index + 1 ), 'rivross_travel_page' );
	}

	$wp_customize->add_section(
		'rivross_tea_page',
		array(
			'title'       => __( 'Tea Business Page Settings', 'rivross-corporate' ),
			'description' => __( 'Control every tea page section, service card, icon and image from one place.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 98,
		)
	);
	$tea_fields = array(
		'rivross_tea_breadcrumb_home'     => array( 'Home', __( 'Breadcrumb Home', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_breadcrumb_page'     => array( 'Tea Business', __( 'Breadcrumb Page', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_hero_kicker'         => array( 'RIVROSS Tea Business', __( 'Hero Kicker', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_hero_line_1'         => array( 'Finest Tea,', __( 'Hero Heading Line 1', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_hero_line_2'         => array( 'Sourced with Care', __( 'Hero Heading Line 2', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_hero_description'    => array( 'Delivering premium quality tea from the lush gardens of Bangladesh to homes and businesses around the world.', __( 'Hero Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_tea_hero_button_label'   => array( 'Discover Our Tea Solutions', __( 'Hero Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_hero_button_url'     => array( '#tea-inquiry', __( 'Hero Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_tea_services_eyebrow'    => array( 'Our Tea Solutions', __( 'Services Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_services_title'      => array( 'Quality Tea for Every Need', __( 'Services Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_why_eyebrow'         => array( 'Why Choose RIVROSS Tea?', __( 'Commitment Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_why_title'           => array( 'A Commitment to Excellence', __( 'Commitment Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_cta_title'           => array( 'Let’s Grow Together', __( 'CTA Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_cta_description'     => array( 'Partner with RIVROSS Tea for premium quality, reliable supply and business growth.', __( 'CTA Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_tea_cta_button_label'    => array( 'Business Inquiry', __( 'CTA Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_cta_button_url'      => array( '#tea-inquiry', __( 'CTA Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_tea_inquiry_eyebrow'     => array( 'Let’s Do Business Together', __( 'Inquiry Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_inquiry_title'       => array( 'Tell Us What You Need', __( 'Inquiry Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_tea_inquiry_description' => array( 'Tell us about your requirement and we’ll get back to you soon.', __( 'Inquiry Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
	);
	foreach ( $tea_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_tea_page', $field[2], $field[3] );
	}
	rivross_add_theme_control( $wp_customize, 'rivross_tea_hero_image', get_theme_file_uri( '/assets/images/tea/tea-hero.png' ), __( 'Hero Background Image', 'rivross-corporate' ), 'rivross_tea_page', 'image', 'esc_url_raw' );
	rivross_add_theme_control( $wp_customize, 'rivross_tea_why_image', get_theme_file_uri( '/assets/images/tea/tea-commitment.png' ), __( 'Commitment Section Image', 'rivross-corporate' ), 'rivross_tea_page', 'image', 'esc_url_raw' );
	rivross_add_theme_control( $wp_customize, 'rivross_tea_inquiry_image', get_theme_file_uri( '/assets/images/tea/service-corporate-supply.png' ), __( 'Inquiry Section Image', 'rivross-corporate' ), 'rivross_tea_page', 'image', 'esc_url_raw' );

	$tea_benefits = array(
		array( 'leaf', 'Premium Quality', 'Carefully selected finest tea leaves' ),
		array( 'sprout', 'Sustainable Sourcing', 'Ethical practices for a better tomorrow' ),
		array( 'suitcase', 'Wholesale Supply', 'Bulk supply with consistent quality' ),
		array( 'briefcase', 'Timely Delivery', 'Reliable logistics you can trust' ),
		array( 'users', 'Customer Focused', 'Dedicated support for your needs' ),
		array( 'shield', 'Global Standards', 'International quality and safety assured' ),
	);
	foreach ( $tea_benefits as $index => $item ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_tea_benefit_' . $number . '_icon', $item[0], sprintf( __( 'Benefit %d Icon', 'rivross-corporate' ), $number ), 'rivross_tea_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_tea_benefit_' . $number . '_title', $item[1], sprintf( __( 'Benefit %d Title', 'rivross-corporate' ), $number ), 'rivross_tea_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_tea_benefit_' . $number . '_description', $item[2], sprintf( __( 'Benefit %d Description', 'rivross-corporate' ), $number ), 'rivross_tea_page', 'textarea', 'sanitize_textarea_field' );
	}
	$tea_services = array(
		array( 'leaf', 'service-tea-sourcing.png', 'Tea Sourcing', 'We source the finest tea directly from trusted gardens across Bangladesh.' ),
		array( 'building', 'service-wholesale-supply.png', 'Wholesale Supply', 'Bulk supply for distributors, retailers and tea importers worldwide.' ),
		array( 'sprout', 'service-blending-packing.png', 'Blending & Packing', 'Expert blending and hygienic packing to preserve freshness and flavor.' ),
		array( 'globe', 'service-distribution.png', 'Distribution', 'Efficient distribution network ensuring on-time delivery every time.' ),
		array( 'users', 'service-corporate-supply.png', 'Corporate Supply', 'Tailored tea solutions for hotels, cafes and corporate clients.' ),
	);
	foreach ( $tea_services as $index => $item ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_tea_service_' . $number . '_icon', $item[0], sprintf( __( 'Service %d Icon', 'rivross-corporate' ), $number ), 'rivross_tea_page', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );
		rivross_add_theme_control( $wp_customize, 'rivross_tea_service_' . $number . '_image', get_theme_file_uri( '/assets/images/tea/' . $item[1] ), sprintf( __( 'Service %d Image', 'rivross-corporate' ), $number ), 'rivross_tea_page', 'image', 'esc_url_raw' );
		rivross_add_theme_control( $wp_customize, 'rivross_tea_service_' . $number . '_title', $item[2], sprintf( __( 'Service %d Title', 'rivross-corporate' ), $number ), 'rivross_tea_page' );
		rivross_add_theme_control( $wp_customize, 'rivross_tea_service_' . $number . '_description', $item[3], sprintf( __( 'Service %d Description', 'rivross-corporate' ), $number ), 'rivross_tea_page', 'textarea', 'sanitize_textarea_field' );
	}
	$tea_why_points = array(
		'100% authentic Bangladeshi tea',
		'Consistent quality, taste and aroma',
		'Competitive wholesale prices',
		'Flexible supply for all business sizes',
		'Reliable service and long-term partnership',
	);
	foreach ( $tea_why_points as $index => $point ) {
		rivross_add_theme_control( $wp_customize, 'rivross_tea_why_point_' . ( $index + 1 ), $point, sprintf( __( 'Commitment Point %d', 'rivross-corporate' ), $index + 1 ), 'rivross_tea_page' );
	}

	$wp_customize->add_section(
		'rivross_footer_settings',
		array(
			'title'       => __( 'Footer Settings', 'rivross-corporate' ),
			'description' => __( 'Manage footer content, contact information and social links.', 'rivross-corporate' ),
			'panel'       => 'rivross_theme_settings',
			'priority'    => 100,
		)
	);

	$footer_fields = array(
		'rivross_footer_description' => array( 'A diversified business organization committed to delivering value through multiple sectors and creating opportunities for everyone.', __( 'Footer Description', 'rivross-corporate' ), 'textarea' ),
		'rivross_contact_address'    => array( '3/3 Matuail Junglebari, Jatrabari, Dhaka-1362, Bangladesh', __( 'Office Address', 'rivross-corporate' ), 'textarea' ),
		'rivross_contact_email'      => array( 'rivrossgroup@gmail.com', __( 'Contact Email', 'rivross-corporate' ), 'email' ),
		'rivross_contact_phone'      => array( '01796-566279', __( 'Contact Phone', 'rivross-corporate' ), 'text' ),
	);

	foreach ( $footer_fields as $setting_id => $field ) {
		$sanitize = 'email' === $field[2] ? 'sanitize_email' : ( 'textarea' === $field[2] ? 'sanitize_textarea_field' : 'sanitize_text_field' );
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_footer_settings', $field[2], $sanitize );
	}

	$footer_copy_fields = array(
		'rivross_footer_cta_eyebrow'        => array( 'Connect with RIVROSS', __( 'CTA Eyebrow', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_footer_cta_title'          => array( 'Looking for a business opportunity or professional service?', __( 'CTA Title', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_footer_cta_description'    => array( 'Connect with RIVROSS Company Limited today.', __( 'CTA Description', 'rivross-corporate' ), 'textarea', 'sanitize_textarea_field' ),
		'rivross_footer_cta_primary_label'  => array( 'Send an Inquiry', __( 'CTA Primary Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_footer_cta_primary_url'    => array( '#contact', __( 'CTA Primary Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_footer_cta_secondary_label' => array( 'Contact Us', __( 'CTA Secondary Button Label', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_footer_cta_secondary_url'   => array( '#contact', __( 'CTA Secondary Button URL', 'rivross-corporate' ), 'url', 'esc_url_raw' ),
		'rivross_footer_quick_links_title'   => array( 'Quick Links', __( 'Quick Links Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_footer_businesses_title'    => array( 'Our Businesses', __( 'Businesses Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_footer_contact_title'       => array( 'Contact Information', __( 'Contact Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_footer_legal_title'        => array( 'Legal', __( 'Legal Heading', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_footer_hours'               => array( 'Saturday - Thursday | 10:00 AM - 07:00 PM', __( 'Opening Hours', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_footer_copyright'           => array( 'RIVROSS Company Limited. All Rights Reserved.', __( 'Copyright Text', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
		'rivross_footer_bottom_note'         => array( 'Designed with Excellence for a Better Tomorrow', __( 'Footer Bottom Note', 'rivross-corporate' ), 'text', 'sanitize_text_field' ),
	);

	foreach ( $footer_copy_fields as $setting_id => $field ) {
		rivross_add_theme_control( $wp_customize, $setting_id, $field[0], $field[1], 'rivross_footer_settings', $field[2], $field[3] );
	}
	rivross_add_theme_control( $wp_customize, 'rivross_footer_cta_icon', 'phone', __( 'CTA Icon', 'rivross-corporate' ), 'rivross_footer_settings', 'select', 'rivross_sanitize_icon_choice', array( 'choices' => rivross_icon_choices() ) );

	$footer_business_defaults = array(
		array( 'Real Estate', home_url( '/real-estate/' ) ),
		array( 'Travel & Tourism', home_url( '/travel-tourism/' ) ),
		array( 'Tea Business', home_url( '/tea-business/' ) ),
	);
	foreach ( $footer_business_defaults as $index => $business ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_footer_business_' . $number . '_label', $business[0], sprintf( __( 'Business Link %d Label', 'rivross-corporate' ), $number ), 'rivross_footer_settings' );
		rivross_add_theme_control( $wp_customize, 'rivross_footer_business_' . $number . '_url', $business[1], sprintf( __( 'Business Link %d URL', 'rivross-corporate' ), $number ), 'rivross_footer_settings', 'url', 'esc_url_raw' );
	}

	$footer_legal_defaults = array(
		array( 'Terms & Conditions', '/terms-and-conditions/' ),
		array( 'Privacy Policy', '/privacy-policy/' ),
	);
	foreach ( $footer_legal_defaults as $index => $legal ) {
		$number = $index + 1;
		rivross_add_theme_control( $wp_customize, 'rivross_footer_legal_' . $number . '_label', $legal[0], sprintf( __( 'Legal Link %d Label', 'rivross-corporate' ), $number ), 'rivross_footer_settings' );
		rivross_add_theme_control( $wp_customize, 'rivross_footer_legal_' . $number . '_url', home_url( $legal[1] ), sprintf( __( 'Legal Link %d URL', 'rivross-corporate' ), $number ), 'rivross_footer_settings', 'url', 'esc_url_raw' );
	}

	foreach ( array( 'facebook', 'linkedin', 'youtube', 'instagram' ) as $social ) {
		$setting_id = 'rivross_social_' . $social;
		/* translators: %s is the social network name. */
		rivross_add_theme_control( $wp_customize, $setting_id, '', sprintf( __( '%s URL', 'rivross-corporate' ), ucfirst( $social ) ), 'rivross_footer_settings', 'url', 'esc_url_raw' );
	}
}
add_action( 'customize_register', 'rivross_customize_register' );

function rivross_customizer_css() {
	$font_body    = rivross_sanitize_font_choice( get_theme_mod( 'rivross_font_body', 'Montserrat' ) );
	$font_display = rivross_sanitize_font_choice( get_theme_mod( 'rivross_font_display', 'Cormorant Garamond' ) );
	$font_sizes   = array(
		'--rivross-size-body'    => array( 'rivross_font_size_body', 16 ),
		'--rivross-line-body'    => array( 'rivross_line_height_body', 1.65 ),
		'--rivross-size-nav'     => array( 'rivross_font_size_nav', 11 ),
		'--rivross-size-button'  => array( 'rivross_font_size_button', 12 ),
		'--rivross-size-eyebrow' => array( 'rivross_font_size_eyebrow', 12 ),
		'--rivross-size-h1'      => array( 'rivross_font_size_h1', 77 ),
		'--rivross-size-h2'      => array( 'rivross_font_size_h2', 56 ),
		'--rivross-size-h3'      => array( 'rivross_font_size_h3', 38 ),
		'--rivross-size-card'    => array( 'rivross_font_size_card', 20 ),
		'--rivross-size-hero'    => array( 'rivross_font_size_hero', 64 ),
		'--rivross-size-small'   => array( 'rivross_font_size_small', 12 ),
	);

	$css = ':root {';
	$css .= '--rivross-color-navy:' . sanitize_hex_color( get_theme_mod( 'rivross_color_navy', '#061a36' ) ) . ';';
	$css .= '--rivross-color-navy-2:' . sanitize_hex_color( get_theme_mod( 'rivross_color_navy_2', '#0b2a4a' ) ) . ';';
	$css .= '--rivross-color-gold:' . sanitize_hex_color( get_theme_mod( 'rivross_color_gold', '#c9962d' ) ) . ';';
	$css .= '--rivross-color-gold-light:' . sanitize_hex_color( get_theme_mod( 'rivross_color_gold_light', '#e8c06a' ) ) . ';';
	$css .= '--rivross-color-ink:' . sanitize_hex_color( get_theme_mod( 'rivross_color_ink', '#17243a' ) ) . ';';
	$css .= '--rivross-color-surface:' . sanitize_hex_color( get_theme_mod( 'rivross_color_surface', '#f7f8fa' ) ) . ';';
	$css .= '--rivross-font-body:"' . esc_attr( $font_body ) . '", "Segoe UI", Arial, sans-serif;';
	$css .= '--rivross-font-display:"' . esc_attr( $font_display ) . '", Georgia, serif;';
	foreach ( $font_sizes as $css_var => $font_size ) {
		$value = '--rivross-line-body' === $css_var ? rivross_sanitize_line_height( get_theme_mod( $font_size[0], $font_size[1] ) ) : rivross_sanitize_font_size( get_theme_mod( $font_size[0], $font_size[1] ) );
		$css  .= $css_var . ':' . $value . ( '--rivross-line-body' === $css_var ? ';' : 'px;' );
	}
	$css .= '}';

	wp_add_inline_style( 'rivross-style', $css );
}
add_action( 'wp_enqueue_scripts', 'rivross_customizer_css', 20 );
