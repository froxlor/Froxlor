$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<input type="hidden" name="id" value="$id" />
		<input type="hidden" name="send" value="send" />
		<if $override_billing_data_edit === true><input type="hidden" name="override_billing_data_edit" value="1" /></if>
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['domain_edit']}</b></td>
			</tr>
			<tr>
				<td class="maintitle_apply_left">
					<b><img src="images/title.gif" alt="" />&nbsp;{$lng['domains']['domainsettings']}</b>
				</td>
				<td class="maintitle_apply_right" nowrap="nowrap">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
			<tr>
				<td class="main_field_name">Domain:</td>
				<td class="main_field_display" nowrap="nowrap">{$result['domain']}</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['customer']}:</td>
				<td class="main_field_display" nowrap="nowrap"><if $settings['panel']['allow_domain_change_customer'] == '1'><select class="dropdown_noborder" name="customerid">$customers</select><else>{$result['customername']}</if></td>
			</tr>
			<if $userinfo['customers_see_all'] == '1'>
			<tr>
				<td class="main_field_name">{$lng['admin']['admin']}:</td>
				<td class="main_field_display" nowrap="nowrap"><if $settings['panel']['allow_domain_change_admin'] == '1'><select class="dropdown_noborder" name="adminid">$admins</select><else>{$result['adminname']}</if></td>
			</tr>
			</if>
			<if $alias_check == '0'>
			<tr>
				<td class="main_field_name">{$lng['domains']['aliasdomain']}:</td>
				<td class="main_field_display" nowrap="nowrap"><select class="dropdown_noborder" name="alias">$domains</select></td>
			</tr>
			</if>
			<tr>
				<td class="main_field_name">{$lng['domains']['associated_with_domain']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$subdomains} {$lng['customer']['subdomains']}, {$alias_check} {$lng['domains']['aliasdomains']}, {$emails} {$lng['customer']['emails']}, {$email_accounts} {$lng['customer']['accounts']}, {$email_forwarders} {$lng['customer']['forwarders']}</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['domain_edit']}:</td>
				<td class="main_field_display" nowrap="nowrap">$caneditdomain</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['domains']['add_date']}: ({$lng['panel']['dateformat']})</td>
				<td class="main_field_display" nowrap="nowrap">{$result['add_date']}</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['domains']['registration_date']}: ({$lng['panel']['dateformat']})</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" name="registration_date" value="{$result['registration_date']}" size="10" /></td>
			</tr>
			<tr>
				<td class="maintitle_apply_left">
					<b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['webserversettings']}</b>
				</td>
				<td class="maintitle_apply_right" nowrap="nowrap">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
			<if $userinfo['change_serversettings'] == '1'>
			<tr>
				<td class="main_field_name">DocumentRoot:<br />({$lng['panel']['emptyfordefault']})</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="documentroot" value="{$result['documentroot']}" size="60" /></td>
			</tr>
			</if>
			<tr>
				<td class="main_field_name">IP/Port:</td>
				<td class="main_field_display" nowrap="nowrap"><select class="dropdown_noborder" name="ipandport">$ipsandports</select></td>
			</tr>
			<if $settings['system']['use_ssl'] == 1>
				<if $ssl_ipsandports != ''>
				<tr>
					<td class="main_field_name">SSL:</td>
					<td class="main_field_display" nowrap="nowrap">$ssl</td>
				</tr>
				<tr>
					<td class="main_field_name">SSL Redirect:</td>
					<td class="main_field_display" nowrap="nowrap">$ssl_redirect</td>
				</tr>
				<tr>
					<td class="main_field_name">SSL IP/Port:</td>
					<td class="main_field_display" nowrap="nowrap"><select class="dropdown_noborder" name="ssl_ipandport">$ssl_ipsandports</select></td>
				</tr>
				<else>
				<tr>
					<td class="main_field_name" colspan="2">{$lng['panel']['nosslipsavailable']}</td>
				</tr>
				</if>
			</if>
			<tr>
				<td class="main_field_name">{$lng['admin']['wwwserveralias']}:</td>
				<td class="main_field_display" nowrap="nowrap">$wwwserveralias</td>
			</tr>
			<tr>
				<td class="main_field_name">Speciallogfile:</td>
				<td class="main_field_display" nowrap="nowrap"><b>$speciallogfile</b></td>
			</tr>
			<if $userinfo['change_serversettings'] == '1'>
			<tr>
				<td class="main_field_name" valign="top">{$lng['admin']['ownvhostsettings']}:<br /><font size="1">{$lng['serversettings']['default_vhostconf']['description']}</font></td>
				<td class="main_field_display" nowrap="nowrap"><textarea class="textarea_border" rows="12" cols="60" name="specialsettings">{$result['specialsettings']}</textarea></td>
			</tr>
			</if>
			<if $userinfo['change_serversettings'] == '1' || $userinfo['caneditphpsettings'] == '1'>
			<tr>
				<td class="maintitle_apply_left">
					<b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['phpserversettings']}</b>
				</td>
				<td class="maintitle_apply_right" nowrap="nowrap">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
			<tr>
				<td class="main_field_name">OpenBasedir:</td>
				<td class="main_field_display" nowrap="nowrap">$openbasedir</td>
			</tr>
			<tr>
				<td class="main_field_name">Safemode:</td>
				<td class="main_field_display" nowrap="nowrap">$safemode</td>
			</tr>
			<if (int)$settings['system']['mod_fcgid'] == 1>
			<tr>
				<td class="main_field_name">{$lng['admin']['phpsettings']['title']}</td>
				<td class="main_field_display" nowrap="nowrap"><select name="phpsettingid">$phpconfigs</select></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['mod_fcgid_starter']['title']}</td>
				<td class="main_field_display" nowrap="nowrap"><input size="60" name="mod_fcgid_starter" value="<if (int)$result['mod_fcgid_starter'] != - 1>{$result['mod_fcgid_starter']}</if>"/></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['mod_fcgid_maxrequests']['title']}</td>
				<td class="main_field_display" nowrap="nowrap"><input size="60" name="mod_fcgid_maxrequests" value="<if (int)$result['mod_fcgid_maxrequests'] != - 1>{$result['mod_fcgid_maxrequests']}</if>"/></td>
			</tr>
			</if>
			</if>
			<if $userinfo['change_serversettings'] == '1'>
			<tr>
				<td class="maintitle_apply_left">
					<b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['nameserversettings']}</b>
				</td>
				<td class="maintitle_apply_right" nowrap="nowrap">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
			<tr>
				<td class="main_field_name">Nameserver:</td>
				<td class="main_field_display" nowrap="nowrap">$isbinddomain</td>
			</tr>
			<tr>
				<td class="main_field_name">Zonefile:<br />({$lng['panel']['emptyfordefault']})</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="zonefile" value="{$result['zonefile']}" size="60" /></td>
			</tr>
			</if>
			<tr>
				<td class="maintitle_apply_left">
					<b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['mailserversettings']}</b>
				</td>
				<td class="maintitle_apply_right" nowrap="nowrap">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['emaildomain']}:</td>
				<td class="main_field_display" nowrap="nowrap">$isemaildomain</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['email_only']}:</td>
				<td class="main_field_display" nowrap="nowrap">$email_only</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['subdomainforemail']}:</td>
				<td class="main_field_display" nowrap="nowrap"><select class="dropdown_noborder" name="subcanemaildomain">$subcanemaildomain</select></td>
			</tr>
			<if $settings['dkim']['use_dkim'] == '1'>
 			<tr>
				<td class="main_field_name">DomainKeys:</td>
				<td class="main_field_display" nowrap="nowrap">$dkim</td>
			</tr>
			</if>
			<tr>
				<td class="maintitle_apply_right" nowrap="nowrap" colspan="2">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer