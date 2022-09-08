$(function () {

	// Display helptext to content box according to dns-record type selected
	$("select[name='range']").on('change', function () {
		var selVal = $(this).val();
		var baseRef = $(this).data('baseref');
		window.location.href = baseRef + '?range=' + selVal;
	});
});
