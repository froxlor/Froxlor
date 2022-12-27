// import libs
import 'bootstrap';
import '@fortawesome/fontawesome-free';
import Chart from 'chart.js/auto';

// set jquery & bootstrap & chart
global.$ = require('jquery');
global.validation = require('jquery-validation');
global.bootstrap = require('bootstrap');
window.Chart = Chart;

$(function () {
	window.$theme = 'Froxlor';

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	})

	const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
	const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
});

// Load components
require('./components/apikeys')
require('./components/configfiles')
require('./components/customer')
require('./components/dnseditor')
require('./components/domains')
require('./components/global')
require('./components/install')
require('./components/ipsandports')
require('./components/newsfeed')
require('./components/search')
require('./components/tablecolumns')
require('./components/traffic')
require('./components/updatecheck')
require('./components/validation')
