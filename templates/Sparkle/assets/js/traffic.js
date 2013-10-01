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
		mail.push([i, parseFloat(maild)] / 1024);
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
	//alert(ftp);
	var plot2 = $.jqplot('chartdiv', [ftp, http, mail], {
		series: [
			{
				lineWidth:1,
				color: '#019522',
				label: 'FTP',
				showMarker: false
			},
			{
				lineWidth:1,
				color: '#0000FF',
				label: 'HTTP',
				showMarker: false
			},
			{
				lineWidth:1,
				color: '#800000',
				label: 'Mail',
				showMarker: false
			}	
		],
		axes: {
			yaxis: {
				min: 0,
				numberTicks: 10
			},
			xaxis: {
				pad: 0,
				ticks: aticks
			},
		},
		grid: {
			background: '#fff',
			borderWidth: 0,
			shadow: false
		}
	});
});

