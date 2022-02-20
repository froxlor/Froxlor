// load bootstrap
import 'bootstrap';

// load jquery
window.$ = window.jQuery = require('jquery');

$(document).ready(function () {
	window.$theme = 'Froxlor';
	window.$session = $('meta[name="froxlor-session"]').attr('content');
});

// Load components
require('./components/newsfeed')
require('./components/updatecheck')
