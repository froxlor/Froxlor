// import libs
import 'bootstrap';
import '@fortawesome/fontawesome-free';
import Chart from 'chart.js/auto';

// set jquery & bootstrap & chart
global.$ = require('jquery');
global.bootstrap = require('bootstrap');
window.Chart = Chart;

$(function () {
	window.$theme = 'Froxlor';

	const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	})

	const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
	const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
});

// Load components
require('./components/global')
require('./components/search')
require('./components/newsfeed')
require('./components/updatecheck')
require('./components/customer')
require('./components/tablecolumns')
require('./components/ipsandports')
require('./components/domains')
require('./components/configfiles')
require('./components/apikeys')
require('./components/install')
require('./components/dnseditor')
require('./components/traffic')
