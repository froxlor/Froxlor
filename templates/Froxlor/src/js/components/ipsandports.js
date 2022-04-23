$(function() {

	// check for internal ip and output a notice if private-range ip is given
	$('#ip').on('change', function () {
		var ipval = $(this).val();
		if (ipval.length > 0) {
			$('#ipnote').remove();
			$('#ip').removeClass('is-invalid');
			$.ajax({
				url: "admin_ipsandports.php?page=overview&action=jqCheckIP",
				type: "POST",
				data: {
					ip: ipval
				},
				dataType: "json",
				success: function (json) {
					if (json != 0) {
						$('#ip').addClass('is-invalid');
						$('#ip').parent().append(json);
					}
				},
				error: function (a, b) {
					console.log(a, b);
				}
			});
		}
	});

});
