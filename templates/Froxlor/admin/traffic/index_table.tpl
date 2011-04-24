	
	<table class="bradiusodd" id="stats{$overview['year']}">
		<caption>{$lng['traffic']['trafficoverview']}&nbsp;{$overview['type']}&nbsp;{$overview['year']}</caption>
		<thead>
			<tr>
				<th>{$overview['type']}</th>
				<th>{$lng['traffic']['months']['jan']}</td>
				<th>{$lng['traffic']['months']['feb']}</td>
				<th>{$lng['traffic']['months']['mar']}</td>
				<th>{$lng['traffic']['months']['apr']}</td>
				<th>{$lng['traffic']['months']['may']}</td>
				<th>{$lng['traffic']['months']['jun']}</td>
				<th>{$lng['traffic']['months']['jul']}</td>
				<th>{$lng['traffic']['months']['aug']}</td>
				<th>{$lng['traffic']['months']['sep']}</td>
				<th>{$lng['traffic']['months']['oct']}</td>
				<th>{$lng['traffic']['months']['nov']}</td>
				<th>{$lng['traffic']['months']['dec']}</td>
			</tr>
		</thead>
		<tbody>
			{$domain_list}
		</tbody>
		<tfoot>
			{$total_list}
			<tr>
				<td colspan="13">&nbsp;</td>
			</tr>
		</tfoot>
	</table>
	<script type="text/javascript">
		var myTextExtraction = function(node)  
		{  
		    // extract data from markup and return it  
		    if(node.innerHTML != '-') {
			return 1 + node.innerHTML.substr(0,node.innerHTML.length); 
		    } else {
			return '0 B';
		    }
		} 
		$(document).ready(function() 
		{ 
			$("#stats{$overview['year']}").tablesorter( {
				textExtraction: myTextExtraction,
				headers: {
					1: {sorter: 'filesize'},
					2: {sorter: 'filesize'},
					3: {sorter: 'filesize'},
					4: {sorter: 'filesize'},
					5: {sorter: 'filesize'},
					6: {sorter: 'filesize'},
					7: {sorter: 'filesize'},
					8: {sorter: 'filesize'},
					9: {sorter: 'filesize'},
					10: {sorter: 'filesize'},
					11: {sorter: 'filesize'},
					12: {sorter: 'filesize'}
				},
			});
		} 
		); 
	</script>
	<br />
	<br />

