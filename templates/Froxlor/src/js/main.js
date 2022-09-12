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
