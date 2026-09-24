( function () {
	'use strict';

	function initFaq( details ) {
		var summary = details.querySelector( 'summary' );
		var panel = details.querySelector( '.contact-faq__answer' );
		if ( ! summary || ! panel ) {
			return;
		}

		details.classList.add( 'faq-enhanced' );
		summary.setAttribute( 'aria-expanded', details.open ? 'true' : 'false' );
		panel.style.height = details.open ? panel.scrollHeight + 'px' : '0px';
		if ( details.open ) {
			details.classList.add( 'is-expanded' );
		}

		function finish( closing ) {
			if ( closing ) {
				details.open = false;
				details.classList.remove( 'is-closing' );
				panel.style.height = '0px';
			} else {
				details.classList.remove( 'is-opening' );
				panel.style.height = 'auto';
			}
			details.removeAttribute( 'data-faq-animating' );
		}

		function afterTransition( closing ) {
			var completed = false;
			function complete() {
				if ( completed ) {
					return;
				}
				completed = true;
				finish( closing );
			}
			panel.addEventListener( 'transitionend', complete, { once: true } );
			window.setTimeout( complete, 380 );
		}

		function openFaq() {
			details.setAttribute( 'data-faq-animating', '1' );
			details.open = true;
			details.classList.add( 'is-expanded', 'is-opening' );
			summary.setAttribute( 'aria-expanded', 'true' );
			panel.style.height = '0px';
			window.requestAnimationFrame( function () {
				panel.style.height = panel.scrollHeight + 'px';
			} );
			afterTransition( false );
		}

		function closeFaq() {
			details.setAttribute( 'data-faq-animating', '1' );
			details.classList.remove( 'is-expanded' );
			details.classList.add( 'is-closing' );
			summary.setAttribute( 'aria-expanded', 'false' );
			panel.style.height = panel.scrollHeight + 'px';
			window.requestAnimationFrame( function () {
				panel.style.height = '0px';
			} );
			afterTransition( true );
		}

		summary.addEventListener( 'click', function ( event ) {
			event.preventDefault();
			if ( details.hasAttribute( 'data-faq-animating' ) ) {
				return;
			}
			if ( details.open ) {
				closeFaq();
			} else {
				openFaq();
			}
		} );

		window.addEventListener( 'resize', function () {
			if ( details.open && ! details.hasAttribute( 'data-faq-animating' ) ) {
				panel.style.height = 'auto';
			}
		} );
	}

	document.querySelectorAll( '.contact-faq details' ).forEach( initFaq );
}() );
