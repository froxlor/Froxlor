$(document).ready(function(){
	// make rel="external" links open in a new window
	$("a[rel='external']").attr('target', '_blank');
	$(".main").css('min-height', $("nav").height() - 34);
	$(".dboarditem:last").css('min-height', $(".dboarditem:first").height());

	// set focus on username-field if on loginpage
	if($(".loginpage").length != 0) {
		$("#loginname").focus();
	}

	if($("table.formtable").length != 0) {
		$("table.formtable tr").hover(function() {
			$(this).css("background-color", "#fff");
		},
		function() {
			$(this).css("background-color", "#f5f5f5");
		}
		);
	}
	if($("table.bradiusodd").length != 0) {
		$("table.bradiusodd tr").hover(function() {
			$(this).css("background-color", "#fff");
		},
		function() {
			$(this).css("background-color", "#f5f5f5");
		}
		);
	}

        if($("table.aps").length != 0) {
                $("table.aps tr").hover(function() {
                        $(this).css("background-color", "#fff");
                },
                function() {
                        $(this).css("background-color", "#f5f5f5");
                }
                );
        }

});
