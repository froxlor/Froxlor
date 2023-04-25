$(function () {

	$('#historyback').on('click', function (e) {
		e.preventDefault();
		history.back(1);
	})

	$('#copySysInfo').on('click', function (e) {
		e.preventDefault();
		navigator.clipboard.writeText($('#ccSysInfo').text().trim());
	})
});
