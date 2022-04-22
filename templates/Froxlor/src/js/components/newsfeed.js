$(function() {
	/*
	 * newsfeed
	 */
	if (document.getElementById('newsfeed')) {
		let role = "";

		if (typeof $("#newsfeed").data("role") !== "undefined") {
			role = "&role=" + $("#newsfeed").data("role");
		}

		$.ajax({
			url: "lib/ajax.php?action=newsfeed" + role + "&theme=" + window.$theme,
			type: "GET",
			success: function (data) {
				$("#newsfeeditems").html(data);
			},
			error: function (request, status, error) {
				console.log(request, status, error)
				$("#newsfeeditems").html('<div class="list-group-item text-center"><span class="badge bg-warning" role="alert">Error loading newsfeed</span></div>');
			}
		});
	}
});
