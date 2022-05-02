$(function() {

	// disable unusable php-configuration by customer settings
	$('#customerid').on('change', function () {
		var cid = $(this).val();
		$.ajax({
			url: "admin_domains.php?page=domains&action=jqGetCustomerPHPConfigs",
			type: "POST",
			data: {
				customerid: cid
			},
			dataType: "json",
			success: function (json) {
				if (json.length > 0) {
					$('#phpsettingid option').each(function () {
						var pid = $(this).val();
						$(this).attr("disabled", "disabled");
						for (var i in json) {
							if (pid == json[i]) {
								$(this).removeAttr("disabled");
							}
						}
					});
				}
			},
			error: function (a, b) {
				console.log(a, b);
			}
		});
	});

	// show warning if speciallogfile option is toggled
	if ($('input[name=speciallogverified]')) {
		$('input[name=speciallogfile]').on('click', function () {
			$('#speciallogfilenote').remove();
			$('#speciallogfile').removeClass('is-invalid');
			$('#speciallogverified').val(0);
			$.ajax({
				url: "admin_domains.php?page=overview&action=jqSpeciallogfileNote",
				type: "POST",
				data: {
					id: $('input[name=id]').val(), newval: +$('#speciallogfile').is(':checked')
				},
				dataType: "json",
				success: function (json) {
					if (json.changed) {
						$('#speciallogfile').addClass('is-invalid');
						$('#speciallogfile').parent().append(json.info);
						$('#speciallogverified').val(1);
					}
				},
				error: function (a, b) {
					console.log(a, b);
				}
			});
		});
	}

	/**
	 * email only domain - hide unnecessary/unused sections
	 */
	if ($('#id') && $('#email_only').is(':checked')) {
		$('#section_b').hide();
		$('#section_bssl').hide();
		$('#section_c').hide();
		$('#section_d').hide();
	}

	/**
	 * toggle show/hide of sections in case of email only flag
	 */
	$('#email_only').on('click', function () {
		if ($(this).is(':checked')) {
			// hide unnecessary sections
			$('#section_b').hide();
			$('#section_bssl').hide();
			$('#section_c').hide();
			$('#section_d').hide();
		} else {
			// show sections
			$('#section_b').show();
			$('#section_bssl').show();
			$('#section_c').show();
			$('#section_d').show();
		}
	})
});
