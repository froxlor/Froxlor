$(document).ready(function() {
	$('#customer_add,#customer_edit').each(function(){
		$(this).validate({
			rules:{
				'name':{
					required:function(){
						return $('#company').val().length === 0 || $('#firstname').val().length > 0;
					}
				},
				'firstname':{
					required:function(){
						return $('#company').val().length === 0 || $('#name').val().length > 0;
					}
				},
				'company':{
					required:function(){
						return $('#name').val().length === 0
							&& $('#firstname').val().length === 0;
					}
				}
			},
		});
	});
});
