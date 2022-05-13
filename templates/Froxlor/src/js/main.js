// import libs
import 'bootstrap';
import '@fortawesome/fontawesome-free';
import 'chart.js/dist/chart';

// set jquery & bootstrap
global.$ = require('jquery');
global.bootstrap = require('bootstrap');

$(function () {
	window.$theme = 'Froxlor';
});

// Load components
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
