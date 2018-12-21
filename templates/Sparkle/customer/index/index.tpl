$header
	<article>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/domains_big.png" alt="" />
			{$lng['panel']['dashboard']}
		</h2>
		
		<div class="grid-g">
			<div class="grid-u-1-2" id="statsbox">
				<if \Froxlor\User::getAll()['subdomains'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="subdomains" class="circular" data-used="{\Froxlor\User::getAll()['subdomains_used']}" data-available="{\Froxlor\User::getAll()['subdomains']}">
					<canvas id="subdomains-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['subdomains']}<br />
					<small>
						{\Froxlor\User::getAll()['subdomains_used']} {$lng['panel']['used']}<br />
						<if \Froxlor\User::getAll()['subdomains'] != '∞'>
						{\Froxlor\User::getAll()['subdomains']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if \Froxlor\User::getAll()['diskspace'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="diskspace" class="circular" data-used="{\Froxlor\User::getAll()['diskspace_used']}" data-available="{\Froxlor\User::getAll()['diskspace']}">
					<canvas id="diskspace-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['diskspace']}<br />
					<small>
						{\Froxlor\User::getAll()['diskspace_used']} {$lng['panel']['used']}<br />
						<if \Froxlor\User::getAll()['diskspace'] != '∞'>
						{\Froxlor\User::getAll()['diskspace']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if \Froxlor\User::getAll()['traffic'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="traffic" class="circular" data-used="{\Froxlor\User::getAll()['traffic_used']}" data-available="{\Froxlor\User::getAll()['traffic']}">
					<canvas id="traffic-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['traffic']}<br />
					<small>
						{\Froxlor\User::getAll()['traffic_used']} {$lng['panel']['used']}<br />
						<if \Froxlor\User::getAll()['traffic'] != '∞'>
						{\Froxlor\User::getAll()['traffic']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if \Froxlor\User::getAll()['emails'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="emails" class="circular" data-used="{\Froxlor\User::getAll()['emails_used']}" data-available="{\Froxlor\User::getAll()['emails']}">
					<canvas id="emails-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['emails']}<br />
					<small>
						{\Froxlor\User::getAll()['emails_used']} {$lng['panel']['used']}<br />
						<if \Froxlor\User::getAll()['emails'] != '∞'>
						{\Froxlor\User::getAll()['emails']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if \Froxlor\User::getAll()['email_accounts'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="email_accounts" class="circular" data-used="{\Froxlor\User::getAll()['email_accounts_used']}" data-available="{\Froxlor\User::getAll()['email_accounts']}">
					<canvas id="email_accounts-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['accounts']}<br />
					<small>
						{\Froxlor\User::getAll()['email_accounts_used']} {$lng['panel']['used']}<br />
						<if \Froxlor\User::getAll()['email_accounts'] != '∞'>
						{\Froxlor\User::getAll()['email_accounts']} {$lng['panel']['available']}<br />
						</if>
						{\Froxlor\User::getAll()['mailspace_used']} {$lng['customer']['mib']}
					</small>
				</div>
				</if>

				<if \Froxlor\User::getAll()['email_forwarders'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="email_forwarders" class="circular" data-used="{\Froxlor\User::getAll()['email_forwarders_used']}" data-available="{\Froxlor\User::getAll()['email_forwarders']}">
					<canvas id="email_forwarders-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['forwarders']}<br />
					<small>
						{\Froxlor\User::getAll()['email_forwarders_used']} {$lng['panel']['used']}<br />
						<if \Froxlor\User::getAll()['email_forwarders'] != '∞'>
						{\Froxlor\User::getAll()['email_forwarders']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if \Froxlor\Settings::Get('system.mail_quota_enabled') == 1 && \Froxlor\User::getAll()['email_quota'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="email_quota" class="circular" data-used="{\Froxlor\User::getAll()['email_quota_used']}" data-available="{\Froxlor\User::getAll()['email_quota']}">
					<canvas id="email_quota-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['email_quota']}<br />
					<small>
						{\Froxlor\User::getAll()['email_quota_used']} {$lng['panel']['used']}<br />
						<if \Froxlor\User::getAll()['email_quota'] != '∞'>
						{\Froxlor\User::getAll()['email_quota']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if \Froxlor\User::getAll()['mysqls'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="mysqls" class="circular" data-used="{\Froxlor\User::getAll()['mysqls_used']}" data-available="{\Froxlor\User::getAll()['mysqls']}">
					<canvas id="mysqls-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['mysqls']}<br />
					<small>
						{\Froxlor\User::getAll()['mysqls_used']} {$lng['panel']['used']}<br />
						<if \Froxlor\User::getAll()['mysqls'] != '∞'>
						{\Froxlor\User::getAll()['mysqls']} {$lng['panel']['available']}<br />
						</if>
						{\Froxlor\User::getAll()['dbspace_used']} {$lng['customer']['mib']}
					</small>
				</div>
				</if>

				<if \Froxlor\User::getAll()['ftps'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="ftps" class="circular" data-used="{\Froxlor\User::getAll()['ftps_used']}" data-available="{\Froxlor\User::getAll()['ftps']}">
					<canvas id="ftps-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['ftps']}<br />
					<small>
						{\Froxlor\User::getAll()['ftps_used']} {$lng['panel']['used']}<br />
						<if \Froxlor\User::getAll()['ftps'] != '∞'>
						{\Froxlor\User::getAll()['ftps']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>
			</div>

			<div class="grid-u-1-2">
				<if \Froxlor\Settings::Get('customer.show_news_feed') == '1'>
				<table class="dboarditem full" id="newsfeed" data-role="customer">
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
				</if>

				<table class="dboarditem">
					<thead>
						<tr>
							<th colspan="2">{$lng['index']['accountdetails']}</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{$lng['login']['username']}:</td>
							<td>{\Froxlor\User::getAll()['loginname']}</td>
						</tr>
						<tr>
							<td>{$lng['customer']['domains']}:</td>
							<td>$domains</td>
						</tr>
						<if $stdsubdomain != ''>
							<tr>
								<td>{$lng['admin']['stdsubdomain']}:</td>
								<td>$stdsubdomain</td>
							</tr>
						</if>
						<tr>
							<td>{$lng['customer']['services']}:</td>
							<td>$services_enabled</td>
						</tr>
					</tbody>
				</table>

				<table class="dboarditem">
					<thead>
						<tr>
							<th colspan="2">{$lng['index']['customerdetails']}</th>
						</tr>
					</thead>
					<tbody>
						<if \Froxlor\User::getAll()['customernumber'] >
				        <tr>
				            <td>{$lng['customer']['customernumber']}:</td>
				            <td>{\Froxlor\User::getAll()['customernumber']}</td>
				        </tr>
				        </if>
				        <if \Froxlor\User::getAll()['company'] >
				        <tr>
				            <td>{$lng['customer']['company']}:</td>
				            <td>{\Froxlor\User::getAll()['company']}</td>
				        </tr>
				        </if>
				        <if \Froxlor\User::getAll()['name'] >
				        <tr>
				            <td>{$lng['customer']['name']}:</td>
				            <td>{\Froxlor\User::getAll()['firstname']} {\Froxlor\User::getAll()['name']}</td>
				        </tr>
				        </if>
				        <if \Froxlor\User::getAll()['street'] >
				        <tr>
				            <td>{$lng['customer']['street']}:</td>
				            <td>{\Froxlor\User::getAll()['street']}</td>
				        </tr>
				        </if>
				        <if \Froxlor\User::getAll()['city'] >
				        <tr>
				            <td>{$lng['customer']['zipcode']}/{$lng['customer']['city']}:</td>
				            <td>{\Froxlor\User::getAll()['zipcode']} {\Froxlor\User::getAll()['city']}</td>
				        </tr>
				        </if>
				        <if \Froxlor\User::getAll()['email'] >
				        <tr>
				            <td>{$lng['customer']['email']}:</td>
				            <td>{\Froxlor\User::getAll()['email']}</td>
				        </tr>
				        </if>
				        <if \Froxlor\User::getAll()['custom_notes'] != '' && \Froxlor\User::getAll()['custom_notes_show'] == '1'>
				        <tr>
				            <td colspan="2">{\Froxlor\User::getAll()['custom_notes']}</td>
				        </tr>
				        </if>
					</tbody>
			    </table>
			</div>
		</div>
	</article>
$footer
