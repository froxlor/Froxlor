jQuery.fn.reverse = function() {
	return this.pushStack(this.get().reverse(), arguments);
};
$(document).ready(function(){
	var ticks = [];
	var data = [];
	var ftp = [];
	var http = [];
	var mail = [];
	var aticks = [];
	var max = 0;
	var i = 1;
	var links = [];
	$('#datalegend').remove();
	$('#datatable tr').reverse().each(function() {
		var row = $(this);
		var day = $(row).children().first().text();
		var ftpd = $(row).children().first().next().text();
		var httpd = $(row).children().first().next().next().text();
		var maild = $(row).children().first().next().next().next().text();
		if ($(row).children().first().next().next().next().next().next().length > 0)
		{
			links.push($(row).children().last().html());
		}
		ftp.push([i, parseFloat(ftpd) / 1024]);
		http.push([i, parseFloat(httpd) / 1024]);
		mail.push([i, parseFloat(maild) / 1024]);
		aticks.push([i, day]);
		if (ftpd > max)
		{
			max = ftpd;
		}
		if (httpd > max)
		{
			max = httpd;
		}
		if (maild > max)
		{
			max = maild;
		}
		ticks.push(day);
		i++;
	});
	$('#datatable').hide();
	data.push(ftp);
	data.push(http);
	data.push(mail);
	if (links.length > 0)
	{
		var tmp = $('<div />', {id: 'linkslist'});
		$.each(links, function(i, link) {
			tmp.append(link);
			if (i != links.length - 1)
			{
				tmp.append('&nbsp;|&nbsp;');
			}
		});
		tmp.insertBefore($('#datatable'));
	}
	
	var dataset = [
		{
			label: 'FTP',
			data: ftp,
			color: '#019522'
		},
		{
			label: 'HTTP',
			data: http,
			color: '#0000FF'
		},
		{
			label: 'Mail',
			data: mail,
			color: '#800000'
		}
	];
	
	var options = {
		series: {
			shadowSize: 0,
			curvedLines: { active: true, apply: false, fitPointDist: true },
		},
		lines: {
			show: true
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
		}
	}
	
	
	var flot1 = $.plot('#chartdiv', dataset, options);

	$("<div id='tooltip'></div>").css({
		position: "absolute",
		display: "none",
		padding: "4px 8px",
		"background-color": "#000",
		opacity: 0.85,
		color: "#fff",
		"font-size": "11px"
	}).appendTo("body");
	
	$("#chartdiv").bind("plothover", function (event, pos, item) {
		if (item) {
			var x = item.datapoint[0].toFixed(2),
				y = item.datapoint[1].toFixed(2);

			$("#tooltip").html(item.series.label + ": " + y + " GiB")
				.css({top: item.pageY+5, left: item.pageX+5})
				.fadeIn(200);
		} else {
			$("#tooltip").hide();
		}
	});	

});

