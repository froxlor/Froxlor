/**
 * 
 */
$(document).ready(function() {
	
	var getUrlParameter = function getUrlParameter(sParam) {
	    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
	        sURLVariables = sPageURL.split('&'),
	        sParameterName,
	        i;

	    for (i = 0; i < sURLVariables.length; i++) {
	        sParameterName = sURLVariables[i].split('=');

	        if (sParameterName[0] === sParam) {
	            return sParameterName[1] === undefined ? true : sParameterName[1];
	        }
	    }
	};

	function editApikey(id) {
		var sid = getUrlParameter('s');
		var page = getUrlParameter('page');
		
		var area = $('#dialog-' + id + ' input[name="area"]').val();
		var apikey_id = $('#dialog-' + id + ' input[name="id"]').val();
		var allowed_from = $('#dialog-' + id + ' input[name="allowed_from"]').val();
		var valid_until = $('#dialog-' + id + ' input[name="valid_until"]').val();

		// convert datepicker yy-mm-dd to Timestamp
        var s = 0;
        if (valid_until.length > 0) {
        	s = $('#dialog-' + id + ' input[name="valid_until"]').datepicker("getDate").getTime() / 1000 + 3600;
        }

		$.ajax({
	        url: area + "_index.php?s="+sid+"&page="+page+"&action=jqEditApiKey",
	        type: "POST",
	        data: {
	        	id: apikey_id, allowed_from: allowed_from, valid_until: s
	        },
	        dataType: "json",
	        success: function(json) {
	        	$('#dialog-' + id).dialog("close");
	        	location.href = area + "_index.php?s="+sid+"&page="+page;
	        },
	        error: function(a, b) {
	            console.log(a, b);
	        }
	    });
	}

	$("tr[id|='apikey']").each(function() {
		$(this).css('cursor', 'pointer').hover(function() {
			$(this).addClass('active');
		}, function() {
			$(this).removeClass('active');
		}).click(function() {
			var id = $(this).attr('data-id');
			$('input[name="valid_until"]').datepicker({'dateFormat': 'yy-mm-dd'});
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

});
