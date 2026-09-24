( function () {
	'use strict';

	function toNumber( value, fallback ) {
		var number = parseInt( value, 10 );
		return Number.isFinite( number ) && number > 0 ? number : fallback;
	}

	function initCarousel( root ) {
		var viewportSelector = root.dataset.viewportSelector || '.leadership-carousel__viewport';
		var trackSelector = root.dataset.trackSelector || '.leadership-carousel__track';
		var slideSelector = root.dataset.slideSelector || '.leadership-carousel__slide';
		var previousSelector = root.dataset.previousSelector || '.leadership-carousel__control--prev';
		var nextSelector = root.dataset.nextSelector || '.leadership-carousel__control--next';
		var emptyClass = root.dataset.emptyClass || 'leadership-carousel--empty';
		var staticClass = root.dataset.staticClass || 'leadership-carousel--static';
		var readyClass = root.dataset.readyClass || 'leadership-carousel--ready';
		var multipleClass = root.dataset.multipleClass || 'has-multiple-slides';
		var dotLabel = root.dataset.dotLabel || 'leadership';
		var viewport = root.querySelector( viewportSelector );
		var track = root.querySelector( trackSelector );
		var slides = track ? Array.prototype.slice.call( track.querySelectorAll( slideSelector ) ) : [];
		var dots = root.querySelector( '.carousel-dots' );
		var previous = root.querySelector( previousSelector );
		var next = root.querySelector( nextSelector );
		var enabled = root.dataset.enabled !== '0';
		var autoplay = root.dataset.autoplay === '1';
		var showArrows = root.dataset.showArrows === '1';
		var showDots = root.dataset.showDots !== '0';
		var interval = Math.max( 2000, toNumber( root.dataset.interval, 5000 ) );
		var currentIndex = 0;
		var perView = 1;
		var pageCount = 1;
		var timer = null;
		var resizeTimer = null;
		var pointerStart = null;
		var isAnimating = false;
		var transitionMs = 560;

		if ( ! track || ! slides.length ) {
			root.classList.add( emptyClass );
			return;
		}

		slides.forEach( function ( slide, index ) {
			slide.dataset.rivrossSlideIndex = String( index );
		} );

		if ( ! enabled ) {
			root.classList.add( staticClass );
			return;
		}

		function getSlides() {
			return Array.prototype.slice.call( track.children );
		}

		function getPerView() {
			var width = window.innerWidth || document.documentElement.clientWidth;
			if ( width <= 600 ) {
				return Math.min( slides.length, toNumber( root.dataset.mobile, 2 ) );
			}
			if ( width <= 1100 ) {
				return Math.min( slides.length, toNumber( root.dataset.tablet, 2 ) );
			}
			return Math.min( slides.length, toNumber( root.dataset.desktop, 4 ) );
		}

		function getStep() {
			var width = viewport ? viewport.getBoundingClientRect().width : root.getBoundingClientRect().width;
			var styles = window.getComputedStyle( track );
			var gap = parseFloat( styles.columnGap || styles.gap ) || 0;
			return Math.max( 0, ( width - ( gap * ( perView - 1 ) ) ) / perView + gap );
		}

		function getCurrentIndex() {
			var first = track.firstElementChild;
			return first && first.dataset.rivrossSlideIndex ? parseInt( first.dataset.rivrossSlideIndex, 10 ) : 0;
		}

		function resetPosition() {
			track.style.transition = 'none';
			track.style.transform = 'translate3d(0, 0, 0)';
			/* Force the browser to commit the reset before restoring the easing. */
			void track.offsetWidth;
			track.style.transition = '';
		}

		function buildDots() {
			if ( ! dots ) {
				return;
			}
			dots.innerHTML = '';
			for ( var index = 0; index < pageCount; index += 1 ) {
				var dot = document.createElement( 'button' );
				dot.type = 'button';
				dot.className = 'carousel-dot';
				dot.setAttribute( 'role', 'tab' );
				dot.setAttribute( 'aria-label', 'Go to ' + dotLabel + ' ' + ( index + 1 ) );
				dot.dataset.slide = String( index );
				dot.addEventListener( 'click', function ( event ) {
					jumpTo( toNumber( event.currentTarget.dataset.slide, 0 ), true );
				} );
				dots.appendChild( dot );
			}
		}

		function update() {
			var orderedSlides = getSlides();
			currentIndex = getCurrentIndex();
			track.style.setProperty( '--rivross-carousel-per-view', String( perView ) );
			root.classList.toggle( multipleClass, pageCount > 1 );

			orderedSlides.forEach( function ( slide, index ) {
				var visible = index < perView;
				slide.classList.toggle( 'is-visible', visible );
				slide.setAttribute( 'aria-hidden', visible ? 'false' : 'true' );
				slide.inert = ! visible;
			} );

			if ( dots ) {
				dots.hidden = ! showDots || pageCount <= 1;
				Array.prototype.forEach.call( dots.children, function ( dot ) {
					var active = parseInt( dot.dataset.slide, 10 ) === currentIndex;
					dot.classList.toggle( 'is-active', active );
					dot.setAttribute( 'aria-selected', active ? 'true' : 'false' );
					dot.tabIndex = active ? 0 : -1;
				} );
			}

			if ( previous ) {
				previous.hidden = ! showArrows || pageCount <= 1;
			}
			if ( next ) {
				next.hidden = ! showArrows || pageCount <= 1;
			}
		}

		function recalculate() {
			perView = getPerView();
			pageCount = slides.length > perView ? slides.length : 1;
			resetPosition();
			buildDots();
			update();
		}

		function afterTransition( callback ) {
			var finished = false;
			var finish = function () {
				if ( finished ) {
					return;
				}
				finished = true;
				track.removeEventListener( 'transitionend', onEnd );
				window.clearTimeout( fallback );
				callback();
			};
			var onEnd = function ( event ) {
				if ( event.target === track && 'transform' === event.propertyName ) {
					finish();
				}
			};
			var fallback = window.setTimeout( finish, transitionMs + 100 );
			track.addEventListener( 'transitionend', onEnd );
		}

		function move( direction, userInitiated ) {
			if ( pageCount <= 1 || isAnimating ) {
				return;
			}

			var total = slides.length;
			var targetIndex = ( currentIndex + direction + total ) % total;
			var step = getStep();
			isAnimating = true;

			if ( direction > 0 ) {
				track.style.transform = 'translate3d(-' + step + 'px, 0, 0)';
				afterTransition( function () {
					track.appendChild( track.firstElementChild );
					resetPosition();
					currentIndex = targetIndex;
					update();
					isAnimating = false;
				} );
			} else {
				track.style.transition = 'none';
				track.insertBefore( track.lastElementChild, track.firstElementChild );
				track.style.transform = 'translate3d(-' + step + 'px, 0, 0)';
				void track.offsetWidth;
				track.style.transition = '';
				track.style.transform = 'translate3d(0, 0, 0)';
				afterTransition( function () {
					resetPosition();
					currentIndex = targetIndex;
					update();
					isAnimating = false;
				} );
			}

			if ( userInitiated ) {
				startAutoplay();
			}
		}

		function jumpTo( target, userInitiated ) {
			if ( pageCount <= 1 || isAnimating ) {
				return;
			}
			target = ( target + slides.length ) % slides.length;
			var targetSlide = slides[ target ];
			if ( ! targetSlide || target === currentIndex ) {
				return;
			}

			var ordered = slides.slice( target ).concat( slides.slice( 0, target ) );
			ordered.forEach( function ( slide ) {
				track.appendChild( slide );
			} );
			currentIndex = target;
			resetPosition();
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
			if ( ! autoplay || pageCount <= 1 || ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) || document.hidden ) {
				return;
			}
			timer = window.setInterval( function () {
				move( 1, false );
			}, interval );
		}

		if ( previous ) {
			previous.addEventListener( 'click', function () {
				move( -1, true );
			} );
		}
		if ( next ) {
			next.addEventListener( 'click', function () {
				move( 1, true );
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
				move( -1, true );
			} else if ( 'ArrowRight' === event.key ) {
				event.preventDefault();
				move( 1, true );
			}
		} );
		if ( viewport ) {
			viewport.addEventListener( 'pointerdown', function ( event ) {
				if ( 'mouse' === event.pointerType && 0 !== event.button ) {
					return;
				}
				pointerStart = event.clientX;
				stopAutoplay();
			} );
			viewport.addEventListener( 'pointerup', function ( event ) {
				if ( null === pointerStart ) {
					return;
				}
				var distance = event.clientX - pointerStart;
				pointerStart = null;
				if ( Math.abs( distance ) > 40 ) {
					move( distance < 0 ? 1 : -1, true );
				} else {
					startAutoplay();
				}
			} );
			viewport.addEventListener( 'pointercancel', function () {
				pointerStart = null;
				startAutoplay();
			} );
		}

		window.addEventListener( 'resize', function () {
			window.clearTimeout( resizeTimer );
			resizeTimer = window.setTimeout( function () {
				recalculate();
				startAutoplay();
			}, 150 );
		} );
		document.addEventListener( 'visibilitychange', function () {
			if ( document.hidden ) {
				stopAutoplay();
			} else {
				startAutoplay();
			}
		} );

		recalculate();
		startAutoplay();
		root.classList.add( readyClass );
	}

	function initBusinessImageCarousel( root ) {
		var images = [];
		try {
			images = JSON.parse( root.getAttribute( 'data-business-images' ) || '[]' );
		} catch ( error ) {
			images = [];
		}
		images = Array.isArray( images ) ? images.filter( function ( image ) {
			return typeof image === 'string' && image.trim();
		} ) : [];

		var primary = root.querySelector( '.business-card__media--primary' );
		var secondary = root.querySelector( '.business-card__media--secondary' );
		if ( images.length < 2 || ! primary || ! secondary ) {
			return;
		}

		var currentIndex = 0;
		var showingSecondary = false;
		var timer = null;
		var interval = Math.max( 5000, toNumber( root.dataset.businessInterval, 5000 ) );

		function setBackground( layer, image ) {
			var safeImage = image.replace( /["\\\r\n]/g, '\\$&' );
			layer.style.backgroundImage = 'url("' + safeImage + '")';
		}

		function stop() {
			if ( timer ) {
				window.clearInterval( timer );
				timer = null;
			}
		}

		function start() {
			stop();
			if ( document.hidden || ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) ) {
				return;
			}
			timer = window.setInterval( function () {
				var nextIndex = ( currentIndex + 1 ) % images.length;
				var incoming = showingSecondary ? primary : secondary;
				setBackground( incoming, images[ nextIndex ] );
				root.classList.toggle( 'is-showing-secondary', ! showingSecondary );
				showingSecondary = ! showingSecondary;
				currentIndex = nextIndex;
			}, interval );
		}

		setBackground( primary, images[ 0 ] );
		root.addEventListener( 'mouseenter', stop );
		root.addEventListener( 'mouseleave', start );
		document.addEventListener( 'visibilitychange', function () {
			if ( document.hidden ) {
				stop();
			} else {
				start();
			}
		} );
		start();
	}

	document.querySelectorAll( '[data-rivross-carousel]' ).forEach( initCarousel );
	document.querySelectorAll( '[data-business-images]' ).forEach( initBusinessImageCarousel );
}() );
