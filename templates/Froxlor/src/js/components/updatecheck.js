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
				let message = 'Can\'t check version';
				$("#updatecheck").html('<a class="nav-link disabled text-warning" data-bs-toggle="tooltip" data-bs-placement="left" title="' + message + '"><i class="fa fa-exclamation-triangle"></i> <span class="d-md-none d-xl-inline">' + message + '</span></a>');
			}
		});
	}
});
