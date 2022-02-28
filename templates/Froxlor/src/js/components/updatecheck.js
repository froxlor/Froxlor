$(document).ready(function () {
	/*
	 * updatecheck
	 */
	if (document.getElementById('updatecheck')) {
		$.ajax({
			url: "lib/ajax.php?action=updatecheck&theme=" + window.$theme + "&s=" + window.$session,
			type: "GET",
			success: function (data) {
				$("#updatecheck").html(data);
			},
			error: function (request, status, error) {
				console.log(request, status, error)
				$("#updatecheck").html('<div class="alert alert-warning" role="alert">Error checking version</div>');
			}
		});
	}
});
