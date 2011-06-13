<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left" width="80">
		<a href="{$linker->getLink(array('section' => 'traffic', 'month' => $traf['month'], 'year' => $traf['year']))}">{$traf['monthname']}</a>
	</td>
	<td class="field_name"><img src="images/Classic/traffic_green.gif" width="{$traf['ftp']}%" height="9" alt="{$traf['ftptext']}" border="0" align="" title="{$traf['ftptext']}"><br><img src="images/Classic/traffic_blue.gif" width="{$traf['http']}%" height="9" alt="{$traf['httptext']}" border="0" align="" title="{$traf['httptext']}"><br><img src="images/Classic/traffic_red.gif" width="{$traf['mail']}%" height="9" alt="{$traf['mailtext']}" border="0" align="" title="{$traf['mailtext']}"></td>
	<td class="field_name" align="right" width="70">{$traf['byte']}</td>
</tr>
