<form method="post" action="$filename" enctype="multipart/form-data">
	<input type="hidden" name="s" value="$s" />
	<input type="hidden" name="page" value="$page" />
	<input type="hidden" name="action" value="$action" />
	<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['aps']['upload']}</b></td>
		</tr>
		<tr>
			<td class="main_field_name" nowrap="nowrap">{$lng['aps']['upload_description']} <a href="http://www.apsstandard.org/" target="_blank">http://www.apsstandard.org/</a></td>
		</tr>
		<tr>
			<td class="main_field_display" nowrap="nowrap"><br/>$Output</td>
		</tr>
		<tr>
			<td class="main_field_confirm"><input class="bottom" type="submit" value="{$lng['aps']['upload']}" /></td>
		</tr>
	</table>
</form>