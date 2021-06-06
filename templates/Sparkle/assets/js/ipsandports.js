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
	 * check for internal ip and output a notice if private-range ip is given
	 */
	$('#ip').change(function() {
		var ipval = $(this).val();
		if (ipval.length > 0) {
			var sid = getUrlParameter('s');
			$.ajax({
		        url: "admin_ipsandports.php?s="+sid+"&page=overview&action=jqCheckIP",
		        type: "POST",
		        data: {
		            ip: ipval
		        },
		        dataType: "json",
		        success: function(json) {
                            if (json != 0) {
                                $('#ip').parent().append(json);
	                    } else {
	                        $('#ipnote').remove();
	                    }
		        },
		        error: function(a, b) {
		            console.log(a, b);
		        }
		    });
		}
	});

});
