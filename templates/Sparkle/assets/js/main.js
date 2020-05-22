function twoDigits(value) {
	if (value < 10) {
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
		$("html, body").animate({
			scrollTop: 0
		}, 600);
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
	// Enable notes
	$(".notes").click(function() {
		$("#notes_" + $(this).attr("data-id")).toggle("slow");
	});
	// Enable reset search click
	$(".resetsearch").click(function() {
		$(".searchtext").val("");
		$(".submitsearch").click();
	});
	// Make inputs with enabled unlimited checked disabled
	$("input[name$='_ul']").each(function() {
		var fieldname = $(this).attr("name").substring(0, $(this).attr("name").length - 3);
		$("input[name='" + fieldname + "']").prop({
			readonly: $(this).is(":checked")
		});
	});
	$("input[name$='_ul']").change(function() {
		var fieldname = $(this).attr("name").substring(0, $(this).attr("name").length - 3);
		$("input[name='" + fieldname + "']").prop({
			readonly: $(this).is(":checked")
		}).focus();
	});
	// Enable autoselect in configfules
	$(".shell, .filecontent").click(function() {
		$(this).select();
	});
	// Height of divs fix
	var snheight = $('#sidenavigation').height();
	var mainheight = $('#maincontent').height();
	if (snheight > mainheight && !$('#newsfeed').length) {
		$('#maincontent').css("min-height", snheight);
	}
	// this is necessary for the special setting feature (ref #1010)
	$.getQueryVariable = function(key) {
		var urlParams = decodeURI(window.location.search.substring(1));
		if (urlParams === false || urlParams === '') {
			return null;
		}
		var vars = urlParams.split("&");
		for (var i = 0; i < vars.length; i++) {
			var pair = vars[i].split("=");
			if (pair[0] === key) {
				return pair[1];
			}
		}
		return null;
	};
	if ($('#speciallogwarningpopup').length) {
		var $speciallogdialog = $('#speciallogwarningpopup').dialog({
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
	$('#config_distribution').change(function() {
		window.location.href = window.location.href + '&distribution=' + this.options[this.selectedIndex].value;
	});
	$('#config_service').change(function() {
		window.location.href = window.location.href + '&service=' + this.options[this.selectedIndex].value;
	});
	$('#config_daemon').change(function() {
		window.location.href = window.location.href + '&daemon=' + this.options[this.selectedIndex].value;
	});
	// Speciallogfile popup dialog
	$('input[name=speciallogfile]').click(function() {
		if ($.getQueryVariable("page") === "domains" && $.getQueryVariable("action") === "edit") {
			$speciallogdialog.dialog("open");
			$(".ui-dialog-titlebar").hide();
		}
	});
	$('#speciallogyesbutton').click(function() {
		$speciallogdialog.dialog("close");
		if ($('#delete_stats').val().toLowerCase() !== $('#delete_statistics_str').val().toLowerCase()) {
			$("#speciallogverified").val("0");
			if ($('input[name=speciallogfile]').prop("checked") !== false) {
				$('input[name=speciallogfile]').attr("checked", false);
			} else {
				$('input[name=speciallogfile]').attr("checked", true);
			}
		} else {
			$("#speciallogverified").val("1");
		}
	});
	$('input[id=speciallognobutton]').click(function() {
		$speciallogdialog.dialog("close");
		$("#speciallogverified").val("0");
		if ($('input[name=speciallogfile]').prop("checked") !== false) {
			$('input[name=speciallogfile]').attr("checked", false);
		} else {
			$('input[name=speciallogfile]').attr("checked", true);
		}
	});
	// Tablesorting on admin traffic
	$("table").each(function() {
		if ($(this).data("toggle") === "table") {
			$(this).tablesorter({
				textExtraction: (function(node) {
					// extract data from markup and return it
					if (node.innerText !== "-") {
						return node.innerText;
					} else {
						return '0 B';
					}
				}),
				headers: {
					1: {
						sorter: 'filesize'
					},
					2: {
						sorter: 'filesize'
					},
					3: {
						sorter: 'filesize'
					},
					4: {
						sorter: 'filesize'
					},
					5: {
						sorter: 'filesize'
					},
					6: {
						sorter: 'filesize'
					},
					7: {
						sorter: 'filesize'
					},
					8: {
						sorter: 'filesize'
					},
					9: {
						sorter: 'filesize'
					},
					10: {
						sorter: 'filesize'
					},
					11: {
						sorter: 'filesize'
					},
					12: {
						sorter: 'filesize'
					}
				},
			});
		}
	});
	// Mail Templates
	var mailTemplate = $("#mailTemplate").html();
	$("#mailLanguage").change(function() {
		var mailLanguage = $(this).val();
		var mailOptions = $(mailTemplate).filter(function() {
			return !$(this).attr("id") || $(this).attr("id") === mailLanguage;
		});
		$("#mailTemplate").html(mailOptions);
	});
	$("#mailLanguage").trigger("change");

	// Config files
	var configfileTextareas = $("textarea.filecontent, textarea.shell");
	var lastPw = "FROXLOR_MYSQL_PASSWORD";
	$("#configfiles_setmysqlpw").submit(function(event) {
		event.preventDefault();
		var inputVal = $("#configfiles_mysqlpw").val();
		if (!inputVal.trim()) {
			inputVal = "FROXLOR_MYSQL_PASSWORD";
		}
		configfileTextareas.each(function() {
			this.value = this.value.replace(lastPw, inputVal);
		});
		lastPw = inputVal;
	});

	autosize($('textarea.shell'));
});
