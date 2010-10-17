$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['ipsandports']['add']}</b></td>
			</tr>
			<tr>
				<td class="maintitle_apply_left">
					<b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['ipsandports']['ipandport']}</b>
				</td>
				<td class="maintitle_apply_right" nowrap="nowrap">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['ip']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="ip" value="" size="39" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['port']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="port" value="" size="5" /></td>
			</tr>
			<tr>
				<td class="maintitle_apply_left">
					<b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['ipsandports']['webserverdefaultconfig']}</b>
				</td>
				<td class="maintitle_apply_right" nowrap="nowrap">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['create_listen_statement']}:</td>
				<td class="main_field_display" nowrap="nowrap">$listen_statement</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['create_namevirtualhost_statement']}:
				<if $settings['system']['webserver'] == 'lighttpd'><div style="color:red">{$lng['panel']['not_supported']}lighttpd</div></if>
				</td>
				<td class="main_field_display" nowrap="nowrap">$namevirtualhost_statement</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['create_vhostcontainer']}:
				<if $settings['system']['webserver'] == 'lighttpd'><div style="color:red">{$lng['panel']['not_supported']}lighttpd</div></if>
				</td>
				<td class="main_field_display" nowrap="nowrap">$vhostcontainer</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['docroot']['title']}:<br /><font size="1">{$lng['admin']['ipsandports']['docroot']['description']}</font></td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="docroot" value="" /></td>
			</tr>
			<tr>
				<td class="main_field_name" valign="top">{$lng['admin']['ownvhostsettings']}:<br /><font size="1">{$lng['serversettings']['default_vhostconf']['description']}</font>
				<if $settings['system']['webserver'] == 'lighttpd'><div style="color:red">{$lng['panel']['not_supported']}lighttpd</div></if>
				</td>
				<td class="main_field_display" nowrap="nowrap"><textarea class="textarea_border" rows="12" cols="60" name="specialsettings"></textarea></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement']}:
				<if $settings['system']['webserver'] == 'lighttpd'><div style="color:red">{$lng['panel']['not_supported']}lighttpd</div></if>
				</td>
				<td class="main_field_display" nowrap="nowrap">$vhostcontainer_servername_statement</td>
			</tr>
			<tr>
				<td class="maintitle_apply_left">
					<b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['ipsandports']['webserverdomainconfig']}</b>
				</td>
				<td class="maintitle_apply_right" nowrap="nowrap">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
			<tr>
				<td class="main_field_name" valign="top">{$lng['admin']['ipsandports']['default_vhostconf_domain']}:<br /><font size="1">{$lng['serversettings']['default_vhostconf']['description']}</font>
				<if $settings['system']['webserver'] == 'lighttpd'><div style="color:red">{$lng['panel']['not_supported']}lighttpd</div></if>
				</td>
				<td class="main_field_display" nowrap="nowrap"><textarea class="textarea_border" rows="12" cols="60" name="default_vhostconf_domain"></textarea></td>
			</tr>
			<if $settings['system']['use_ssl'] == 1>
			<tr>
				<td class="maintitle_apply_left">
					<b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['ipsandports']['webserverssldomainconfig']}</b>
				</td>
				<td class="maintitle_apply_right" nowrap="nowrap">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['enable_ssl']}</td>
				<td class="main_field_display" nowrap="nowrap">$enable_ssl</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['ssl_cert_file']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="ssl_cert_file" value="" size="32" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['ssl_key_file']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="ssl_key_file" value="" size="32" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['ssl_ca_file']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="ssl_ca_file" value="" size="32" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['ipsandports']['ssl_cert_chainfile']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="ssl_cert_chainfile" value="" size="32" /></td>
			</tr>
			</if>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
