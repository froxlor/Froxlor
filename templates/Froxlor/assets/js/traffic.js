jQuery.fn.reverse = function() {
	return this.pushStack(this.get().reverse(), arguments);
};
$(document).ready(function() {
	var ftp = [];
	var http = [];
	var mail = [];
	var ticks = [];
	var i = 1;
	var links = [];
	$('#datatable tbody tr').reverse().each(function() {
		var row = $(this);
		var ftpd = $(row).children().first().next().text();
		var httpd = $(row).children().first().next().next().text();
		var maild = $(row).children().first().next().next().next().text();
		if ($(row).children().first().find("a").length > 0) {
			links.push($(row).children().first().html());
			ticks.push([i, $(row).children().first().find("a").html().split(" ")[0]]);
		} else {
			ticks.push([i, $(row).children().first().html()]);
		}
		ftp.push([i, parseFloat(ftpd / 1024)]);
		http.push([i, parseFloat(httpd / 1024)]);
		mail.push([i, parseFloat(maild)]);
		i++;
	});
	$('#datatable').hide();
	$('#charts').show();
	if (links.length > 0) {
		var tmp = $('<div />', {
			id: 'linkslist'
		});
		$.each(links, function(i, link) {
			tmp.append(link);
			if (i != links.length - 1) {
				tmp.append('&nbsp;|&nbsp;');
			}
		});
		tmp.append('<br /><br /><br />');
		tmp.insertBefore($('#datatable'));
	}

	var ftpdata = [{
		label: 'FTP',
		data: ftp,
		color: '#1db34f'
	}];
	var httpdata = [{
		label: 'HTTP',
		data: http,
		color: '#0a90d8'
	}];
	var maildata = [{
		label: 'Mail',
		data: mail,
		color: '#f17f49'
	}];

	var options = {
		series: {
			shadowSize: 0,
			curvedLines: {
				active: true,
				apply: false,
				fitPointDist: true
			}
		},
		lines: {
			show: true,
			fill: true
		},
		points: {
			radius: 2,
			show: true
		},
		legend: {
			show: false
		},
		grid: {
			hoverable: true,
			borderWidth: 0
		},
		xaxis: {
			tickSize: 1,
			tickLength: 0,
			ticks: ticks,
			labelAngle: 45
		},
		yaxis: {
			tickColor: '#eee',
			min: 0
		}
	};


	$.plot('#ftpchart', ftpdata, options);
	$.plot('#httpchart', httpdata, options);
	$.plot('#mailchart', maildata, options);

	$("<div id='tooltip'></div>").css({
		position: "absolute",
		display: "none",
		padding: "4px 8px",
		"background-color": "#000",
		opacity: 0.85,
		color: "#fff",
		"font-size": "11px"
	}).appendTo("body");

	$("#ftpchart, #httpchart").bind("plothover", function(event, pos, item) {
		if (item) {
			var y = item.datapoint[1].toFixed(2);

			$("#tooltip").html(item.series.label + ": " + y + " GiB").css({
				top: item.pageY + 5,
				left: item.pageX - $("#tooltip").width() / 2
			}).fadeIn(200);
		} else {
			$("#tooltip").hide();
		}
	});

	$("#mailchart").bind("plothover", function(event, pos, item) {
		if (item) {
			var y = item.datapoint[1].toFixed(2);

			$("#tooltip").html(item.series.label + ": " + y + " MiB").css({
				top: item.pageY + 5,
				left: item.pageX - $("#tooltip").width() / 2
			}).fadeIn(200);
		} else {
			$("#tooltip").hide();
		}
	});
});
