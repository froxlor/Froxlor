(function($,sr){
  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null;
          }

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100);
      };
  };
  // smartresize 
  jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');


$(window).smartresize(function(){
	resizecanvas();
});

function resizecanvas() {
	var divwidth = $('#statsbox').width();
	var space = divwidth % 150;
	var elementspl = (divwidth - space) / 150;
	var elementwidth = 130 + Math.round(space / elementspl) - 1;
	$(".canvasbox").animate({width: elementwidth}, 500);
}

$(document).ready(function() {
	resizecanvas();
	
	var usedColor = "#91c46b";
	var assiColor = "#287e7e";
	var unliColor = "#56606e";
	var overColor = "#dd514c";
	
	$(".circular").each(function(index, element) {
		var canvas = "#" + $(element).attr("id") + "-canvas";
		var used = parseFloat($(element).data("used"));
		var available = $(element).data("available");
		var assigned = parseFloat($(element).data("assigned"));
		var usedD, usedP, assignedP, assignedD;
				
		// Draw basic circle
		circularCircle(canvas, 40, 0, 270, 8, "#d2d4d8");
		
		// Draw percentages
		if (!isNaN(assigned) && available == "∞") {
			// Unlimited ressource and assigned
			if (assigned > used) {
				// Draw assigned as full circle
				circularCircle(canvas, 38, 0, 270, 4, assiColor);
				// Draw used as percentage of full circle
				usedP = Math.round(100 / assigned * used);
				usedD = 270 * usedP / 100;
				circularCircle(canvas, 42, 0, usedD, 4, usedColor);
			} else if (used > assigned) {
				// Draw used as full circle
				circularCircle(canvas, 42, 0, 270, 4, usedColor);
				// Draw assigned as percentage of full circle
				assignedP = Math.round(100 / used * assigned);
				assignedD = 270 * assignedP / 100;
				circularCircle(canvas, 38, 0, assignedD, 4, assiColor);
			} else {
				circularCircle(canvas, 42, 0, 270, 4, usedColor);
				circularCircle(canvas, 38, 0, 270, 4, assiColor);
			}
			circularText(canvas, 60, 42, 26, "∞");
		} else if (!isNaN(assigned)) {
			// Limited ressources but assigned
			available = parseFloat(available);
			
			assignedP = Math.round(100 / available * assigned);
			assignedD = 270 * assignedP / 100;
			circularCircle(canvas, 38, 0, assignedD, 4, assiColor);
			
			usedP = Math.round(100 / available * used);
			usedD = 270 * usedP / 100;
			circularCircle(canvas, 42, 0, usedD, 4, usedColor);
			circularText(canvas, 60, 42, 22, usedP + "%");
		} else if (available == "∞") {
			circularCircle(canvas, 40, 0, 270, 8, unliColor);
			circularText(canvas, 60, 42, 26, "∞");
		} else {
			// Limited ressources
			available = parseFloat(available);
			usedP = 100 / available * used;
			if (usedP < 1 && usedP > 0) {
				usedP = 1;
			} else {
				usedP = Math.round(usedP);
			}
			// Check if customer is over Limit
			usedD = 270 * usedP / 100;
			if (usedD > 270) { usedD = 270; }
			if (usedP > 90) {
				circularCircle(canvas, 40, 0, usedD, 8, overColor);
			} else {
				circularCircle(canvas, 40, 0, usedD, 8, usedColor);
			}
			if (usedP > 100) {
				circularText(canvas, 60, 42, 22, usedP + "%", overColor);
			} else {
				circularText(canvas, 60, 42, 22, usedP + "%");
			}
			
			
		}
		
	});

});

function circularCircle(canvas, radius, start, end, stroke, color) {
	$(canvas).drawArc({
		strokeStyle: color,
		strokeWidth: stroke,
		x: 60, y: 44,
		radius: radius,
		start: start, end: end,
		rotate: -135
	});
}
function circularText(canvas, x, y, size, text, color) {
	color = color || "#343a41";
	$(canvas).drawText({
		fillStyle: color,
		x: x, y: y,
		fontSize: size,
		fontFamily: "Lucida Grande, Verdana, sans-serif",
		text: text
	});
}
