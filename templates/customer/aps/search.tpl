<form method="get" action="$filename">
	<input type="hidden" name="s" value="$s" />
	<input type="hidden" name="page" value="$page" />
	<input type="hidden" name="action" value="$action" />
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['aps']['search']}</b></td>
		</tr>
		<tr>
			<td class="field_name_border_left" nowrap="nowrap" valign="top">{$lng['aps']['search_description']}</td>
			<td class="field_display" nowrap="nowrap"><input type="text" size="60" name="keyword" class="text" value="$Keyword"/></td>
		</tr>
		<tr>
			<td class="field_name_border_left" style="text-align: right;" colspan="2"><input class="bottom" type="submit" value="{$lng['aps']['search']}" /></td>
		</tr>
	</table>
	<br/>
</form>