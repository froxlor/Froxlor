	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable" id="stats{$overview['year']}">
		<thead>
			<tr>
				<td colspan="13" class="maintitle"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['traffic']['trafficoverview']}&nbsp;{$overview['type']}&nbsp;{$overview['year']}</b></td>
			</tr>
			<tr>
				<th class="field_display_border_left" style="text-align:left;">{$overview['type']}</th>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['jan']}</td>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['feb']}</td>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['mar']}</td>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['apr']}</td>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['may']}</td>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['jun']}</td>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['jul']}</td>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['aug']}</td>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['sep']}</td>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['oct']}</td>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['nov']}</td>
				<th class="field_display" style="text-align:right;">{$lng['traffic']['months']['dec']}</td>
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
			return '1';
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
		}); 
	</script>
	<br />
	<br />

