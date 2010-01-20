$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<input type="hidden" name="id" value="$id" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['emails']['account_add']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['emails']['emailaddress']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$result['email_full']}</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['login']['password']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="password" name="email_password" maxlength="50" /></td>
			</tr>
			<if $settings['system']['mail_quota_enabled'] == 1>
			<tr>
				<td class="main_field_name">{$lng['emails']['quota']} ({$lng['panel']['megabyte']}):</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" name="email_quota" value="{$quota}" /></td>
			</tr>
			</if>
			<if $settings['panel']['sendalternativemail'] == 1>
			<tr>
				<td class="main_field_name">{$lng['emails']['alternative_emailaddress']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="alternative_email" maxlength="255" /></td>
			</tr>
			</if>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['emails']['account_add']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer