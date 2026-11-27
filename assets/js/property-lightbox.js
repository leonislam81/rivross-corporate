(function () {
	'use strict';

	var triggers = Array.prototype.slice.call(document.querySelectorAll('[data-property-lightbox]'));
	if (!triggers.length) {
		return;
	}

	var overlay = document.createElement('div');
	overlay.className = 'property-lightbox';
	overlay.setAttribute('aria-hidden', 'true');
	overlay.innerHTML = '<div class="property-lightbox__dialog" role="dialog" aria-modal="true" aria-label="Property image viewer">' +
		'<button class="property-lightbox__close" type="button" aria-label="Close image viewer">&times;</button>' +
		'<button class="property-lightbox__nav property-lightbox__nav--prev" type="button" aria-label="Previous image">&#10094;</button>' +
		'<figure class="property-lightbox__figure"><img class="property-lightbox__image" alt=""><figcaption class="property-lightbox__caption"></figcaption></figure>' +
		'<button class="property-lightbox__nav property-lightbox__nav--next" type="button" aria-label="Next image">&#10095;</button>' +
		'<p class="property-lightbox__counter" aria-live="polite"></p>' +
		'</div>';
	document.body.appendChild(overlay);

	var image = overlay.querySelector('.property-lightbox__image');
	var caption = overlay.querySelector('.property-lightbox__caption');
	var counter = overlay.querySelector('.property-lightbox__counter');
	var closeButton = overlay.querySelector('.property-lightbox__close');
	var previousButton = overlay.querySelector('.property-lightbox__nav--prev');
	var nextButton = overlay.querySelector('.property-lightbox__nav--next');
	var activeItems = [];
	var activeIndex = 0;
	var lastTrigger = null;

	function itemImage(item) {
		return item.querySelector('img') || item;
	}

	function setImage() {
		var item = activeItems[activeIndex];
		var source = itemImage(item);
		if (!source) {
			return;
		}
		image.src = source.currentSrc || source.src;
		image.alt = source.alt || '';
		caption.textContent = source.alt || '';
		counter.textContent = activeItems.length > 1 ? (activeIndex + 1) + ' / ' + activeItems.length : '';
		previousButton.hidden = activeItems.length < 2;
		nextButton.hidden = activeItems.length < 2;
	}

	function open(item) {
		var gallery = item.closest('.property-gallery');
		activeItems = gallery ? Array.prototype.slice.call(gallery.querySelectorAll('[data-property-lightbox]')) : [item];
		activeIndex = Math.max(0, activeItems.indexOf(item));
		lastTrigger = item;
		setImage();
		overlay.classList.add('is-open');
		overlay.setAttribute('aria-hidden', 'false');
		document.body.classList.add('is-property-lightbox-open');
		closeButton.focus();
	}

	function close() {
		overlay.classList.remove('is-open');
		overlay.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('is-property-lightbox-open');
		if (lastTrigger) {
			lastTrigger.focus();
		}
	}

	function move(step) {
		if (activeItems.length < 2) {
			return;
		}
		activeIndex = (activeIndex + step + activeItems.length) % activeItems.length;
		setImage();
	}

	triggers.forEach(function (trigger) {
		trigger.addEventListener('click', function () {
			open(trigger);
		});
	});

	overlay.addEventListener('click', function (event) {
		if (event.target === overlay || event.target === closeButton) {
			close();
		} else if (event.target === previousButton) {
			move(-1);
		} else if (event.target === nextButton) {
			move(1);
		}
	});

	document.addEventListener('keydown', function (event) {
		if (!overlay.classList.contains('is-open')) {
			return;
		}
		if (event.key === 'Escape') {
			close();
		} else if (event.key === 'ArrowLeft') {
			move(-1);
		} else if (event.key === 'ArrowRight') {
			move(1);
		}
	});
}());
