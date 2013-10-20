$header
	<article>
	
	<section class="dboarditemfull bradius">
		<table>
		<tr>
			<th colspan="2">{$lng['admin']['ressourcedetails']}</th>
		</tr>
		<tr>
			<td width="50%">{$lng['admin']['customers']} <small>{$lng['admin']['usedmax']}</small></td>
			<td>{$overview['number_customers']} ({$userinfo['customers']})</td>
		</tr>
		<tr>
			<td>{$lng['customer']['domains']} <small>{$lng['admin']['usedmax']}</small></td>
			<td>{$overview['number_domains']} ({$userinfo['domains']})</td>
		</tr>
		<tr>
			<td>{$lng['customer']['subdomains']} <small>{$lng['admin']['used']} ({$lng['admin']['assignedmax']})</small></td>
			<td>{$overview['subdomains_used']} ({$userinfo['subdomains_used']}/{$userinfo['subdomains']})</td>
		</tr>
		<tr>
			<td>{$lng['customer']['diskspace']} <small>{$lng['admin']['used']} ({$lng['admin']['assignedmax']})</small></td>
			<td>{$overview['diskspace_used']} ({$userinfo['diskspace_used']}/{$userinfo['diskspace']})</td>
		</tr>
		<tr>
			<td>{$lng['customer']['traffic']} <small>{$lng['admin']['used']} ({$lng['admin']['assignedmax']})</small></td>
			<td>{$overview['traffic_used']} ({$userinfo['traffic_used']}/{$userinfo['traffic']})</td>
		</tr>
		<tr>
			<td>{$lng['customer']['mysqls']} <small>{$lng['admin']['used']} ({$lng['admin']['assignedmax']})</small></td>
			<td>{$overview['mysqls_used']} ({$userinfo['mysqls_used']}/{$userinfo['mysqls']})</td>
		</tr>
		<tr>
			<td>{$lng['customer']['emails']} <small>{$lng['admin']['used']} ({$lng['admin']['assignedmax']})</small></td>
			<td>{$overview['emails_used']} ({$userinfo['emails_used']}/{$userinfo['emails']})</td>
		</tr>
		<tr>
			<td>{$lng['customer']['accounts']} <small>{$lng['admin']['used']} ({$lng['admin']['assignedmax']})</small></td>
			<td>{$overview['email_accounts_used']} ({$userinfo['email_accounts_used']}/{$userinfo['email_accounts']})</td>
		</tr>
		<tr>
			<td>{$lng['customer']['forwarders']} <small>{$lng['admin']['used']} ({$lng['admin']['assignedmax']})</small></td>
			<td>{$overview['email_forwarders_used']} ({$userinfo['email_forwarders_used']}/{$userinfo['email_forwarders']})</td>
		</tr>
		<if $settings['system']['mail_quota_enabled'] == 1>
		<tr>
			<td>{$lng['customer']['email_quota']} <small>{$lng['admin']['used']} ({$lng['admin']['assignedmax']})</small></td>
			<td>{$overview['email_quota_used']} ({$userinfo['email_quota_used']}/{$userinfo['email_quota']})</td>
		</tr>
		</if>
		<if $settings['autoresponder']['autoresponder_active'] == 1>
		<tr>
			<td>{$lng['customer']['autoresponder']} <small>{$lng['admin']['usedmax']}</small></td>
			<td>{$userinfo['email_autoresponder_used']} ({$userinfo['email_autoresponder']})</td>
		</tr>
		</if>
		<if (int)$settings['aps']['aps_active'] == 1>
		<tr>
			<td>{$lng['aps']['numberofapspackages']} <small>{$lng['admin']['used']} ({$lng['admin']['assignedmax']})</small></td>
			<td>{$overview['aps_packages_used']} ({$userinfo['aps_packages_used']}/{$userinfo['aps_packages']})</td>
		</tr>
		</if>
		<tr>
			<td>{$lng['customer']['ftps']} <small>{$lng['admin']['used']} ({$lng['admin']['assignedmax']})</small></td>
			<td>{$overview['ftps_used']} ({$userinfo['ftps_used']}/{$userinfo['ftps']})</td>
		</tr>
		<if $settings['ticket']['enabled'] == 1>
		<tr>
			<td>{$lng['customer']['tickets']} <small>{$lng['admin']['used']} ({$lng['admin']['assignedmax']})</small></td>
			<td>{$overview['tickets_used']} ({$userinfo['tickets_used']}/{$userinfo['tickets']})</td>
		</tr>
		</if>
		<tr>
			<th colspan="2">{$lng['admin']['systemdetails']}</th>
		</tr>
		<tr>
			<td width="50%">{$lng['admin']['serversoftware']}:</td>
			<td>{$_SERVER['SERVER_SOFTWARE']}</td>
		</tr>
		<tr>
			<td>{$lng['admin']['phpversion']}:</td>
			<td>$phpversion</td>
		</tr>
		<tr>
			<td>{$lng['admin']['phpmemorylimit']}:</td>
			<td>$phpmemorylimit</td>
		</tr>
		<tr>
			<td>{$lng['admin']['mysqlserverversion']}:</td>
			<td>$mysqlserverversion</td>
		</tr>
		<tr>
			<td>{$lng['admin']['mysqlclientversion']}:</td>
			<td>$mysqlclientversion</td>
		</tr>
		<tr>
			<td>{$lng['admin']['webserverinterface']}:</td>
			<td>$webserverinterface</td>
		</tr>
		<tr>
			<td>{$lng['admin']['sysload']}:</td>
			<td>$load</td>
		</tr>
		<if $showkernel == 1>
			<tr>
				<td>Kernel:</td>
				<td>$kernel</td>
			</tr>
		</if>
		<if $uptime != ''>
		<tr>
			<td>Uptime:</td>
			<td>$uptime</td>
		</tr>
		</if>
		<tr>
			<th colspan="2">{$lng['admin']['froxlordetails']}</th>
		</tr>
		{$outstanding_tasks}		
		{$cron_last_runs}
		<tr width="50%">
			<td>{$lng['admin']['installedversion']}:</td>
			<td>{$version}{$branding}</td>
		</tr>
		<tr>
			<td>{$lng['admin']['latestversion']}:</td>
			<if $isnewerversion != 0 >
				<td><a href="$lookfornewversion_link"><strong>$lookfornewversion_lable</strong></a></td>
			<else>
				<td><a href="$lookfornewversion_link">$lookfornewversion_lable</a></td>
			</if>
		</tr>
		<if $isnewerversion != 0 >
		<tr>
			<td colspan="2"><strong>{$lng['admin']['newerversionavailable']}</strong></td>
		</tr>
			<if $lookfornewversion_addinfo != ''>
			<tr>
				<td colspan="2">$lookfornewversion_addinfo</td>
			</tr>
			</if>
		</if>
		</table>
	</section>
	<section style="float: clear"></section>

	</article>
$footer

