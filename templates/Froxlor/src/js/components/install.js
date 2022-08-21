$(function () {
	/*
	 * switch between basic and advanced install mode
	 */
	$('#switchInstallMode').on('click', function () {
		var checked = $(this).prop('checked');
		window.location = window.location.pathname + replaceQueryParam('extended', +checked, window.location.search);
	});

	function replaceQueryParam(param, newval, search) {
		var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
		if (search.match(regex)) {
			search = search.replace(regex, "$1").replace(/&$/, '');
		}
		return search + '&' + param + '=' + newval;
	}

	function checkConfigState() {
		$.ajax({
			url: window.location.href,
			type: "GET",
			success: function (data, textStatus, request) {
				if (request.status >= 300) {
					window.location = "http://" + srvName;
				}
			},
			error: function (request, textStatus, errorThrown) {
				// continue
				if (request.status >= 300) {
					window.location = "http://" + srvName;
				}
			}
		});
	}

	var cTimer;

	/**
	 * check manual-config switch
	 */
	$('#manual_config').on('click', function () {
		clearInterval(cTimer);
		var checked = $(this).prop('checked');
		if (checked) {
			// button zum login
			$('#submitAuto').addClass('d-none');
			$('#submitManual').removeClass('d-none');
		} else {
			cTimer = setInterval(checkConfigState, 1000);
			// spinner fürs warten
			$('#submitAuto').removeClass('d-none');
			$('#submitManual').addClass('d-none');
		}
	});

	if ($('#manual_config').length > 0) {
		var srvName = $('#target_servername').val();
		clearInterval(cTimer);
		cTimer = setInterval(checkConfigState, 1000);
	}

});
