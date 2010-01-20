$header
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<input type="hidden" name="action" value="add"/>
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['phpsettings']['addsettings']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name" width="200">{$lng['admin']['phpsettings']['description']}</td>
				<td class="main_field_display"><input name="description" maxlength="50" size="60" type="text" value=""/></td>
			</tr>
			<tr>
				<td class="main_field_name" width="200">{$lng['admin']['phpsettings']['binary']}</td>
				<td class="main_field_display"><input name="binary" maxlength="255" size="60" type="text" value="/usr/bin/php-cgi"/></td>
			</tr>
			<tr>
				<td class="main_field_name" width="200">{$lng['admin']['phpsettings']['file_extensions']}<br /><font size="1">{$lng['admin']['phpsettings']['file_extensions_note']}</font></td>
				<td class="main_field_display"><input name="file_extensions" maxlength="255" size="60" type="text" value="php"/></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['mod_fcgid_starter']['title']}</td>
				<td class="main_field_display"><input size="60" name="mod_fcgid_starter" value=""/></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['mod_fcgid_maxrequests']['title']}</td>
				<td class="main_field_display"><input size="60" name="mod_fcgid_maxrequests" value=""/></td>
			</tr>
			<tr>
				<td class="main_field_name" valign="top">{$lng['admin']['phpsettings']['phpinisettings']}</td>
				<td class="main_field_display" valign="top"><textarea name="phpsettings" cols="80" rows="20">{$result['phpsettings']}</textarea></td>
			</tr>
			<tr>
				<td class="maintitle_apply_right" colspan="2"><input class="bottom" type="reset" value="{$lng['panel']['reset']}" />&nbsp;<input class="bottom" type="submit" value="{$lng['panel']['save']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle" colspan="2"><b>&nbsp;<img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['phpconfig']['template_replace_vars']}</b></td>
		</tr>
		<tr>
			<td class="field_name_border_left"><i>{SAFE_MODE}</i></td>
			<td class="field_name">{$lng['admin']['phpconfig']['safe_mode']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left"><i>{PEAR_DIR}</i></td>
			<td class="field_name">{$lng['admin']['phpconfig']['pear_dir']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left"><i>{OPEN_BASEDIR}</i></td>
			<td class="field_name">{$lng['admin']['phpconfig']['open_basedir']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left"><i>{OPEN_BASEDIR_GLOBAL}</i></td>
			<td class="field_name">{$lng['admin']['phpconfig']['open_basedir_global']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left"><i>{TMP_DIR}</i></td>
			<td class="field_name">{$lng['admin']['phpconfig']['tmp_dir']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left"><i>{CUSTOMER_EMAIL}</i></td>
			<td class="field_name">{$lng['admin']['phpconfig']['customer_email']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left"><i>{ADMIN_EMAIL}</i></td>
			<td class="field_name">{$lng['admin']['phpconfig']['admin_email']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left"><i>{DOMAIN}</i></td>
			<td class="field_name">{$lng['admin']['phpconfig']['domain']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left"><i>{CUSTOMER}</i></td>
			<td class="field_name">{$lng['admin']['phpconfig']['customer']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left"><i>{ADMIN}</i></td>
			<td class="field_name">{$lng['admin']['phpconfig']['admin']}</td>
		</tr>
	</table>
	<br />
	<br />
$footer