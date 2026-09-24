( function () {
	'use strict';

	function toNumber( value, fallback ) {
		var number = parseInt( value, 10 );
		return Number.isFinite( number ) && number > 0 ? number : fallback;
	}

	document.querySelectorAll( '[data-rivross-hero-carousel]' ).forEach( function ( root ) {
		var slides = Array.prototype.slice.call( root.querySelectorAll( '.home-hero__slide' ) );
		var pager = root.querySelector( '.home-hero__pager' );
		var previous = root.querySelector( '.home-hero__control--prev' );
		var next = root.querySelector( '.home-hero__control--next' );
		var enabled = root.dataset.enabled !== '0';
		var autoplay = root.dataset.autoplay === '1';
		var showArrows = root.dataset.showArrows === '1';
		var showDots = root.dataset.showDots !== '0';
		var interval = Math.max( 2500, toNumber( root.dataset.interval, 6000 ) );
		var current = 0;
		var timer = null;
		var pointerStart = null;

		if ( ! slides.length ) {
			return;
		}

		/*
		 * Slide copy is editable, so a longer title or description must be able
		 * to grow the hero at every viewport width instead of being clipped by a
		 * fixed height. Every slide is measured so changing slides never causes a
		 * shorter wrapper or a sudden layout jump.
		 */
		function syncHeroHeight() {
			/* Read the stylesheet baseline without an earlier inline override. */
			root.style.removeProperty( 'min-height' );
			var baseline = parseFloat( window.getComputedStyle( root ).minHeight ) || 0;
			var contentHeight = 0;
			slides.forEach( function ( slide ) {
				var copy = slide.querySelector( '.home-hero__copy' );
				if ( copy ) {
					contentHeight = Math.max( contentHeight, Math.ceil( copy.getBoundingClientRect().height ) );
				}
			} );
			if ( contentHeight > baseline ) {
				root.style.minHeight = contentHeight + 'px';
			}
		}

		function buildPager() {
			if ( ! pager ) {
				return;
			}
			pager.innerHTML = '';
			slides.forEach( function ( slide, index ) {
				var dot = document.createElement( 'button' );
				dot.type = 'button';
				dot.className = 'home-hero__dot';
				dot.setAttribute( 'role', 'tab' );
				dot.setAttribute( 'aria-label', 'Go to hero slide ' + ( index + 1 ) );
				dot.dataset.slide = String( index );
				dot.addEventListener( 'click', function ( event ) {
					goTo( toNumber( event.currentTarget.dataset.slide, 0 ), true );
				} );
				pager.appendChild( dot );
			} );
		}

		function update() {
			slides.forEach( function ( slide, index ) {
				var active = index === current;
				slide.classList.toggle( 'is-active', active );
				slide.setAttribute( 'aria-hidden', active ? 'false' : 'true' );
				slide.inert = ! active;
			} );
			if ( pager ) {
				pager.hidden = ! enabled || ! showDots || slides.length <= 1;
				Array.prototype.forEach.call( pager.children, function ( dot, index ) {
					var active = index === current;
					dot.classList.toggle( 'is-active', active );
					dot.setAttribute( 'aria-selected', active ? 'true' : 'false' );
					dot.tabIndex = active ? 0 : -1;
				} );
			}
			if ( previous ) {
				previous.hidden = ! enabled || ! showArrows || slides.length <= 1;
			}
			if ( next ) {
				next.hidden = ! enabled || ! showArrows || slides.length <= 1;
			}
			syncHeroHeight();
		}

		function goTo( index, userInitiated ) {
			if ( ! enabled || slides.length <= 1 ) {
				return;
			}
			if ( index < 0 ) {
				index = slides.length - 1;
			} else if ( index >= slides.length ) {
				index = 0;
			}
			current = index;
			update();
			if ( userInitiated ) {
				startAutoplay();
			}
		}

		function stopAutoplay() {
			if ( timer ) {
				window.clearInterval( timer );
				timer = null;
			}
		}

		function startAutoplay() {
			stopAutoplay();
			if ( ! enabled || ! autoplay || slides.length <= 1 || ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) || document.hidden ) {
				return;
			}
			timer = window.setInterval( function () {
				goTo( current + 1, false );
			}, interval );
		}

		if ( previous ) {
			previous.addEventListener( 'click', function () {
				goTo( current - 1, true );
			} );
		}
		if ( next ) {
			next.addEventListener( 'click', function () {
				goTo( current + 1, true );
			} );
		}

		root.addEventListener( 'mouseenter', stopAutoplay );
		root.addEventListener( 'mouseleave', startAutoplay );
		root.addEventListener( 'focusin', stopAutoplay );
		root.addEventListener( 'focusout', function ( event ) {
			if ( ! root.contains( event.relatedTarget ) ) {
				startAutoplay();
			}
		} );
		root.addEventListener( 'keydown', function ( event ) {
			if ( 'ArrowLeft' === event.key ) {
				event.preventDefault();
				goTo( current - 1, true );
			} else if ( 'ArrowRight' === event.key ) {
				event.preventDefault();
				goTo( current + 1, true );
			}
		} );
		root.addEventListener( 'pointerdown', function ( event ) {
			if ( 'mouse' === event.pointerType && 0 !== event.button ) {
				return;
			}
			pointerStart = event.clientX;
			stopAutoplay();
		} );
		root.addEventListener( 'pointerup', function ( event ) {
			if ( null === pointerStart ) {
				return;
			}
			var distance = event.clientX - pointerStart;
			pointerStart = null;
			if ( Math.abs( distance ) > 40 ) {
				goTo( current + ( distance < 0 ? 1 : -1 ), true );
			} else {
				startAutoplay();
			}
		} );
		root.addEventListener( 'pointercancel', function () {
			pointerStart = null;
			startAutoplay();
		} );
		document.addEventListener( 'visibilitychange', function () {
			if ( document.hidden ) {
				stopAutoplay();
			} else {
				startAutoplay();
			}
		} );
		window.addEventListener( 'resize', syncHeroHeight, { passive: true } );
		if ( document.fonts && document.fonts.ready ) {
			document.fonts.ready.then( syncHeroHeight );
		}
		if ( window.ResizeObserver ) {
			var copyObserver = new ResizeObserver( syncHeroHeight );
			slides.forEach( function ( slide ) {
				var copy = slide.querySelector( '.home-hero__copy' );
				if ( copy ) {
					copyObserver.observe( copy );
				}
			} );
		}

		buildPager();
		update();
		startAutoplay();
		root.classList.add( 'home-hero--ready' );
	} );
}() );
