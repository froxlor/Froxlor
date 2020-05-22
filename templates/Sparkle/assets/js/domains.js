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
	$('#customerid').change(function() {
		var cid = $(this).val();
		var sid = getUrlParameter('s');
		var page = getUrlParameter('page');

		$.ajax({
	        url: "admin_domains.php?s="+sid+"&page="+page+"&action=jqGetCustomerPHPConfigs",
	        type: "POST",
	        data: {
	            customerid: cid
	        },
	        dataType: "json",
	        success: function(json) {
	        	if (json.length > 0) {
                    $('#phpsettingid option').each(function() {
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
	        error: function(a, b) {
	            console.log(a, b);
	        }
	    });
	});

});
