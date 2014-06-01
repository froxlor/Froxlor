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
	
	// Back buttons
	$('#historyback, .historyback').click(function() {
		parent.history.back();
		return false;
	});
	
	// Load Newsfeed
	var ajax_load = "<div id='newsitem'>Loading newsfeed...</div>";
	var role = "";
	if (typeof $("#newsfeed").data("role") !== "undefined") {
		role = "&role=" + $("#newsfeed").data("role");
	}
	$("#newsfeeditems").html(ajax_load).load("lib/ajax.php?action=newsfeed" + role, function() {
		if ($("#newsfeeditems").html().length > 0) {
			$(window).trigger('resize');
			$("#newsfeed").slideDown();
		}
	});	

	// Enable Infobubbles
	$(".tipper").tipper({
		direction: "right"
	});
	
	// Enable reset search click
	$(".resetsearch").click(function() {
		$(".searchtext").val("");
		$(".submitsearch").click();
	});
	
	// Height of divs fix
	var snheight = $('#sidenavigation').height();
	var mainheight = $('#maincontent').height();
	if (snheight > mainheight && !$('#newsfeed').length) {
		$('#maincontent').height(snheight);
	}

	// this is necessary for the special setting feature (ref #1010)
	$.getQueryVariable = function(key) {
		var urlParams = decodeURI( window.location.search.substring(1) );
		if(urlParams === false | urlParams === '') return null;
		var vars = urlParams.split("&");
		for (var i=0;i<vars.length;i++) {
			var pair = vars[i].split("=");
			if (pair[0] == key) {
				return pair[1];
			}
		}
		return null;
	};

	if ($('#speciallogwarningpopup').length) {
		var $speciallogdialog = $('#speciallogwarningpopup')
			.dialog({
				autoOpen: false,
				closeOnEscape: false,
				draggable: false,
				modal: true,
				resizable: false
			});
	}
	

	// make rel="external" links open in a new window
	$("a[rel='external']").attr('target', '_blank');
	
	// set focus on username-field if on loginpage
	$("#loginname").focus();

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

	// Speciallogfile popup dialog
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
                    if($('input[name=speciallogfile]').prop("checked") !== false) {
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
            if($('input[name=speciallogfile]').prop("checked") !== false) {
                    $('input[name=speciallogfile]').attr("checked", false);
            } else {
                    $('input[name=speciallogfile]').attr("checked", true);
            }
    });
});
