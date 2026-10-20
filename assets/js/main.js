/* OrthoSupply theme JS, no dependencies. */
(function () {
	'use strict';
	var $ = function (s, r) { return (r || document).querySelector(s); };
	var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

	var toggle = $('.nav-toggle'), nav = $('#site-nav');
	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			document.body.classList.toggle('nav-open', open);
		});
	}

	var catnav = $('[data-catnav]');
	if (catnav) {
		var btn = $('.catnav__btn', catnav), menu = $('.catnav__menu', catnav);
		btn.addEventListener('click', function () {
			var open = menu.hidden; menu.hidden = !open; btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		document.addEventListener('click', function (e) { if (!catnav.contains(e.target) && !menu.hidden) { menu.hidden = true; btn.setAttribute('aria-expanded', 'false'); } });
		document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !menu.hidden) { menu.hidden = true; btn.setAttribute('aria-expanded', 'false'); } });
	}

	var ft = $('[data-filters-toggle]');
	if (ft) {
		var side = ft.closest('.shop__side');
		if (window.location.search.indexOf('filter_') > -1) { side.classList.add('is-open'); ft.setAttribute('aria-expanded', 'true'); }
		ft.addEventListener('click', function () { var o = side.classList.toggle('is-open'); ft.setAttribute('aria-expanded', o ? 'true' : 'false'); });
	}

	/* Checkbox groups -> comma-joined query params WooCommerce understands (filter_brand=a,b). */
	var ff = $('[data-filterform]');
	if (ff) {
		ff.addEventListener('submit', function (e) {
			e.preventDefault();
			var url = new URL(ff.action), groups = {};
			$$('input[type=checkbox]:checked', ff).forEach(function (cb) {
				var k = cb.name.replace('[]', ''); (groups[k] = groups[k] || []).push(cb.value);
			});
			Object.keys(groups).forEach(function (k) { url.searchParams.set(k, groups[k].join(',')); });
			['min_price', 'max_price', 'orderby'].forEach(function (k) { var el = ff.elements[k]; if (el && el.value) { url.searchParams.set(k, el.value); } });
			window.location.href = url.toString();
		});
	}

	/* Quantity +/- on product pages and cart */
	document.addEventListener('click', function (e) {
		var b = e.target.closest('[data-qty]'); if (!b) { return; }
		var input = b.parentNode.querySelector('input.qty'); if (!input) { return; }
		var step = parseFloat(input.step) || 1, v = parseFloat(input.value) || 0, min = parseFloat(input.min) || 1;
		v = b.dataset.qty === '+' ? v + step : Math.max(min, v - step);
		input.value = v; input.dispatchEvent(new Event('change', { bubbles: true }));
	});
})();
