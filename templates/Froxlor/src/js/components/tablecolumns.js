$(function () {
	/*
	 * table columns - manage columns modal
	 */
	let form = $('#manageColumnsModal form');

	form.on('submit', function (event) {
		$.ajax({
			url: 'lib/ajax.php?action=updatetablelisting&listing=' + form.data('listing') + '&theme=' + window.$theme,
			type: 'POST',
			dataType: 'json',
			data: form.serialize(),
			success: function () {
				window.location.href = '';
			},
			error: function (request) {
				alert(request.responseJSON.message);
			}
		});
		event.preventDefault();
	});

	$('#manageColumnsModal form #reset').on('click', function () {
		$.ajax({
			url: 'lib/ajax.php?action=resettablelisting&listing=' + form.data('listing') + '&theme=' + window.$theme,
			type: 'POST',
			dataType: 'json',
			data: {},
			success: function () {
				window.location.href = '';
			},
			error: function (request) {
				alert(request.responseJSON.message);
			}
		});
	});

	$('#manageColumnsModal form #select-all').on('click', function () {
		$('#manageColumnsModal form input:checkbox').prop('checked', true);
	});

	$('#manageColumnsModal form #unselect-all').on('click', function () {
		$('#manageColumnsModal form input:checkbox').prop('checked', false);
	});
});
