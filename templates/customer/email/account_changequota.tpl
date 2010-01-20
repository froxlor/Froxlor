$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<input type="hidden" name="id" value="$id" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['emails']['quota_edit']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['emails']['emailaddress']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$result['email_full']}</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['emails']['quota']} ({$lng['panel']['megabyte']}):</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" name="email_quota" value="{$result['quota']}" maxlength="50" /></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['emails']['quota_edit']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer