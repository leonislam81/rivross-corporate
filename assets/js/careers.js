(function () {
	'use strict';

	var config = window.RivrossCareersJobs || {};
	var listing = document.querySelector('[data-careers-jobs]');
	if (!listing || !config.ajaxUrl) {
		return;
	}

	var grid = listing.querySelector('[data-careers-jobs-grid]');
	var paginationWrap = listing.querySelector('[data-careers-jobs-pagination-wrap]');
	var status = listing.querySelector('[data-careers-jobs-status]');
	var busy = false;

	listing.addEventListener('click', function (event) {
		var button = event.target.closest('[data-careers-jobs-page]');
		if (!button || button.disabled || busy) {
			return;
		}
		event.preventDefault();
		loadJobs(parseInt(button.getAttribute('data-careers-jobs-page'), 10) || 1);
	});

	function loadJobs(page) {
		busy = true;
		listing.classList.add('is-loading');
		listing.setAttribute('aria-busy', 'true');
		if (status) {
			status.textContent = config.loadingMessage || 'Loading jobs…';
		}

		var body = new URLSearchParams();
		body.append('action', 'rivross_load_jobs');
		body.append('page', page);

		fetch(config.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
			body: body.toString()
		})
			.then(function (response) {
				return response.json();
			})
			.then(function (result) {
				if (!result.success || !result.data) {
					throw new Error((result.data && result.data.message) || config.errorMessage || 'Jobs could not be loaded.');
				}
				grid.innerHTML = result.data.html || '';
				paginationWrap.innerHTML = result.data.pagination || '';
				if (status) {
					status.textContent = '';
				}
			})
			.catch(function (error) {
				if (status) {
					status.textContent = error.message || config.errorMessage || 'Jobs could not be loaded.';
				}
			})
			.finally(function () {
				busy = false;
				listing.classList.remove('is-loading');
				listing.removeAttribute('aria-busy');
			});
	}
}());
