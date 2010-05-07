$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['ftp']['account_add']}</b></td>
			</tr>
			<if $settings['customer']['ftpatdomain'] == '1'>
			<tr>
				<td class="main_field_name">{$lng['login']['username']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="ftp_username" size="30" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['domains']['domainname']}:</td>
				<td class="main_field_display" nowrap="nowrap"><select class="dropdown_noborder" name="ftp_domain">$domains</select></td>
			</tr>
			</if>
			<tr>
				<td class="main_field_name">{$lng['panel']['path']}:<if $settings['panel']['pathedit'] != 'Dropdown'><br /><font size="1">{$lng['panel']['pathDescription']}</font></if></td>
				<td class="main_field_display" nowrap="nowrap">{$pathSelect}</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['login']['password']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="password" name="ftp_password" size="30" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['customer']['sendinfomail']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$sendinfomail}</td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['ftp']['account_add']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
