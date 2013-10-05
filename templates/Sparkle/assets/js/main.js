function twoDigits(value) {
   if(value < 10) {
    return '0' + value;
   }
   return value;
}

$(document).ready(function() {
	// Scroll to top
	$(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});
	
	$('.scrollup').click(function() {
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});
	
	// Enable datatable
    $('#sortable').dataTable({
	    "bFilter": false,
	    "bInfo": false,
	    "bPaginate": false
    });
    $('.nosort').unbind('click');
	
	// this is necessary for the special setting feature (ref #1010)
	$.getQueryVariable = function(key) {
		var urlParams = decodeURI( window.location.search.substring(1) );
		if(urlParams == false | urlParams == '') return null;
		var vars = urlParams.split("&");
		for (var i=0;i<vars.length;i++) {
			var pair = vars[i].split("=");
			if (pair[0] == key) {
				return pair[1];
			}
		}
		return null;
	}

	if ($('#speciallogwarningpopup').length) {
		var $speciallogdialog = $('#speciallogwarningpopup')
			.dialog({
				autoOpen: false,
				closeOnEscape: false,
				draggable: false,
				modal: true,
				resizable: false,
			});
	}
	

	// make rel="external" links open in a new window
	$("a[rel='external']").attr('target', '_blank');
	$(".main").css('min-height', $("nav").height() - 134);
	
	// set focus on username-field if on loginpage
	if ($(".loginpage").length != 0) {
		$("#loginname").focus();
	}

	if ($("table.bradius").length != 0) {
		$("table.bradius tbody tr").hover(function() {
			$(this).css("background-color", "#f5f5f5");
		}, function() {
			$(this).css("background-color", "#fff");
		});
	}

	// Auto-select next field in configfile - wizard
	$('#config_distribution').change(function (){
		window.location.href=window.location.href + '&distribution=' + this.options[ this.selectedIndex ].value;
	});
	$('#config_service').change(function (){
		window.location.href=window.location.href + '&service=' + this.options[ this.selectedIndex ].value;
	});
	$('#config_daemon').change(function (){
		window.location.href=window.location.href + '&daemon=' + this.options[ this.selectedIndex ].value;
	});

	// Back-button
	$('#yesnobutton').click(function() {
		history.back();
	});

    $('input[name=speciallogfile]').click(function () {
            if($.getQueryVariable("page") == "domains" && $.getQueryVariable("action") == "edit") {
                    $speciallogdialog.dialog("open");
                    $(".ui-dialog-titlebar").hide();
            }
    });

    $('#speciallogyesbutton').click(function () {
            $speciallogdialog.dialog("close");
            if($('#delete_stats').val().toLowerCase() != $('#delete_statistics_str').val().toLowerCase()) {
                    $("#speciallogverified").val("0");
                    if($('input[name=speciallogfile]').prop("checked") != false) {
                            $('input[name=speciallogfile]').attr("checked", false);
                    } else {
                            $('input[name=speciallogfile]').attr("checked", true);
                    }
            } else {
                    $("#speciallogverified").val("1");
            }
    });

    $('input[id=speciallognobutton]').click(function () {
            $speciallogdialog.dialog("close");
            $("#speciallogverified").val("0");
            if($('input[name=speciallogfile]').prop("checked") != false) {
                    $('input[name=speciallogfile]').attr("checked", false);
            } else {
                    $('input[name=speciallogfile]').attr("checked", true);
            }
    });
});
