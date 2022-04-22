$(document).ready(function () {
	/*
	 * table columns - manage columns modal
	 */
	let form = $('#manageColumnsModal form');
	form.submit(function (event) {
		$.ajax({
			url: 'lib/ajax.php?action=tablelisting&listing=' + form.data('listing') + '&theme=' + window.$theme,
			type : 'POST',
			dataType : 'json',
			data : form.serialize(),
			success : function (result) {
				window.location.reload();
			},
			error: function (xhr, resp, text) {
				console.log(xhr, resp, text);
			}
		});
		event.preventDefault();
	});
});
