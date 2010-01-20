$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<input type="hidden" name="id" value="$id" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['templates']['template_add']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['templates']['action']}</td>
				<td class="main_field_display" nowrap="nowrap">{$lng['admin']['templates'][$row['varname']]}</td>
			</tr>
			<tr>
				<td class="main_field_name" valign="top" nowrap="nowrap">{$lng['admin']['templates']['filecontent']}</td>
				<td class="main_field_display" nowrap="nowrap"><textarea class="textarea_border" name="filecontent" rows="20" cols="75">{$row['value']}</textarea></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="filesend" value="filesend" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" /></td>
			</tr>
		</table>
	<br />
	<br />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="2"><b>&nbsp;<img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['templates']['template_replace_vars']}</b></td>
			</tr>
			<tr>
				<td class="field_display_border_left" colspan="2"><b>{$lng['admin']['templates']['index_html']}</b></td>
			</tr>
			<tr>
				<td class="field_name_border_left"><i>{SERVERNAME}</i>:</td>
				<td class="field_name">{$lng['admin']['templates']['SERVERNAME']}</td>
			</tr>
			<tr>
				<td class="field_name_border_left"><i>{CUSTOMER}</i>:</td>
				<td class="field_name">{$lng['admin']['templates']['CUSTOMER']}</td>
			</tr>
			<tr>
				<td class="field_name_border_left"><i>{ADMIN}</i>:</td>
				<td class="field_name">{$lng['admin']['templates']['ADMIN']}</td>
			</tr>
			<tr>
				<td class="field_name_border_left"><i>{CUSTOMER_EMAIL}</i>:</td>
				<td class="field_name">{$lng['admin']['templates']['CUSTOMER_EMAIL']}</td>
			</tr>
			<tr>
				<td class="field_name_border_left"><i>{ADMIN_EMAIL}</i>:</td>
				<td class="field_name">{$lng['admin']['templates']['ADMIN_EMAIL']}</td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer