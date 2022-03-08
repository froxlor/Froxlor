$(document).ready(function () {
	console.log('included search');

	$('input[class=js-typeahead-search_v1]').on('change keyup keydown', function () {
		$.ajax({
			url: "lib/ajax.php?action=searchglobal&theme=" + window.$theme + "&s=" + window.$session,
			type: "POST",
			data: {
				searchtext: $(this).val()
			},
			dataType: "json",
			success: function (data) {
				console.log(data);
			},
			error: function (a, b) {
				console.log(a, b);
			}
		});
	});
});
