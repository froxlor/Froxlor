/**
 * 
 */
$(document).ready(function() {

	function editApikey(id) {
		var sid = getUrlParameter('s');
		var page = getUrlParameter('page');
		
		var apikey_id = $('#dialog-' + id + ' input[name="id"]').val();
		var allowed_from = $('#dialog-' + id + ' input[name="allowed_from"]').val();
		var valid_until = $('#dialog-' + id + ' input[name="valid_until"]').val();

		$.ajax({
	        url: "admin_index.php?s="+sid+"&page="+page+"&action=jqEditApiKey",
	        type: "POST",
	        data: {
	        	id: apikey_id, allowed_from: allowed_from, valid_until: valid_until
	        },
	        dataType: "json",
	        success: function(json) {
	        	$('#dialog-' + id).dialog("close");
	        	location.reload();
	        },
	        error: function(a, b) {
	            console.log(a, b);
	        }
	    });
	}

	$("span[id|='apikey'], span[id|='secret']").click(function() {
		var id = $(this).attr('data-id');
		$('#dialog-' + id).dialog({
			modal : true,
			buttons : {
				Ok : function() {
					editApikey(id);
					$(this).dialog("close");
				}
			},
			width : 800
		});
	});

});
