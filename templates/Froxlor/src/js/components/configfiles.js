$(function () {
	/*
	 * config files - select all recommended
	 */
	$('#selectRecommendedConfig').on('click', function () {
		$('input[data-recommended]').each(function () {
			if ($(this).data('recommended') == 1) {
				$(this).prop('checked', true);
			} else {
				$(this).prop('checked', false);
			}
		})
	});

	/*
	 * export/download JSON file (e.g. for usage with config-services)
	 */
	$('#downloadSelectionAsJson').on('click', function () {
		var formData = $(this).closest('form').serialize();
		window.location = "lib/ajax.php?action=getConfigJsonExport&" + formData;
	});

	/*
	 * open modal window to show selected config-commands/files
	 * for selected daemon
	 */
	$('.show-config').on('click', function () {
		var distro = $(this).data('dist');
		var section = $(this).data('section');
		var daemon = $(this).data('daemon');

		$.ajax({
			url: "lib/ajax.php?action=getConfigDetails",
			type: "POST",
			dataType: "json",
			data: { distro: distro, section: section, daemon: daemon },
			success: function (data) {
				$('#configTplShowLabel').html(data.title);
				$('#configTplShow .modal-body').html(data.content);
				var myModal = new bootstrap.Modal(document.getElementById('configTplShow'));
				myModal.show();
			},
			error: function (request, status, error) {
				$('#configTplShowLabel').html('Error');
				$('#configTplShow .modal-body').html('<div class="alert alert-danger" role="alert">' + request.responseJSON.message + '</div>');
				var myModal = new bootstrap.Modal(document.getElementById('configTplShow'));
				myModal.show();
			}
		});

	});
});
