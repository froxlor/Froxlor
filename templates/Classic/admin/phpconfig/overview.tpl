$header
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle_search_left" colspan="4"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['menue']['phpsettings']['maintitle']}</b></td>
			<td class="maintitle_search_right">&nbsp;</td>
		</tr>
		<tr>
			<td class="field_display_border_left">{$lng['admin']['phpsettings']['description']}</td>
			<td class="field_display">{$lng['admin']['phpsettings']['activedomains']}</td>
			<td class="field_display">{$lng['admin']['phpsettings']['binary']}</td>
			<td class="field_display">{$lng['admin']['phpsettings']['file_extensions']}</td>
			<td class="field_display">{$lng['admin']['phpsettings']['actions']}</td>
		</tr>
		$tablecontent
		<tr>
			<td class="field_display_border_left" colspan="5"><a href="$filename?s=$s&amp;page=$page&amp;action=add">{$lng['admin']['phpsettings']['addnew']}</a></td>
		</tr>
	</table>
	<br />
	<br />
$footer