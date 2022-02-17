// load bootstrap
import 'bootstrap';

// load jquery
window.$ = window.jQuery = require('jquery');

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

		$.ajax({
			url : "lib/ajax.php?action=newsfeed" + role + "&theme=" + mytheme,
			type : "GET",
			success : function(data) {
				$("#newsfeeditems").html(data);
			},
			error : function(a, b) {
				$("#newsfeeditems").html('<div class="alert alert-warning" role="alert">Error loading newsfeed</div>');
			}
		});
	}

});
