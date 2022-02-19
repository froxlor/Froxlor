// load bootstrap
import 'bootstrap';

// load jquery
window.$ = window.jQuery = require('jquery');

function getUrlVars() {
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for (var i = 0; i < hashes.length; i++) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
}

$(document).ready(function () {

	const mytheme = 'Froxlor';
	/*
	 * newsfeed
	 */
	if (document.getElementById('newsfeed')) {
		var role = "";
		if (typeof $("#newsfeed").data("role") !== "undefined") {
			role = "&role=" + $("#newsfeed").data("role");
		}
		var s = getUrlVars()["s"];

		$.ajax({
			url: "lib/ajax.php?action=newsfeed" + role + "&theme=" + mytheme + "&s=" + s,
			type: "GET",
			success: function (data) {
				$("#newsfeeditems").html(data);
			},
			error: function (a, b) {
				$("#newsfeeditems").html('<div class="alert alert-warning" role="alert">Error loading newsfeed</div>');
			}
		});
	}

});
