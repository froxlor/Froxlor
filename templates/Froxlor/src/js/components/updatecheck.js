$(function() {
	/*
	 * updatecheck
	 */
	if (document.getElementById('updatecheck')) {
		$.ajax({
			url: "lib/ajax.php?action=updatecheck&theme=" + window.$theme,
			type: "GET",
			success: function (data) {
				$("#updatecheck").html(data);
				new bootstrap.Popover(document.getElementById('ucheck'));
			},
			error: function (request, status, error) {
				console.log(request, status, error)
				let message = 'Can\'t check version';
				$("#updatecheck").html('<span id="ucheck" class="text-decoration-none badge bg-warning mt-2 me-2" data-bs-toggle="tooltip" data-bs-placement="left" title="' + message + '"><i class="fa-solid fa-exclamation-triangle"></i> <span class="d-md-none d-xl-inline">' + message + '</span></span>');
				new bootstrap.Tooltip(document.getElementById('ucheck'));
			}
		});
	}
});
