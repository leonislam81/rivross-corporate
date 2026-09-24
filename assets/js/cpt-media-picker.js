(function ($) {
	'use strict';

	function getInput(button) {
		var target = button.attr('data-target');
		if (!target) {
			return $();
		}
		return $('#' + target);
	}

	function updatePreview(input) {
		var preview = $('[data-preview-for="' + input.attr('id') + '"]');
		if (!preview.length) {
			return;
		}
		var urls = (input.val() || '').split(/\r?\n/).map(function (url) {
			return $.trim(url);
		}).filter(Boolean);
		if (!urls.length) {
			preview.empty().hide();
			return;
		}
		preview.empty();
		if (input.hasClass('rivross-media-gallery')) {
			urls.forEach(function (url) {
				preview.append($('<img>', { src: url, alt: '', loading: 'lazy' }).css({
					display: 'inline-block', width: '112px', height: '72px', objectFit: 'cover',
					margin: '0 8px 8px 0', verticalAlign: 'top', border: '1px solid #dcdcde', borderRadius: '2px'
				}));
			});
		} else {
			preview.append($('<img>', { src: urls[0], alt: '' }).css({ display: 'block', maxWidth: '100%', height: 'auto' }));
		}
		preview.show();
	}

	$(document).on('click', '.rivross-media-button', function (event) {
		event.preventDefault();
		var button = $(this);
		var input = getInput(button);
		if (!input.length || typeof wp === 'undefined' || !wp.media) {
			return;
		}
		var multiple = '1' === String(button.attr('data-multiple')) || input.hasClass('rivross-media-gallery');
		var frame = wp.media({
			title: multiple ? 'Choose Gallery Images' : 'Choose Image',
			button: { text: multiple ? 'Use These Images' : 'Use This Image' },
			library: { type: 'image' },
			multiple: multiple
		});

		frame.on('select', function () {
			var selection = frame.state().get('selection');
			var urls = [];
			selection.each(function (attachment) {
				var data = attachment.toJSON();
				if (data && data.url) {
					urls.push(data.url);
				}
			});
			if (!multiple) {
				input.val(urls[0] || '').trigger('change');
			} else {
				var existing = (input.val() || '').split(/\r?\n/).map(function (url) {
					return $.trim(url);
				}).filter(Boolean);
				urls.forEach(function (url) {
					if (existing.indexOf(url) === -1) {
						existing.push(url);
					}
				});
				input.val(existing.join('\n')).trigger('change');
			}
			updatePreview(input);
		});
		frame.open();
	});

	$(document).on('click', '.rivross-media-clear', function (event) {
		event.preventDefault();
		var input = getInput($(this));
		if (input.length) {
			input.val('').trigger('change');
			updatePreview(input);
		}
	});

	$(document).on('input change', '.rivross-media-input', function () {
		updatePreview($(this));
	});

	$(function () {
		$('.rivross-media-input').each(function () {
			updatePreview($(this));
		});
	});
}(jQuery));
