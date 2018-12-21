$header
	<article>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/domains_big.png" alt="" />
			{\Froxlor\I18N\Lang::getAll()['panel']['dashboard']}
		</h2>

		<div class="grid-g">
			<div class="grid-u-1-2" id="statsbox">
				<div class="canvasbox">
					<input type="hidden" id="customers" class="circular" data-used="{$overview['number_customers']}" data-available="{\Froxlor\User::getAll()['customers']}">
					<canvas id="customers-canvas" width="120" height="76"></canvas><br/>
					{\Froxlor\I18N\Lang::getAll()['admin']['customers']}<br />
					<small>
						{$overview['number_customers']} {\Froxlor\I18N\Lang::getAll()['panel']['used']}<br />
						<if \Froxlor\User::getAll()['customers'] != '∞'>
						{\Froxlor\User::getAll()['customers']} {\Froxlor\I18N\Lang::getAll()['panel']['available']}
						</if>
					</small>
				</div>

				<div class="canvasbox">
					<input type="hidden" id="domains" class="circular" data-used="{$overview['number_domains']}" data-available="{\Froxlor\User::getAll()['domains']}">
					<canvas id="domains-canvas" width="120" height="76"></canvas><br/>
					{\Froxlor\I18N\Lang::getAll()['customer']['domains']}<br />
					<small>
						{$overview['number_domains']} {\Froxlor\I18N\Lang::getAll()['panel']['used']}<br />
						<if \Froxlor\User::getAll()['domains'] != '∞'>
						{\Froxlor\User::getAll()['domains']} {\Froxlor\I18N\Lang::getAll()['panel']['available']}
						</if>
					</small>
				</div>

				<div class="canvasbox">
					<input type="hidden" id="subdomains" class="circular" data-used="{$overview['subdomains_used']}" data-available="{\Froxlor\User::getAll()['subdomains']}" data-assigned="{\Froxlor\User::getAll()['subdomains_used']}">
					<canvas id="subdomains-canvas" width="120" height="76"></canvas><br/>
					{\Froxlor\I18N\Lang::getAll()['customer']['subdomains']}<br />
					<small>
						{$overview['subdomains_used']} {\Froxlor\I18N\Lang::getAll()['panel']['used']}<br />
						{\Froxlor\User::getAll()['subdomains_used']} {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}<br />
						<if \Froxlor\User::getAll()['subdomains'] != '∞'>
						{\Froxlor\User::getAll()['subdomains']} {\Froxlor\I18N\Lang::getAll()['panel']['available']}
						</if>
					</small>
				</div>

				<div class="canvasbox">
					<input type="hidden" id="diskspace" class="circular" data-used="{$overview['diskspace_used']}" data-available="{\Froxlor\User::getAll()['diskspace']}" data-assigned="{\Froxlor\User::getAll()['diskspace_used']}">
					<canvas id="diskspace-canvas" width="120" height="76"></canvas><br/>
					{\Froxlor\I18N\Lang::getAll()['customer']['diskspace']}<br />
					<small>
						{$overview['diskspace_used']} {\Froxlor\I18N\Lang::getAll()['panel']['used']}<br />
						{\Froxlor\User::getAll()['diskspace_used']} {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}<br />
						<if \Froxlor\User::getAll()['diskspace'] != '∞'>
						{\Froxlor\User::getAll()['diskspace']} {\Froxlor\I18N\Lang::getAll()['panel']['available']}
						</if>
					</small>
				</div>

				<div class="canvasbox">
					<input type="hidden" id="traffic" class="circular" data-used="{$overview['traffic_used']}" data-available="{\Froxlor\User::getAll()['traffic']}" data-assigned="{\Froxlor\User::getAll()['traffic_used']}">
					<canvas id="traffic-canvas" width="120" height="76"></canvas><br/>
					{\Froxlor\I18N\Lang::getAll()['customer']['traffic']}<br />
					<small>
						{$overview['traffic_used']} {\Froxlor\I18N\Lang::getAll()['panel']['used']}<br />
						{\Froxlor\User::getAll()['traffic_used']} {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}<br />
						<if \Froxlor\User::getAll()['traffic'] != '∞'>
						{\Froxlor\User::getAll()['traffic']} {\Froxlor\I18N\Lang::getAll()['panel']['available']}
						</if>
					</small>
				</div>

				<div class="canvasbox">
					<input type="hidden" id="mysqls" class="circular" data-used="{$overview['mysqls_used']}" data-available="{\Froxlor\User::getAll()['mysqls']}" data-assigned="{\Froxlor\User::getAll()['mysqls_used']}">
					<canvas id="mysqls-canvas" width="120" height="76"></canvas><br/>
					{\Froxlor\I18N\Lang::getAll()['customer']['mysqls']}<br />
					<small>
						{$overview['mysqls_used']} {\Froxlor\I18N\Lang::getAll()['panel']['used']}<br />
						{\Froxlor\User::getAll()['mysqls_used']} {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}<br />
						<if \Froxlor\User::getAll()['mysqls'] != '∞'>
						{\Froxlor\User::getAll()['mysqls']} {\Froxlor\I18N\Lang::getAll()['panel']['available']}
						</if>
					</small>
				</div>

				<div class="canvasbox">
				<input type="hidden" id="emails" class="circular" data-used="{$overview['emails_used']}" data-available="{\Froxlor\User::getAll()['emails']}" data-assigned="{\Froxlor\User::getAll()['emails_used']}">
				<canvas id="emails-canvas" width="120" height="76"></canvas><br/>
					{\Froxlor\I18N\Lang::getAll()['customer']['emails']}<br />
					<small>
						{$overview['emails_used']} {\Froxlor\I18N\Lang::getAll()['panel']['used']}<br />
						{\Froxlor\User::getAll()['emails_used']} {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}<br />
						<if \Froxlor\User::getAll()['emails'] != '∞'>
						{\Froxlor\User::getAll()['emails']} {\Froxlor\I18N\Lang::getAll()['panel']['available']}
						</if>
					</small>
				</div>

				<div class="canvasbox">
					<input type="hidden" id="email_accounts" class="circular" data-used="{$overview['email_accounts_used']}" data-available="{\Froxlor\User::getAll()['email_accounts']}" data-assigned="{\Froxlor\User::getAll()['email_accounts_used']}">
					<canvas id="email_accounts-canvas" width="120" height="76"></canvas><br/>
					{\Froxlor\I18N\Lang::getAll()['customer']['accounts']}<br />
					<small>
						{$overview['email_accounts_used']} {\Froxlor\I18N\Lang::getAll()['panel']['used']}<br />
						{\Froxlor\User::getAll()['email_accounts_used']} {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}<br />
						<if \Froxlor\User::getAll()['email_accounts'] != '∞'>
						{\Froxlor\User::getAll()['email_accounts']} {\Froxlor\I18N\Lang::getAll()['panel']['available']}
						</if>
					</small>
				</div>

				<div class="canvasbox">
					<input type="hidden" id="email_forwarders" class="circular" data-used="{$overview['email_forwarders_used']}" data-available="{\Froxlor\User::getAll()['email_forwarders']}" data-assigned="{\Froxlor\User::getAll()['email_forwarders_used']}">
					<canvas id="email_forwarders-canvas" width="120" height="76"></canvas><br/>
					{\Froxlor\I18N\Lang::getAll()['customer']['forwarders']}<br />
					<small>
						{$overview['email_forwarders_used']} {\Froxlor\I18N\Lang::getAll()['panel']['used']}<br />
						{\Froxlor\User::getAll()['email_forwarders_used']} {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}<br />
						<if \Froxlor\User::getAll()['email_forwarders'] != '∞'>
						{\Froxlor\User::getAll()['email_forwarders']} {\Froxlor\I18N\Lang::getAll()['panel']['available']}
						</if>
					</small>
				</div>

				<if \Froxlor\Settings::Get('system.mail_quota_enabled') == 1>
				<div class="canvasbox">
					<input type="hidden" id="email_quota" class="circular" data-used="{$overview['email_quota_used']}" data-available="{\Froxlor\User::getAll()['email_quota']}" data-assigned="{\Froxlor\User::getAll()['email_quota_used']}">
					<canvas id="email_quota-canvas" width="120" height="76"></canvas><br/>
					{\Froxlor\I18N\Lang::getAll()['customer']['email_quota']}<br />
					<small>
						{$overview['email_quota_used']} {\Froxlor\I18N\Lang::getAll()['panel']['used']}<br />
						{\Froxlor\User::getAll()['email_quota_used']} {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}<br />
						<if \Froxlor\User::getAll()['email_quota'] != '∞'>
						{\Froxlor\User::getAll()['email_quota']} {\Froxlor\I18N\Lang::getAll()['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<div class="canvasbox">
					<input type="hidden" id="ftps" class="circular" data-used="{$overview['ftps_used']}" data-available="{\Froxlor\User::getAll()['ftps']}" data-assigned="{\Froxlor\User::getAll()['ftps_used']}">
					<canvas id="ftps-canvas" width="120" height="76"></canvas><br/>
					{\Froxlor\I18N\Lang::getAll()['customer']['ftps']}<br />
					<small>
						{$overview['ftps_used']} {\Froxlor\I18N\Lang::getAll()['panel']['used']}<br />
						{\Froxlor\User::getAll()['ftps_used']} {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}<br />
						<if \Froxlor\User::getAll()['ftps'] != '∞'>
						{\Froxlor\User::getAll()['ftps']} {\Froxlor\I18N\Lang::getAll()['panel']['available']}
						</if>
					</small>
				</div>
			</div>

			<div class="grid-u-1-2">
				<if \Froxlor\Settings::Get('admin.show_news_feed') == '1'>
				<table class="dboarditem full" id="newsfeed">
					<thead>
						<tr>
							<th>News</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<ul class="newsfeed" id="newsfeeditems"></ul>
							</td>
						</tr>
					</tbody>
				</table>
				<else>
				<table class="dboarditem full">
					<tbody>
						<tr><td>
							<img src="templates/{$theme}/assets/img/icons/warning_big.png" alt="" />&nbsp;
							{\Froxlor\I18N\Lang::getAll()['panel']['newsfeed_disabled']}&nbsp;
							<a href="{$linker->getLink(array('section' => 'settings', 'part' => 'panel'))}">
								<img src="templates/{$theme}/assets/img/icons/edit_20.png" alt="" />
							</a>
						</td></tr>
					</tbody>
				</table>
				</if>

				<if \Froxlor\User::getAll()['custom_notes'] != '' && \Froxlor\User::getAll()['custom_notes_show'] == '1'>
				<table class="dboarditem full">
					<tbody>
						<tr><td>{\Froxlor\User::getAll()['custom_notes']}</td></tr>
					</tbody>
				</table>
				</if>

				<table class="dboarditem">
					<thead>
						<tr>
							<th colspan="2">{\Froxlor\I18N\Lang::getAll()['admin']['systemdetails']}</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{\Froxlor\I18N\Lang::getAll()['admin']['hostname']}:</td>
							<td>{$system_hostname}</td>
						</tr>
						<tr>
							<td>{\Froxlor\I18N\Lang::getAll()['admin']['serversoftware']}:</td>
							<td>{$_SERVER['SERVER_SOFTWARE']}</td>
						</tr>
						<tr>
							<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpversion']}:</td>
							<td><a href="{$linker->getLink(array('section' => 'settings', 'page' => 'phpinfo'))}">$phpversion</a></td>
						</tr>
						<tr>
							<td class="nowrap">{\Froxlor\I18N\Lang::getAll()['admin']['mysqlserverversion']}:</td>
							<td>$mysqlserverversion</td>
						</tr>
						<tr>
							<td>{\Froxlor\I18N\Lang::getAll()['admin']['webserverinterface']}:</td>
							<td>$webserverinterface</td>
						</tr>
						<tr>
							<td>{\Froxlor\I18N\Lang::getAll()['admin']['memory']}:</td>
							<td><pre>$memory</pre></td>
						</tr>
						<tr>
							<td>{\Froxlor\I18N\Lang::getAll()['admin']['sysload']}:</td>
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
					</tbody>
				</table>

				<table class="dboarditem">
					<thead>
						<tr>
							<th colspan="2">{\Froxlor\I18N\Lang::getAll()['admin']['froxlordetails']}</th>
						</tr>
					</thead>
					<tbody>
						{$outstanding_tasks}
						{$cron_last_runs}
						<tr>
							<td>{\Froxlor\I18N\Lang::getAll()['admin']['installedversion']}:</td>
							<td>{$version}{$branding} (DB: {$dbversion})</td>
						</tr>
						<tr>
							<td>{\Froxlor\I18N\Lang::getAll()['admin']['latestversion']}:</td>
							<if $isnewerversion != 0 >
								<td><a href="$lookfornewversion_link"><strong>$lookfornewversion_lable</strong></a></td>
							<else>
								<td><a href="$lookfornewversion_link">$lookfornewversion_lable</a></td>
							</if>
						</tr>
						<if $lookfornewversion_message != ''>
						<tr>
							<td colspan="2"><strong>$lookfornewversion_message</strong></td>
						</tr>
						</if>
						<if $lookfornewversion_addinfo != ''>
						<tr>
							<td colspan="2">$lookfornewversion_addinfo</td>
						</tr>
						</if>
					</tbody>
				</table>
			</div>
		</div>

	</article>
$footer
