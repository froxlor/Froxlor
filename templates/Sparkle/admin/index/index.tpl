$header
	<article>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/domains_big.png" alt="" />
			{$lng['panel']['dashboard']}
		</h2>
		<div class="canvasitems" id="statsbox">
			<div class="canvasbox">
				<input type="hidden" id="customers" class="circular" used="{$overview['number_customers']}" available="{$userinfo['customers']}" assigned="{$userinfo['customers_used']}">
				<canvas id="customers-canvas" width="120" height="76"></canvas><br/>
				{$lng['admin']['customers']}<br />
				<small>
					{$overview['number_customers']} {$lng['panel']['used']}<br />
					{$userinfo['customers_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['customers'] != '∞'>
					{$userinfo['customers']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			
			<div class="canvasbox">
				<input type="hidden" id="domains" class="circular" used="{$overview['number_domains']}" available="{$userinfo['domains']}" assigned="{$userinfo['domains_used']}">
				<canvas id="domains-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['domains']}<br />
				<small>
					{$overview['number_domains']} {$lng['panel']['used']}<br />
					{$userinfo['domains_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['domains'] != '∞'>
					{$userinfo['domains']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			
			<div class="canvasbox">
				<input type="hidden" id="subdomains" class="circular" used="{$overview['subdomains_used']}" available="{$userinfo['subdomains']}" assigned="{$userinfo['subdomains_used']}">
				<canvas id="subdomains-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['subdomains']}<br />
				<small>
					{$overview['subdomains_used']} {$lng['panel']['used']}<br />
					{$userinfo['subdomains_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['subdomains'] != '∞'>
					{$userinfo['subdomains']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			
			<div class="canvasbox">
				<input type="hidden" id="diskspace" class="circular" used="{$overview['diskspace_used']}" available="{$userinfo['diskspace']}" assigned="{$userinfo['diskspace_used']}">
				<canvas id="diskspace-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['diskspace']}<br />
				<small>
					{$overview['diskspace_used']} {$lng['panel']['used']}<br />
					{$userinfo['diskspace_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['diskspace'] != '∞'>
					{$userinfo['diskspace']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			
			<div class="canvasbox">
				<input type="hidden" id="traffic" class="circular" used="{$overview['traffic_used']}" available="{$userinfo['traffic']}" assigned="{$userinfo['traffic_used']}">
				<canvas id="traffic-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['traffic']}<br />
				<small>
					{$overview['traffic_used']} {$lng['panel']['used']}<br />
					{$userinfo['traffic_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['traffic'] != '∞'>
					{$userinfo['traffic']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			
			<div class="canvasbox">
				<input type="hidden" id="mysqls" class="circular" used="{$overview['mysqls_used']}" available="{$userinfo['mysqls']}" assigned="{$userinfo['mysqls_used']}">
				<canvas id="mysqls-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['mysqls']}<br />
				<small>
					{$overview['mysqls_used']} {$lng['panel']['used']}<br />
					{$userinfo['mysqls_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['mysqls'] != '∞'>
					{$userinfo['mysqls']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			
			<div class="canvasbox">
			<input type="hidden" id="emails" class="circular" used="{$overview['emails_used']}" available="{$userinfo['emails']}" assigned="{$userinfo['emails_used']}">
			<canvas id="emails-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['emails']}<br />
				<small>
					{$overview['emails_used']} {$lng['panel']['used']}<br />
					{$userinfo['emails_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['emails'] != '∞'>
					{$userinfo['emails']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			
			<div class="canvasbox">
				<input type="hidden" id="email_accounts" class="circular" used="{$overview['email_accounts_used']}" available="{$userinfo['email_accounts']}" assigned="{$userinfo['email_accounts_used']}">
				<canvas id="email_accounts-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['accounts']}<br />
				<small>
					{$overview['email_accounts_used']} {$lng['panel']['used']}<br />
					{$userinfo['email_accounts_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['email_accounts'] != '∞'>
					{$userinfo['email_accounts']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			
			<div class="canvasbox">
				<input type="hidden" id="email_forwarders" class="circular" used="{$overview['email_forwarders_used']}" available="{$userinfo['email_forwarders']}" assigned="{$userinfo['email_forwarders_used']}">
				<canvas id="email_forwarders-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['forwarders']}<br />
				<small>
					{$overview['email_forwarders_used']} {$lng['panel']['used']}<br />
					{$userinfo['email_forwarders_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['email_forwarders'] != '∞'>
					{$userinfo['email_forwarders']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			
			<if $settings['system']['mail_quota_enabled'] == 1>
			<div class="canvasbox">
				<input type="hidden" id="email_quota" class="circular" used="{$overview['email_quota_used']}" available="{$userinfo['email_quota']}" assigned="{$userinfo['email_quota_used']}">
				<canvas id="email_quota-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['email_quota']}<br />
				<small>
					{$overview['email_quota_used']} {$lng['panel']['used']}<br />
					{$userinfo['email_quota_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['email_quota'] != '∞'>
					{$userinfo['email_quota']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			</if>
			
			<if $settings['autoresponder']['autoresponder_active'] == 1>
			<div class="canvasbox">
				<input type="hidden" id="email_autoresponder" class="circular" used="{$overview['email_autoresponder_used']}" available="{$userinfo['email_autoresponder']}" assigned="{$userinfo['email_autoresponder_used']}">
				<canvas id="email_autoresponder-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['autoresponder']}<br />
				<small>
					{$overview['email_autoresponder_used']} {$lng['panel']['used']}<br />
					{$userinfo['email_autoresponder_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['email_autoresponder'] != '∞'>
					{$userinfo['email_autoresponder']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			</if>
			
			<if (int)$settings['aps']['aps_active'] == 1>
			<div class="canvasbox">
				<input type="hidden" id="aps_packages" class="circular" used="{$overview['aps_packages_used']}" available="{$userinfo['aps_packages']}" assigned="{$userinfo['aps_packages_used']}">
				<canvas id="aps_packages-canvas" width="120" height="76"></canvas><br/>
				{$lng['aps']['numberofapspackages']}<br />
				<small>
					{$overview['aps_packages_used']} {$lng['panel']['used']}<br />
					{$userinfo['aps_packages_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['aps_packages'] != '∞'>
					{$userinfo['aps_packages']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			</if>
			
			<div class="canvasbox">
				<input type="hidden" id="ftps" class="circular" used="{$overview['ftps_used']}" available="{$userinfo['ftps']}" assigned="{$userinfo['ftps_used']}">
				<canvas id="ftps-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['ftps']}<br />
				<small>
					{$overview['ftps_used']} {$lng['panel']['used']}<br />
					{$userinfo['ftps_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['ftps'] != '∞'>
					{$userinfo['ftps']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			
			<if $settings['ticket']['enabled'] == 1>
			<div class="canvasbox">
				<input type="hidden" id="tickets" class="circular" used="{$overview['tickets_used']}" available="{$userinfo['tickets']}" assigned="{$userinfo['tickets_used']}">
				<canvas id="tickets-canvas" width="120" height="76"></canvas><br/>
				{$lng['customer']['tickets']}<br />
				<small>
					{$overview['tickets_used']} {$lng['panel']['used']}<br />
					{$userinfo['tickets_used']} {$lng['panel']['assigned']}<br />
					<if $userinfo['tickets'] != '∞'>
					{$userinfo['tickets']} {$lng['panel']['available']}
					</if>
				</small>
			</div>
			</if>
			
		</div>
		
		<h3>System Information</h3>
		<section class="dboarditem bradius">
		<table>
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
		</table>
		</section>
		<section class="dboarditem bradius">
		<table>
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
	<section style="clear:both"></section>

	</article>
$footer

