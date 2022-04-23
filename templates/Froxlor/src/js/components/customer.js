$(function() {

	// Make inputs with enabled unlimited checked disabled
	$("input[name$='_ul']").each(function () {
		var fieldname = $(this).attr("name").substring(0, $(this).attr("name").length - 3);
		$("input[name='" + fieldname + "']").prop({
			readonly: $(this).is(":checked"),
			required: !$(this).is(":checked")
		});
	});
	// change state when unlimited checkboxes are clicked
	$("input[name$='_ul']").on('change', function () {
		var fieldname = $(this).attr("name").substring(0, $(this).attr("name").length - 3);
		$("input[name='" + fieldname + "']").prop({
			readonly: $(this).is(":checked"),
			required: !$(this).is(":checked")
		});
		if (!$(this).is(":checked")) {
			$("input[name='" + fieldname + "']").focus()
		}
	});

	// set values from hosting plan when adding/editing a customer according to the plan's values
	$('#use_plan').on('change', function () {
		var pid = $(this).val();
		if (pid > 0) {
			$.ajax({
				url: "admin_plans.php?page=overview&action=jqGetPlanValues",
				type: "POST",
				data: {
					planid: pid
				},
				dataType: "json",
				success: function (json) {
					for (var i in json) {
						if (i == 'email_imap' || i == 'email_pop3' || i == 'perlenabled' || i == 'phpenabled' || i == 'dnsenabled' || i == 'logviewenabled') {
							/** handle checkboxes **/
							if (json[i] == 1) {
								$("input[name='" + i + "']").prop('checked', true);
							} else {
								$("input[name='" + i + "']").prop('checked', false);
							}
						} else if (i == 'allowed_phpconfigs') {
							/** handle array of values **/
							$("input[name='allowed_phpconfigs[]']").each(function (index) {
								$(this).prop('checked', false);
								for (var j in json[i]) {
									if ($(this).val() == json[i][j]) {
										$(this).prop('checked', true);
										break;
									}
								}
							});
						} else if (json[i] == -1) {
							/** handle unlimited checkboxes **/
							$("input[name='" + i + "_ul']").attr('checked', 'checked');
							$("input[name='" + i + "']").prop({
								readonly: true
							});
						} else {
							/** handle normal value **/
							$("input[name='" + i + "']").val(json[i]);
							$("input[name='" + i + "']").prop({
								readonly: false
							});
							$("input[name='" + i + "_ul']").prop('checked', false);
						}
					}
				},
				error: function (a, b) {
					console.log(a, b);
				}
			});
		}
	});
});
