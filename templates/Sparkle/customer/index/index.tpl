$header
	<article>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/domains_big.png" alt="" />
			{$lng['panel']['dashboard']}
		</h2>
		
		<div class="grid-g">
			<div class="grid-u-1-2" id="statsbox">
				<if $userinfo['subdomains'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="subdomains" class="circular" data-used="{$userinfo['subdomains_used']}" data-available="{$userinfo['subdomains']}">
					<canvas id="subdomains-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['subdomains']}<br />
					<small>
						{$userinfo['subdomains_used']} {$lng['panel']['used']}<br />
						<if $userinfo['subdomains'] != '∞'>
						{$userinfo['subdomains']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if $userinfo['diskspace'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="diskspace" class="circular" data-used="{$userinfo['diskspace_used']}" data-available="{$userinfo['diskspace']}">
					<canvas id="diskspace-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['diskspace']}<br />
					<small>
						{$userinfo['diskspace_used']} {$lng['panel']['used']}<br />
						<if $userinfo['diskspace'] != '∞'>
						{$userinfo['diskspace']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if $userinfo['traffic'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="traffic" class="circular" data-used="{$userinfo['traffic_used']}" data-available="{$userinfo['traffic']}">
					<canvas id="traffic-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['traffic']}<br />
					<small>
						{$userinfo['traffic_used']} {$lng['panel']['used']}<br />
						<if $userinfo['traffic'] != '∞'>
						{$userinfo['traffic']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if $userinfo['emails'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="emails" class="circular" data-used="{$userinfo['emails_used']}" data-available="{$userinfo['emails']}">
					<canvas id="emails-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['emails']}<br />
					<small>
						{$userinfo['emails_used']} {$lng['panel']['used']}<br />
						<if $userinfo['emails'] != '∞'>
						{$userinfo['emails']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if $userinfo['email_accounts'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="email_accounts" class="circular" data-used="{$userinfo['email_accounts_used']}" data-available="{$userinfo['email_accounts']}">
					<canvas id="email_accounts-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['accounts']}<br />
					<small>
						{$userinfo['email_accounts_used']} {$lng['panel']['used']}<br />
						<if $userinfo['email_accounts'] != '∞'>
						{$userinfo['email_accounts']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if $userinfo['email_forwarders'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="email_forwarders" class="circular" data-used="{$userinfo['email_forwarders_used']}" data-available="{$userinfo['email_forwarders']}">
					<canvas id="email_forwarders-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['forwarders']}<br />
					<small>
						{$userinfo['email_forwarders_used']} {$lng['panel']['used']}<br />
						<if $userinfo['email_forwarders'] != '∞'>
						{$userinfo['email_forwarders']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if Settings::Get('system.mail_quota_enabled') == 1 && $userinfo['email_quota'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="email_quota" class="circular" data-used="{$userinfo['email_quota_used']}" data-available="{$userinfo['email_quota']}">
					<canvas id="email_quota-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['email_quota']}<br />
					<small>
						{$userinfo['email_quota_used']} {$lng['panel']['used']}<br />
						<if $userinfo['email_quota'] != '∞'>
						{$userinfo['email_quota']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if $userinfo['mysqls'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="mysqls" class="circular" data-used="{$userinfo['mysqls_used']}" data-available="{$userinfo['mysqls']}">
					<canvas id="mysqls-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['mysqls']}<br />
					<small>
						{$userinfo['mysqls_used']} {$lng['panel']['used']}<br />
						<if $userinfo['mysqls'] != '∞'>
						{$userinfo['mysqls']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if $userinfo['ftps'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="ftps" class="circular" data-used="{$userinfo['ftps_used']}" data-available="{$userinfo['ftps']}">
					<canvas id="ftps-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['ftps']}<br />
					<small>
						{$userinfo['ftps_used']} {$lng['panel']['used']}<br />
						<if $userinfo['ftps'] != '∞'>
						{$userinfo['ftps']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>

				<if (int)Settings::Get('ticket.enabled') == 1 && $userinfo['tickets'] != '0'>
				<div class="canvasbox">
					<input type="hidden" id="tickets" class="circular" data-used="{$userinfo['tickets_used']}" data-available="{$userinfo['tickets']}">
					<canvas id="tickets-canvas" width="120" height="76"></canvas><br />
					{$lng['customer']['tickets']}<br />
					<small>
						{$userinfo['tickets_used']} {$lng['panel']['used']}<br />
						<if $userinfo['tickets'] != '∞'>
						{$userinfo['tickets']} {$lng['panel']['available']}
						</if>
					</small>
				</div>
				</if>
			</div>

			<div class="grid-u-1-2">
				<if Settings::Get('customer.show_news_feed') == '1'>
				<table class="dboarditem full" id="newsfeed" data-role="customer">
					<thead>
						<tr>
							<th>News</th>
						</tr>
					</thead>
					<tbody id="newsfeeditems">
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
							<td>{$userinfo['loginname']}</td>
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
						<if $userinfo['customernumber'] >
				        <tr>
				            <td>{$lng['customer']['customernumber']}:</td>
				            <td>{$userinfo['customernumber']}</td>
				        </tr>
				        </if>
				        <if $userinfo['company'] >
				        <tr>
				            <td>{$lng['customer']['company']}:</td>
				            <td>{$userinfo['company']}</td>
				        </tr>
				        </if>
				        <if $userinfo['name'] >
				        <tr>
				            <td>{$lng['customer']['name']}:</td>
				            <td>{$userinfo['firstname']} {$userinfo['name']}</td>
				        </tr>
				        </if>
				        <if $userinfo['street'] >
				        <tr>
				            <td>{$lng['customer']['street']}:</td>
				            <td>{$userinfo['street']}</td>
				        </tr>
				        </if>
				        <if $userinfo['city'] >
				        <tr>
				            <td>{$lng['customer']['zipcode']}/{$lng['customer']['city']}:</td>
				            <td>{$userinfo['zipcode']} {$userinfo['city']}</td>
				        </tr>
				        </if>
				        <if $userinfo['email'] >
				        <tr>
				            <td>{$lng['customer']['email']}:</td>
				            <td>{$userinfo['email']}</td>
				        </tr>
				        </if>
					</tbody>
			    </table>
			</div>
		</div>
	</article>
$footer

