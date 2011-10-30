jQuery.fn.reverse = function() {
	return this.pushStack(this.get().reverse(), arguments);
};
$(document).ready(function(){
	var ticks = [];
	var data = [];
	var ftp = [];
	var http = [];
	var mail = [];
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
		ftp.push([parseFloat(ftpd), i]);
		http.push([parseFloat(httpd), i]);
		mail.push([parseFloat(maild), i]);
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
	$('#chartdiv').height(parseFloat(i) * 50);
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
	var plot2 = $.jqplot('chartdiv', data, {
		stackSeries: false,
		captureRightClick: true,
		seriesDefaults: {
			renderer:$.jqplot.BarRenderer,
			pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
			shadowAngle: 135,
			rendererOptions: {
				barDirection: 'horizontal',
				highlightMouseOver: true,
			}
		},
		series: [
			{color: '#019522'},
			{color: '#0000FF'},
			{color: '#800000'}
		],
		axes: {
			yaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: ticks,
			},
			xaxis: {
				min: 0,
			},
		},
	})
});

