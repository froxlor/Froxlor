$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="none" rowspan="8"><img src="images/logininternal.gif" alt="" /></td>
			</tr>
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['menue']['main']['changepassword']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['changepassword']['old_password']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="password" name="old_password" maxlength="50" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['changepassword']['new_password']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="password" name="new_password" maxlength="50" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['changepassword']['new_password_confirm']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="password" name="new_password_confirm" maxlength="50" /></td>
			</tr>
			<tr>
				<td class="main_field_name" colspan="2"><input type="checkbox" name="change_main_ftp" value="true" />{$lng['changepassword']['also_change_ftp']}</td>
			</tr>
			<tr>
				<td class="main_field_name" colspan="2"><input type="checkbox" name="change_webalizer" value="true" />{$lng['changepassword']['also_change_webalizer']}</td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['menue']['main']['changepassword']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer