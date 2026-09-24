( function ( $ ) {
	'use strict';

	/* Keep page controls page-first: every page owns its sections inside Page Settings. */
	var groups = [
		{
			id: 'access-mode',
			title: 'Site Access & Launch Mode',
			anchor: 'rivross_site_access',
			sections: [ 'rivross_site_access' ],
			single: true
		},
		{
			id: 'pages',
			title: 'Page Settings',
			anchor: 'rivross_home_page',
			children: [
				{
					id: 'home-page',
					title: 'Home Page Settings',
					anchor: 'rivross_home_page',
					sections: [
						'rivross_home_page',
						'rivross_home_about',
						'rivross_home_businesses',
						'rivross_home_services',
						'rivross_home_showcase',
						'rivross_home_leadership'
					]
				},
				{
					id: 'about-page',
					title: 'About Us Page Settings',
					anchor: 'rivross_about_page',
					sections: [ 'rivross_about_page' ],
					single: true
				},
				{
					id: 'companies-page',
					title: 'Our Companies Page Settings',
					anchor: 'rivross_companies_page',
					sections: [ 'rivross_companies_page' ],
					single: true
				},
				{
					id: 'news-page',
					title: 'News & Media Page Settings',
					anchor: 'rivross_news_media_page',
					sections: [ 'rivross_news_media_page' ],
					single: true
				},
				{
					id: 'events-page',
					title: 'Events Page Settings',
					anchor: 'rivross_events_page',
					sections: [ 'rivross_events_page' ],
					single: true
				},
				{
					id: 'real-estate-page',
					title: 'Real Estate Page Settings',
					anchor: 'rivross_real_estate_page',
					sections: [ 'rivross_real_estate_page' ],
					single: true
				},
				{
					id: 'projects-page',
					title: 'Projects Page Settings',
					anchor: 'rivross_projects_page',
					sections: [ 'rivross_projects_page' ],
					single: true
				},
				{
					id: 'travel-page',
					title: 'Travel & Tourism Page Settings',
					anchor: 'rivross_travel_page',
					sections: [ 'rivross_travel_page' ],
					single: true
				},
				{
					id: 'tea-page',
					title: 'Tea Business Page Settings',
					anchor: 'rivross_tea_page',
					sections: [ 'rivross_tea_page' ],
					single: true
				},
				{
					id: 'contact-page',
					title: 'Contact Us Page Settings',
					anchor: 'rivross_contact_page',
					sections: [ 'rivross_contact_page' ],
					single: true
				},
				{
					id: 'leadership-page',
					title: 'Leadership Page Settings',
					anchor: 'rivross_management_page',
					sections: [ 'rivross_management_page' ],
					single: true
				},
				{
					id: 'careers-page',
					title: 'Careers Page Settings',
					anchor: 'rivross_careers_page',
					sections: [ 'rivross_careers_page' ],
					single: true
				},
				{
					id: 'other-pages',
					title: 'Other Pages Settings',
					anchor: 'rivross_other_pages',
					sections: [ 'rivross_other_pages' ],
					single: true
				}
			]
		}
	];

	function sectionElement( sectionId ) {
		return $( '#accordion-section-' + sectionId );
	}

	function makeGroup( group ) {
		var $group = $( '<li />', {
			'class': 'accordion-section control-section rivross-settings-group rivross-settings-group--' + group.id,
			'id': 'rivross-settings-group-' + group.id
		} );
		var $heading = $( '<h3 />', { 'class': 'accordion-section-title' } );
		var $button = $( '<button />', {
			'type': 'button',
			'class': 'rivross-settings-group__trigger',
			'aria-expanded': 'false',
			'aria-controls': 'rivross-settings-group-' + group.id + '-children'
		} ).text( group.title );
		var $children = $( '<ul />', {
			'class': 'rivross-settings-group__children',
			'id': 'rivross-settings-group-' + group.id + '-children',
			'aria-label': group.title + ' sections'
		} );

		if ( group.single ) {
			$group.attr( 'data-rivross-section', group.anchor );
			$button.attr( 'aria-controls', '' );
		}

		$heading.append( $button );
		$group.append( $heading, $children );
		return $group;
	}

	function focusSection( sectionId ) {
		if ( window.wp && wp.customize && wp.customize.section( sectionId ) ) {
			wp.customize.section( sectionId ).focus();
		}
	}

	function sectionTitle( sectionId ) {
		var section = wp.customize.section( sectionId );
		if ( section && section.params && section.params.title ) {
			return $( '<div />' ).html( section.params.title ).text();
		}

		var title = sectionElement( sectionId ).find( '.accordion-section-title' ).first().clone().children().remove().end().text();
		return $.trim( title ).replace( /[›]+$/, '' );
	}

	function makeSectionLink( sectionId ) {
		var $link = $( '<li />', { 'class': 'rivross-settings-section-link' } );
		var $button = $( '<button />', {
			'type': 'button',
			'class': 'rivross-settings-section-link__trigger',
			'aria-controls': 'accordion-section-' + sectionId
		} ).text( sectionTitle( sectionId ) );
		$link.append( $button );
		$link.on( 'click', function ( event ) {
			event.preventDefault();
			focusSection( sectionId );
		} );
		return $link;
	}

	function bindNativeSection( sectionId ) {
		var $section = sectionElement( sectionId );
		if ( ! $section.length || $section.data( 'rivross-bound' ) ) {
			return;
		}

		$section.addClass( 'rivross-settings-native-section' ).data( 'rivross-bound', true );
		var section = wp.customize.section( sectionId );
		if ( ! section || ! section.expanded ) {
			return;
		}

		var syncVisibility = function ( expanded ) {
			$section.toggleClass( 'rivross-settings-native-section--open', !! expanded );
		};
		syncVisibility( section.expanded() );
		section.expanded.bind( syncVisibility );
	}

	function renderGroup( group, $container, isRoot ) {
		var groupId = '#rivross-settings-group-' + group.id;
		var $group = $( groupId );

		if ( ! $group.length ) {
			$group = makeGroup( group );
			if ( isRoot ) {
				var $anchor = sectionElement( group.anchor );
				if ( $anchor.length ) {
					$anchor.before( $group );
				} else {
					$container.prepend( $group );
				}
			} else {
				$container.append( $group );
			}
		}

		var $children = $group.children( '.rivross-settings-group__children' );
		( group.sections || [] ).forEach( function ( sectionId ) {
			bindNativeSection( sectionId );
			if ( ! group.single && ! group.children && $children.find( '[aria-controls="accordion-section-' + sectionId + '"]' ).length === 0 ) {
				$children.append( makeSectionLink( sectionId ) );
			}
		} );

		( group.children || [] ).forEach( function ( child ) {
			renderGroup( child, $children, false );
		} );

		if ( group.single ) {
			$children.empty();
			$group.removeClass( 'is-expanded' );
			$group.find( '.rivross-settings-group__trigger' ).attr( 'aria-expanded', 'false' );
		}
	}

	function groupSections() {
		var $panel = $( '#sub-accordion-panel-rivross_theme_settings' );

		if ( ! $panel.length ) {
			return;
		}

		groups.forEach( function ( group ) {
			renderGroup( group, $panel, true );
		} );
	}

	function expandGroup( $button ) {
		var expanded = 'true' === $button.attr( 'aria-expanded' );
		$button.attr( 'aria-expanded', expanded ? 'false' : 'true' );
		$button.closest( '.rivross-settings-group' ).toggleClass( 'is-expanded', ! expanded );
	}

	function customizerText( key, fallback ) {
		if ( window.rivrossCustomizerL10n && window.rivrossCustomizerL10n[ key ] ) {
			return window.rivrossCustomizerL10n[ key ];
		}
		return fallback;
	}

	function parsePartnerGallery( value ) {
		var parsed = value;
		if ( typeof parsed === 'string' ) {
			try {
				parsed = JSON.parse( parsed );
			} catch ( error ) {
				parsed = [];
			}
		}
		if ( ! Array.isArray( parsed ) ) {
			return [];
		}
		return parsed.filter( function ( url ) {
			return typeof url === 'string' && url.trim();
		} ).slice( 0, 8 );
	}

	function initPartnerGalleryControls() {
		if ( ! window.wp || ! wp.customize || ! wp.media ) {
			return;
		}

		$( '.rivross-partner-gallery' ).each( function () {
			var $gallery = $( this );
			if ( $gallery.data( 'rivross-bound' ) ) {
				return;
			}

			var settingId = $gallery.attr( 'data-setting-id' );
			var control = settingId ? wp.customize.control( settingId ) : null;
			if ( ! control || ! control.setting ) {
				return;
			}

			$gallery.data( 'rivross-bound', true );
			var setting = control.setting;
			var maxItems = parseInt( $gallery.attr( 'data-max' ), 10 ) || 8;
			var $value = $gallery.find( '.rivross-partner-gallery__value' );
			var $choose = $gallery.find( '.rivross-partner-gallery__choose' );
			var $clear = $gallery.find( '.rivross-partner-gallery__clear' );
			var $status = $gallery.find( '.rivross-partner-gallery__status' );
			var $previews = $gallery.find( '.rivross-partner-gallery__previews' );

			function values() {
				return parsePartnerGallery( setting.get() || $value.val() );
			}

			function setValues( urls ) {
				var next = parsePartnerGallery( urls ).slice( 0, maxItems );
				setting.set( JSON.stringify( next ) );
			}

			function render() {
				var urls = values();
				$value.val( JSON.stringify( urls ) );
				$previews.empty();
				$clear.prop( 'hidden', ! urls.length );
				$status.text( urls.length ? urls.length + ' ' + customizerText( 'partnerGallerySelected', 'logo images selected' ) : customizerText( 'partnerGalleryEmpty', 'No logo images selected' ) );

				urls.forEach( function ( url, index ) {
					var $item = $( '<li />', { 'class': 'rivross-partner-gallery__item' } );
					var $thumb = $( '<img />', { 'class': 'rivross-partner-gallery__thumb', alt: 'Partner ' + ( index + 1 ) + ' logo', src: url } );
					var $number = $( '<span />', { 'class': 'rivross-partner-gallery__number' } ).text( String( index + 1 ) );
					var $remove = $( '<button />', { 'class': 'button-link rivross-partner-gallery__remove', type: 'button', 'aria-label': customizerText( 'partnerGalleryRemove', 'Remove this logo' ) } ).text( '×' );
					$remove.on( 'click', function () {
						var next = values();
						next.splice( index, 1 );
						setValues( next );
					} );
					$item.append( $thumb, $number, $remove );
					$previews.append( $item );
				} );
			}

			$choose.on( 'click', function () {
				var frame = wp.media( {
					title: customizerText( 'partnerGalleryTitle', 'Choose partner logo images' ),
					button: { text: customizerText( 'partnerGalleryUse', 'Use selected logos' ) },
					library: { type: 'image' },
					multiple: true
				} );
				frame.on( 'select', function () {
					var selection = frame.state().get( 'selection' );
					var selected = [];
					selection.each( function ( attachment ) {
						var url = attachment.get( 'url' );
						if ( url && selected.indexOf( url ) === -1 ) {
							selected.push( url );
						}
					} );
					if ( selected.length > maxItems ) {
						$status.text( customizerText( 'partnerGalleryLimit', 'Only the first 8 selected logos were kept.' ) );
					}
					setValues( selected );
				} );
				frame.open();
			} );
			$clear.on( 'click', function () {
				setValues( [] );
			} );
			setting.bind( render );
			render();
		} );
	}

	function addToolbar() {
		var $panel = $( '#sub-accordion-panel-rivross_theme_settings' );
		if ( ! $panel.length || $panel.find( '.rivross-settings-toolbar' ).length ) {
			return;
		}

		var $toolbar = $( '<div />', {
			'class': 'rivross-settings-toolbar',
			'role': 'toolbar',
			'aria-label': customizerText( 'toolbarLabel', 'Theme settings tools' )
		} );
		var $tip = $( '<p />', {
			'class': 'rivross-settings-toolbar__tip'
		} ).text( customizerText( 'toolbarTip', 'Choose a page group below, then edit its content and publish your changes.' ) );
		var $actions = $( '<div />', { 'class': 'rivross-settings-toolbar__actions' } );
		var $expand = $( '<button />', {
			'type': 'button',
			'class': 'button button-secondary rivross-settings-toolbar__button'
		} ).text( customizerText( 'expandAll', 'Expand all' ) );
		var $collapse = $( '<button />', {
			'type': 'button',
			'class': 'button button-secondary rivross-settings-toolbar__button'
		} ).text( customizerText( 'collapseAll', 'Collapse all' ) );

		$expand.on( 'click', function () {
			$( '.rivross-settings-group' ).each( function () {
				var $group = $( this );
				if ( ! $group.data( 'rivross-section' ) ) {
					$group.addClass( 'is-expanded' ).find( '.rivross-settings-group__trigger' ).first().attr( 'aria-expanded', 'true' );
				}
			} );
		} );
		$collapse.on( 'click', function () {
			$( '.rivross-settings-group' ).each( function () {
				var $group = $( this );
				$group.removeClass( 'is-expanded' ).find( '.rivross-settings-group__trigger' ).first().attr( 'aria-expanded', 'false' );
			} );
		} );

		$actions.append( $expand, $collapse );
		$toolbar.append( $tip, $actions );
		$panel.prepend( $toolbar );
	}

	$( function () {
		if ( ! window.wp || ! wp.customize ) {
			return;
		}

		groupSections();
		addToolbar();
		initPartnerGalleryControls();
		window.setTimeout( groupSections, 250 );
		window.setTimeout( addToolbar, 250 );
		window.setTimeout( initPartnerGalleryControls, 250 );
		$( document ).on( 'click', '.rivross-settings-group__trigger', function ( event ) {
			event.preventDefault();
			var $group = $( this ).closest( '.rivross-settings-group' );
			if ( $group.data( 'rivross-section' ) ) {
				focusSection( $group.data( 'rivross-section' ) );
				return;
			}
			expandGroup( $( this ) );
		} );
		wp.customize.bind( 'pane-contents-reflowed', function () {
			window.setTimeout( function () {
					groupSections();
					addToolbar();
					initPartnerGalleryControls();
				}, 0 );
		} );
		if ( wp.customize.panel( 'rivross_theme_settings' ) ) {
			wp.customize.panel( 'rivross_theme_settings' ).expanded.bind( function ( expanded ) {
				if ( expanded ) {
					window.setTimeout( function () {
						groupSections();
						addToolbar();
						initPartnerGalleryControls();
					}, 0 );
				}
			} );
		}
	} );
}( jQuery ) );
