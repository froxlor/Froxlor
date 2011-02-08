$header
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td colspan="2" class="maintitle"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['admin']['ressourcedetails']}</b></td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['admin']['customers']}:</td>
			<td class="field_display">{$overview['number_customers']} ({$userinfo['customers']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['domains']}:</td>
			<td class="field_display">{$overview['number_domains']} ({$userinfo['domains']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['subdomains']}:</td>
			<td class="field_display">{$overview['subdomains_used']} ({$userinfo['subdomains_used']}/{$userinfo['subdomains']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['diskspace']}:</td>
			<td class="field_display">{$overview['diskspace_used']} ({$userinfo['diskspace_used']}/{$userinfo['diskspace']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['traffic']}:</td>
			<td class="field_display">{$overview['traffic_used']} ({$userinfo['traffic_used']}/{$userinfo['traffic']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['mysqls']}:</td>
			<td class="field_display">{$overview['mysqls_used']} ({$userinfo['mysqls_used']}/{$userinfo['mysqls']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['emails']}:</td>
			<td class="field_display">{$overview['emails_used']} ({$userinfo['emails_used']}/{$userinfo['emails']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['accounts']}:</td>
			<td class="field_display">{$overview['email_accounts_used']} ({$userinfo['email_accounts_used']}/{$userinfo['email_accounts']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['forwarders']}:</td>
			<td class="field_display">{$overview['email_forwarders_used']} ({$userinfo['email_forwarders_used']}/{$userinfo['email_forwarders']})</td>
		</tr>
		<if $settings['system']['mail_quota_enabled'] == 1>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['email_quota']}:</td>
			<td class="field_display">{$overview['email_quota_used']} ({$userinfo['email_quota_used']}/{$userinfo['email_quota']})</td>
		</tr>
		</if>
		<if $settings['autoresponder']['autoresponder_active'] == 1>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['autoresponder']}:</td>
			<td class="field_display">{$userinfo['email_autoresponder_used']} ({$userinfo['email_autoresponder']})</td>
		</tr>
		</if>
		<if (int)$settings['aps']['aps_active'] == 1>
		<tr>
			<td class="field_name_border_left">{$lng['aps']['numberofapspackages']}:</td>
			<td class="field_display">{$overview['aps_packages_used']} ({$userinfo['aps_packages_used']}/{$userinfo['aps_packages']})</td>
		</tr>
		</if>
		<if $settings['ticket']['enabled'] == 1>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['ftps']}:</td>
			<td class="field_display">{$overview['ftps_used']} ({$userinfo['ftps_used']}/{$userinfo['ftps']})</td>
		</tr>
		<tr>
			<td class="field_name_nobordersmall">{$lng['customer']['tickets']}:</td>
			<td class="field_display_nobordersmall">{$overview['tickets_used']} ({$userinfo['tickets_used']}/{$userinfo['tickets']})</td>
		</tr>
		<else>
		<tr>
			<td class="field_name_nobordersmall">{$lng['customer']['ftps']}:</td>
			<td class="field_display_nobordersmall">{$overview['ftps_used']} ({$userinfo['ftps_used']}/{$userinfo['ftps']})</td>
		</tr>
		</if>
		<if 0 < $awaitingtickets && $settings['ticket']['enabled'] == 1 >
		<tr>
			<td class="field_name_border_left" colspan="2"><b>{$awaitingtickets_text}</b></td>
		</tr>
		</if>
		<tr>
			<td colspan="2" class="maintitle"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['admin']['systemdetails']}</b></td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['admin']['serversoftware']}:</td>
			<td class="field_display">{$_SERVER['SERVER_SOFTWARE']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['admin']['phpversion']}:</td>
			<td class="field_display">$phpversion</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['admin']['phpmemorylimit']}:</td>
			<td class="field_display">$phpmemorylimit</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['admin']['mysqlserverversion']}:</td>
			<td class="field_display">$mysqlserverversion</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['admin']['mysqlclientversion']}:</td>
			<td class="field_display">$mysqlclientversion</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['admin']['webserverinterface']}:</td>
			<td class="field_display">$webserverinterface</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['admin']['sysload']}:</td>
			<td class="field_display">$load</td>
		</tr>
		<if $showkernel == 1>
			<tr>
				<td class="field_name_border_left">Kernel:</td>
				<td class="field_display">$kernel</td>
			</tr>
		</if>
		<if $uptime != ''>
		<tr>
			<td class="field_name_nobordersmall">Uptime:</td>
			<td class="field_display_nobordersmall">$uptime</td>
		</tr>
		</if>
		<tr>
			<td colspan="2" class="maintitle"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['admin']['froxlordetails']}</b></td>
		</tr>
		{$outstanding_tasks}		
		{$cron_last_runs}
		<tr>
			<td class="field_name_border_left">{$lng['admin']['installedversion']}:</td>
			<td class="field_display">{$version}{$branding}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['admin']['latestversion']}:</td>
			<if $isnewerversion != 0 >
				<td class="field_display"><a href="$lookfornewversion_link"><strong>$lookfornewversion_lable</strong></a></td>
			<else>
				<td class="field_display"><a href="$lookfornewversion_link">$lookfornewversion_lable</a></td>
			</if>
		</tr>
		<if $isnewerversion != 0 >
		<tr>
			<td class="field_name_border_left" colspan="2"><strong>{$lng['admin']['newerversionavailable']}</strong></td>
		</tr>
			<if $lookfornewversion_addinfo != ''>
			<tr>
				<td class="field_name_border_left" colspan="2">$lookfornewversion_addinfo</td>
			</tr>
			</if>
		</if>
	</table>
	<br />
	<br />
$footer
