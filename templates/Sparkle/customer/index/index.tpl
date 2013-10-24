$header
	<article>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/domains_big.png" alt="" />
			{$lng['panel']['dashboard']}
		</h2>
		
		<section class="dboardcanvas">
		<div class="canvasbox">
			<input type="hidden" id="subdomains" class="circular" used="{$userinfo['subdomains_used']}" available="{$userinfo['subdomains']}">
			<canvas id="subdomains-canvas" width="120" height="76"></canvas>
			{$lng['customer']['subdomains']}<br />
			<small>
				{$userinfo['subdomains_used']} {$lng['panel']['used']}<br />
				<if $userinfo['subdomains'] != '∞'>
				{$userinfo['subdomains']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		
		<div class="canvasbox">
			<input type="hidden" id="diskspace" class="circular" used="{$userinfo['diskspace_used']}" available="{$userinfo['diskspace']}">
			<canvas id="diskspace-canvas" width="120" height="76"></canvas>
			{$lng['customer']['diskspace']}<br />
			<small>
				{$userinfo['diskspace_used']} {$lng['panel']['used']}<br />
				<if $userinfo['diskspace'] != '∞'>
				{$userinfo['diskspace']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		
		<div class="canvasbox">
			<input type="hidden" id="traffic" class="circular" used="{$userinfo['traffic_used']}" available="{$userinfo['traffic']}">
			<canvas id="traffic-canvas" width="120" height="76"></canvas>
			{$lng['customer']['traffic']}<br />
			<small>
				{$userinfo['traffic_used']} {$lng['panel']['used']}<br />
				<if $userinfo['traffic'] != '∞'>
				{$userinfo['traffic']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		
		<div class="canvasbox">
			<input type="hidden" id="emails" class="circular" used="{$userinfo['emails_used']}" available="{$userinfo['emails']}">
			<canvas id="emails-canvas" width="120" height="76"></canvas>
			{$lng['customer']['emails']}<br />
			<small>
				{$userinfo['emails_used']} {$lng['panel']['used']}<br />
				<if $userinfo['emails'] != '∞'>
				{$userinfo['emails']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		
		<div class="canvasbox">
			<input type="hidden" id="email_accounts" class="circular" used="{$userinfo['email_accounts_used']}" available="{$userinfo['email_accounts']}">
			<canvas id="email_accounts-canvas" width="120" height="76"></canvas>
			{$lng['customer']['accounts']}<br />
			<small>
				{$userinfo['email_accounts_used']} {$lng['panel']['used']}<br />
				<if $userinfo['email_accounts'] != '∞'>
				{$userinfo['email_accounts']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		
		<div class="canvasbox">
			<input type="hidden" id="email_forwarders" class="circular" used="{$userinfo['email_forwarders_used']}" available="{$userinfo['email_forwarders']}">
			<canvas id="email_forwarders-canvas" width="120" height="76"></canvas>
			{$lng['customer']['forwarders']}<br />
			<small>
				{$userinfo['email_forwarders_used']} {$lng['panel']['used']}<br />
				<if $userinfo['email_forwarders'] != '∞'>
				{$userinfo['email_forwarders']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		
		<if $settings['system']['mail_quota_enabled'] == 1>
		<div class="canvasbox">
			<input type="hidden" id="email_quota" class="circular" used="{$userinfo['email_quota_used']}" available="{$userinfo['email_quota']}">
			<canvas id="email_forwarders-canvas" width="120" height="76"></canvas>
			{$lng['customer']['email_quota']}<br />
			<small>
				{$userinfo['email_quota_used']} {$lng['panel']['used']}<br />
				<if $userinfo['email_quota'] != '∞'>
				{$userinfo['email_quota']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		</if>
		
		<if $settings['autoresponder']['autoresponder_active'] == 1>
		<div class="canvasbox">
			<input type="hidden" id="email_autoresponder" class="circular" used="{$userinfo['email_autoresponder_used']}" available="{$userinfo['email_autoresponder']}">
			<canvas id="email_autoresponder-canvas" width="120" height="76"></canvas>
			{$lng['customer']['autoresponder']}<br />
			<small>
				{$userinfo['email_autoresponder_used']} {$lng['panel']['used']}<br />
				<if $userinfo['email_autoresponder'] != '∞'>
				{$userinfo['email_autoresponder']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		</if>

		<div class="canvasbox">
			<input type="hidden" id="mysqls" class="circular" used="{$userinfo['mysqls_used']}" available="{$userinfo['mysqls']}">
			<canvas id="mysqls-canvas" width="120" height="76"></canvas>
			{$lng['customer']['mysqls']}<br />
			<small>
				{$userinfo['mysqls_used']} {$lng['panel']['used']}<br />
				<if $userinfo['mysqls'] != '∞'>
				{$userinfo['mysqls']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		
		<div class="canvasbox">
			<input type="hidden" id="ftps" class="circular" used="{$userinfo['ftps_used']}" available="{$userinfo['ftps']}">
			<canvas id="ftps-canvas" width="120" height="76"></canvas>
			{$lng['customer']['ftps']}<br />
			<small>
				{$userinfo['ftps_used']} {$lng['panel']['used']}<br />
				<if $userinfo['ftps'] != '∞'>
				{$userinfo['ftps']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		
		<if (int)$settings['aps']['aps_active'] == 1>
		<div class="canvasbox">
			<input type="hidden" id="aps_packages" class="circular" used="{$userinfo['aps_packages_used']}" available="{$userinfo['aps_packages']}">
			<canvas id="aps_packages-canvas" width="120" height="76"></canvas>
			{$lng['aps']['numberofapspackages']}<br />
			<small>
				{$userinfo['aps_packages_used']} {$lng['panel']['used']}<br />
				<if $userinfo['aps_packages'] != '∞'>
				{$userinfo['aps_packages']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		</if>
		
		<if (int)$settings['ticket']['enabled'] == 1>
		<div class="canvasbox">
			<input type="hidden" id="tickets" class="circular" used="{$userinfo['tickets_used']}" available="{$userinfo['tickets']}">
			<canvas id="tickets-canvas" width="120" height="76"></canvas>
			{$lng['customer']['tickets']}<br />
			<small>
				{$userinfo['tickets_used']} {$lng['panel']['used']}<br />
				<if $userinfo['tickets'] != '∞'>
				{$userinfo['tickets']} {$lng['panel']['available']}
				</if>
			</small>
		</div>
		</if>
	</section>

    <section class="dboarditem bradius">
        <table>
       	<tr>
		<th colspan="2">{$lng['index']['accountdetails']}</th>
		</tr>
		<tr>
			<td>{$lng['login']['username']}</td>
			<td>{$userinfo['loginname']}</td>
		</tr>
		<tr>
			<td>{$lng['customer']['domains']}</td>
			<td>$domains</td>
		</tr>
		<tr>
		<th colspan="2">{$lng['index']['customerdetails']}</th>
		</tr>
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
        </table>
    </section>
    <section style="clear:both"></section>

	</article>
$footer

