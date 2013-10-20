$header
	<article>

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
			<td>{$lng['customer']['subdomains']}<br /><small>{$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['subdomains_used']}/{$userinfo['subdomains']}</td>
		</tr>
		<tr>
			<td>{$lng['customer']['diskspace']}<br /><small>{$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['diskspace_used']}/{$userinfo['diskspace']}</td>
		</tr>
		<tr>
			<td>{$lng['customer']['traffic']}<br /><small>$month, {$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['traffic_used']}/{$userinfo['traffic']}</td>
		</tr>
		<tr>
			<td>{$lng['customer']['emails']}<br /><small>{$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['emails_used']}/{$userinfo['emails']}</td>
		</tr>
		<tr>
			<td>{$lng['customer']['accounts']}<br /><small>{$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['email_accounts_used']}/{$userinfo['email_accounts']}</td>
		</tr>
		<tr>
			<td>{$lng['customer']['forwarders']}<br /><small>{$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['email_forwarders_used']}/{$userinfo['email_forwarders']}</td>
		</tr>
		<if $settings['system']['mail_quota_enabled'] == 1>
		<tr>
			<td>{$lng['customer']['email_quota']}<br /><small>{{$lng['panel']['megabyte']}, {$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['email_quota_used']}/{$userinfo['email_quota']}</td>
		</tr>
		</if>
		</tr>
		<if $settings['autoresponder']['autoresponder_active'] == 1>
		<tr>
			<td>{$lng['customer']['autoresponder']} <br /><small>{$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['email_autoresponder_used']}/{$userinfo['email_autoresponder']}</td>
		</tr>
		</if>
		<tr>
			<td>{$lng['customer']['mysqls']}<br /><small>{$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['mysqls_used']}/{$userinfo['mysqls']}</td>
		</tr>
		<tr>
			<td>{$lng['customer']['ftps']}<br /><small>{$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['ftps_used']}/{$userinfo['ftps']}</td>
		</tr>
		<if (int)$settings['aps']['aps_active'] == 1>
		<tr>
			<td>{$lng['aps']['numberofapspackages']}<br /><small>{$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['aps_packages_used']}/{$userinfo['aps_packages']}</td>
		</tr>
		</if>
		<if $settings['ticket']['enabled'] == 1 >
		<tr>
			<td>{$lng['customer']['tickets']}<br /><small>{$lng['customer']['usedmax']}</small></td>
			<td>{$userinfo['tickets_used']}/{$userinfo['tickets']}</td>
		</tr>
		</if>
		</table>
	</section>

    <section class="dboarditem bradius">
        <table>
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

