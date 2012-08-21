$header
	<form action="{$linker->getLink(array('section' => 'phpsettings'))}" method="post">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<input type="hidden" name="action" value="edit"/>
		<input type="hidden" name="id" value="$id"/>
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="templates/{$theme}/assets/img/title.gif" alt="{$title}" />&nbsp;{$title}</b></td>
			</tr>
			{$phpconfig_edit_form}
		</table>
	</form>
	<br />
	<br />
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle" colspan="2"><b>&nbsp;<img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['admin']['phpconfig']['template_replace_vars']}</b></td>
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
			<td class="field_name_border_left"><i>{OPEN_BASEDIR_C}</i></td>
			<td class="field_name">{$lng['admin']['phpconfig']['open_basedir_c']}</td>
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
