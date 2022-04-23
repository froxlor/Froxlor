$(document).ready(function () {
	/*
	 * table columns - manage columns modal
	 */
	let form = $('#manageColumnsModal form');

	form.submit(function (event) {
		$.ajax({
			url: 'lib/ajax.php?action=updatetablelisting&listing=' + form.data('listing') + '&theme=' + window.$theme,
			type : 'POST',
			dataType : 'json',
			data : form.serialize(),
			success : function () {
				window.location.href = '';
			},
			error: function (request) {
				alert(request.responseJSON.message);
			}
		});
		event.preventDefault();
	});

	$('#manageColumnsModal form #reset').click(function () {
		$.ajax({
			url: 'lib/ajax.php?action=resettablelisting&listing=' + form.data('listing') + '&theme=' + window.$theme,
			type : 'POST',
			dataType : 'json',
			data : {},
			success : function () {
				window.location.href = '';
			},
			error: function (request) {
				alert(request.responseJSON.message);
			}
		});
	});
});
