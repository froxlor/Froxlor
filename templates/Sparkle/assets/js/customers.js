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

	/**
	 * disable unusable php-configuration by customer settings
	 */
	$('#use_plan').change(function() {
		var pid = $(this).val();
		if (pid > 0) {
			var sid = getUrlParameter('s');
			$.ajax({
		        url: "admin_plans.php?s="+sid+"&page=overview&action=jqGetPlanValues",
		        type: "POST",
		        data: {
		            planid: pid
		        },
		        dataType: "json",
		        success: function(json) {
				for (var i in json) {
		        		if (i == 'email_imap' || i == 'email_pop3' || i == 'perlenabled' || i == 'phpenabled' || i == 'dnsenabled') {
		        			/** handle checkboxes **/
		        			if (json[i] == 1) {
		        				$("input[name='"+i+"']").prop('checked', true);
		        			} else {
		        				$("input[name='"+i+"']").prop('checked', false);
		        			}
		        		} else if (i == 'allowed_phpconfigs') {
		        			/** handle array of values **/
		        			$("input[name='allowed_phpconfigs[]']").each(function(index) {
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
			        		$("input[name='"+i+"']").prop({
			        			readonly: true
			        		});
		        		} else {
		        			/** handle normal value **/
		        			$("input[name='"+i+"']").val(json[i]);
			        		$("input[name='"+i+"']").prop({
			        			readonly: false
			        		});
		        			$("input[name='" + i + "_ul']").prop('checked', false);
		        		}
		        	}
		        },
		        error: function(a, b) {
		            console.log(a, b);
		        }
		    });
		}
	});

});
