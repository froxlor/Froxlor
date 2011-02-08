$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['domains']['subdomain_add']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['domains']['domainname']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" name="subdomain" value="" size="15" maxlength="50" /> <b>.</b> <select class="tendina_nobordo" name="domain">$domains</select></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['domains']['aliasdomain']}:</td>
				<td class="main_field_display" nowrap="nowrap"><select name="alias">$aliasdomains</select></td>
			</tr>
			<if $settings['panel']['pathedit'] != 'Dropdown'>
				<tr>
					<td class="main_field_name">{$lng['panel']['pathorurl']}:<br /><font size="1">{$lng['panel']['pathDescription']}{$lng['panel']['pathDescriptionEx']}</font></td>
					<td class="main_field_display" nowrap="nowrap">{$pathSelect}</td>
				</tr>
			</if>
			<if $settings['panel']['pathedit'] == 'Dropdown'>
				<tr>
					<td class="main_field_name">{$lng['panel']['path']}:</td>
					<td class="main_field_display">{$pathSelect}</td>
				</tr>
				<tr>
					<td class="main_field_name">{$lng['panel']['urloverridespath']}:</td>
					<td class="main_field_display"><input type="text" class="text" name="url" value="{$urlvalue}" size="30" /></td>
				</tr>
			</if>
			<if $settings['system']['webserver'] == 'apache2' && $settings['customredirect']['enabled'] == '1'>
				<tr>
					<td class="main_field_name">{$lng['domains']['redirectifpathisurl']}:<br /><font size="1">{$lng['domains']['redirectifpathisurlinfo']}</font></td>
					<td class="main_field_display" nowrap="nowrap"><select name="redirectcode">$redirectcode</select></td>
				</tr>
			</if>
			<if $settings['system']['use_ssl'] == '1'>
                        <tr>
                                <td class="main_field_name">SSL Redirect:</td>
                                <td class="main_field_display" nowrap="nowrap">$ssl_redirect</td>
                        </tr>
			</if>
			<tr>
				<td class="main_field_name">{$lng['domain']['openbasedirpath']}:</td>
				<td class="main_field_display" nowrap><select name="openbasedir_path">$openbasedir</select></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['domains']['subdomain_add']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer