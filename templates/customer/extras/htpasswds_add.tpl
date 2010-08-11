$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['extras']['directoryprotection_add']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">
					<b>{$lng['panel']['path']}:</b><br />
					<if $settings['panel']['pathedit'] != 'Dropdown'><font size="1">{$lng['panel']['pathDescription']}</font></if>
				</td>
				<td class="main_field_display" nowrap="nowrap">{$pathSelect}</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['login']['username']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="username" size="30" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['login']['password']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="password" name="directory_password" size="30" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['extras']['htpasswdauthname']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" name="directory_authname" size="30" /></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['extras']['directoryprotection_add']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer