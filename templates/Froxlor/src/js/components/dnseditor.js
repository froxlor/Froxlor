$(function () {

	// Display helptext to content box according to dns-record type selected
	$("select[name='dns_type']").on('change', function () {
		var selVal = $(this).val();
		$.ajax({
			url: "lib/ajax.php?action=loadLanguageString",
			type: "POST",
			dataType: "json",
			data: { langid: 'dnseditor.notes.' + selVal },
			success: function (data) {
				$("#dns_content").next().html(data);
			},
			error: function (request, status, error) {
				console.log(request, status, error)
			}
		});
	});
});
