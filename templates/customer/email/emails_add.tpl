$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['emails']['emails_add']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['emails']['emailaddress']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" name="email_part" value="" size="15" /> @ <select class="dropdown_noborder" name="domain">$domains</select></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['emails']['iscatchall']}</td>
				<td class="main_field_display" nowrap="nowrap">$iscatchall</td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['emails']['emails_add']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer