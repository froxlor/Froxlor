$header
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['index']['customerdetails']}</b></td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['name']}:</td>
			<td class="field_display">{$userinfo['firstname']} {$userinfo['name']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['company']}:</td>
			<td class="field_display">{$userinfo['company']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['street']}:</td>
			<td class="field_display">{$userinfo['street']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['zipcode']}/{$lng['customer']['city']}:</td>
			<td class="field_display">{$userinfo['zipcode']} {$userinfo['city']}</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['email']}:</td>
			<td class="field_display">{$userinfo['email']}</td>
		</tr>
		<tr>
			<td class="field_name_nobordersmall">{$lng['customer']['customernumber']}:</td>
			<td class="field_display_nobordersmall">{$userinfo['customernumber']}</td>
		</tr>
		<tr>
			<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['index']['accountdetails']}</b></td>
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
			<td class="field_name_border_left">{$lng['customer']['subdomains']}:</td>
			<td class="field_display">{$userinfo['subdomains_used']} ({$userinfo['subdomains']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['diskspace']}:</td>
			<td class="field_display">{$userinfo['diskspace_used']} ({$userinfo['diskspace']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['traffic']} ($month):</td>
			<td class="field_display">{$userinfo['traffic_used']} ({$userinfo['traffic']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['emails']}:</td>
			<td class="field_display">{$userinfo['emails_used']} ({$userinfo['emails']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['accounts']}:</td>
			<td class="field_display">{$userinfo['email_accounts_used']} ({$userinfo['email_accounts']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['forwarders']}:</td>
			<td class="field_display">{$userinfo['email_forwarders_used']} ({$userinfo['email_forwarders']})</td>
		</tr>
		<if $settings['system']['mail_quota_enabled'] == 1>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['email_quota']} ({$lng['panel']['megabyte']}):</td>
			<td class="field_display">{$userinfo['email_quota_used']} ({$userinfo['email_quota']})</td>
		</tr>
		</if>
		</tr>
		<if $settings['autoresponder']['autoresponder_active'] == 1>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['autoresponder']}:</td>
			<td class="field_display">{$userinfo['email_autoresponder_used']} ({$userinfo['email_autoresponder']})</td>
		</tr>
		</if>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['mysqls']}:</td>
			<td class="field_display">{$userinfo['mysqls_used']} ({$userinfo['mysqls']})</td>
		</tr>
		<tr>
			<td class="field_name_border_left">{$lng['customer']['ftps']}:</td>
			<td class="field_display">{$userinfo['ftps_used']} ({$userinfo['ftps']})</td>
		</tr>
		<if (int)$settings['aps']['aps_active'] == 1>
		<tr>
			<td class="field_name_border_left">{$lng['aps']['numberofapspackages']}:</td>
			<td class="field_display">{$userinfo['aps_packages_used']} ({$userinfo['aps_packages']})</td>
		</tr>
		</if>
		<if $settings['ticket']['enabled'] == 1 >
		<tr>
			<td class="field_name_border_left">{$lng['customer']['tickets']}:</td>
			<td class="field_display">{$userinfo['tickets_used']} ({$userinfo['tickets']})</td>
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