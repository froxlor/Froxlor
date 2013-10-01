<tr>
	<td>{$traf['monthname']}</td>
	<td>{$traf['ftp']}</td>
	<td>{$traf['http']}</td>
	<td>{$traf['mail']}</td>
	<td style="text-align:right; width:70px;">{$traf['byte']}</td>
	<td><a href="{$linker->getLink(array('section' => 'traffic', 'month' => $traf['month'], 'year' => $traf['year']))}">{$traf['monthname']}</a></td>
</tr>
