// load bootstrap
import 'bootstrap';

// load jquery
global.$ = require('jquery');

$(document).ready(function () {
	window.$theme = 'Froxlor';
	window.$session = $('meta[name="froxlor-session"]').attr('content');
});

// Load components
require('./components/search')
require('./components/newsfeed')
require('./components/updatecheck')
