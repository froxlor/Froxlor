<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td style="width:80px;">
		<a href="customer_traffic.php?month={$traf['month']}&year={$traf['year']}&s=$s">{$traf['monthname']}</a>
	</td>
	<td><img src="images/traffic_green.gif" width="{$traf['ftp']}%" height="9" alt="{$traf['ftptext']}" border="0" align="" title="{$traf['ftptext']}"><br><img src="images/traffic_blue.gif" width="{$traf['http']}%" height="9" alt="{$traf['httptext']}" border="0" align="" title="{$traf['httptext']}"><br><img src="images/traffic_red.gif" width="{$traf['mail']}%" height="9" alt="{$traf['mailtext']}" border="0" align="" title="{$traf['mailtext']}"></td>
	<td style="text-align:right; width:70px;">{$traf['byte']}</td>
</tr>
