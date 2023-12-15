export default function () {
	$(function () {
		/*
		 * validation
		 */
		$('#customer_add,#customer_edit').each(function () {
			$(this).validate({
				rules: {
					'name': {
						required: function () {
							return $('#company').val().trim().length === 0 || $('#firstname').val().trim().length > 0;
						}
					},
					'firstname': {
						required: function () {
							return $('#company').val().trim().length === 0 || $('#name').val().trim().length > 0;
						}
					},
					'company': {
						required: function () {
							return $('#name').val().trim().length === 0
								&& $('#firstname').val().trim().length === 0;
						}
					}
				},
			});
		});
		$('#domain_add,#domain_edit').each(function () {
			$(this).validate({
				rules: {
					'ipandport[]': {
						required: true,
						minlength: 1
					}
				},
				errorPlacement: function (error, element) {
					$(error).prependTo($(element).parent().parent());
				}
			});
		});
	});
}
