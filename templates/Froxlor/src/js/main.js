// load bootstrap
import 'bootstrap';
import 'jquery-typeahead/src/jquery.typeahead.css'

// load jquery
global.$ = require('jquery');
require('jquery-typeahead');

$(document).ready(function () {
	window.$theme = 'Froxlor';
	window.$session = $('meta[name="froxlor-session"]').attr('content');
});

// Load components
require('./components/search')
require('./components/newsfeed')
require('./components/updatecheck')
