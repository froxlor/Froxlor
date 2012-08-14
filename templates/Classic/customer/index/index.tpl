$header
<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable" xmlns="http://www.w3.org/1999/html"
       xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
		<tr>
			<td class="maintitle" colspan="2"><b><img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['index']['customerdetails']}</b></td>
		</tr>
        <if $userinfo['customernumber'] >
        <tr>
            <td class="field_name_nobordersmall">{$lng['customer']['customernumber']}:</td>
            <td class="field_display_nobordersmall">{$userinfo['customernumber']}</td>
        </tr>
        </if>
        <if $userinfo['company'] >
        <tr>
            <td class="field_name_border_left">{$lng['customer']['company']}:</td>
            <td class="field_display">{$userinfo['company']}</td>
        </tr>
        </if>
        <if $userinfo['name'] >
        <tr>
			<td class="field_name_border_left">{$lng['customer']['name']}:</td>
			<td class="field_display">{$userinfo['firstname']} {$userinfo['name']}</td>
		</tr>
        </if>
        <if $userinfo['street'] >
		<tr>
			<td class="field_name_border_left">{$lng['customer']['street']}:</td>
			<td class="field_display">{$userinfo['street']}</td>
		</tr>
		</if>
        <if $userinfo['city'] >
        <tr>
			<td class="field_name_border_left">{$lng['customer']['zipcode']}/{$lng['customer']['city']}:</td>
			<td class="field_display">{$userinfo['zipcode']} {$userinfo['city']}</td>
		</tr>
        </if>
        <if $userinfo['email'] >
        <tr>
			<td class="field_name_border_left">{$lng['customer']['email']}:</td>
			<td class="field_display">{$userinfo['email']}</td>
		</tr>
        </if>
        <tr>
			<td class="maintitle" colspan="2"><b><img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['index']['accountdetails']}</b></td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['login']['username']}:</td>
			<td class="field_display">{$userinfo['loginname']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['domains']}:</td>
			<td class="field_display">$domains</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['subdomains']} ({$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['subdomains_used']}/{$userinfo['subdomains']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['diskspace']} ({$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['diskspace_used']}/{$userinfo['diskspace']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['traffic']} ($month, {$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['traffic_used']}/{$userinfo['traffic']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['emails']} ({$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['emails_used']}/{$userinfo['emails']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['accounts']} ({$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['email_accounts_used']}/{$userinfo['email_accounts']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['forwarders']} ({$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['email_forwarders_used']}/{$userinfo['email_forwarders']}</td>
		</tr>
		<if $settings['system']['mail_quota_enabled'] == 1>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['email_quota']} ({$lng['panel']['megabyte']}, {$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['email_quota_used']}/{$userinfo['email_quota']}</td>
		</tr>
		</if>
		</tr>
		<if $settings['autoresponder']['autoresponder_active'] == 1>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['autoresponder']} ({$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['email_autoresponder_used']}/{$userinfo['email_autoresponder']}</td>
		</tr>
		</if>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['mysqls']} ({$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['mysqls_used']}/{$userinfo['mysqls']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['ftps']} ({$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['ftps_used']}/{$userinfo['ftps']}</td>
		</tr>
		<if (int)$settings['aps']['aps_active'] == 1>
		<tr>
			<td class="field_name_border_left">{$lng['aps']['numberofapspackages']} ({$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['aps_packages_used']}/{$userinfo['aps_packages']}</td>
		</tr>
		</if>
		<if $settings['ticket']['enabled'] == 1 >
		<tr>
			<td class="field_name_border_left">{$lng['customer']['tickets']} ({$lng['customer']['usedmax']}):</td>
			<td class="field_display">{$userinfo['tickets_used']}/{$userinfo['tickets']}</td>
		</tr>
		</if>
		<if 0 < $awaitingtickets && $settings['ticket']['enabled'] == 1 >
		<tr>
			<td class="field_name_border_left" colspan="2"><b>{$awaitingtickets_text}</b></td>
		</tr>
		</if>
	</table>
	<br />
	<br />
$footer
