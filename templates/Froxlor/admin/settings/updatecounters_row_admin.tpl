		<tr>
			<td style="width: 35%;">
				<b><if $admin['adminid'] != $userinfo['userid']><a href="{$linker->getLink(array('section' => 'admins', 'page' => 'admins', 'action' => 'su', 'id' => $admin['adminid']))}" target="_blank">{$admin['loginname']}</a></if><if $admin['adminid'] == $userinfo['userid']>{$admin['loginname']}</if>:</b>
			</td>
			<td>
				<section class="fullform bradiusodd">
					<table class="formtable" border="0" style="text-align: left; width: 100%">
						<tr>
							<td>{$lng['admin']['customers']}:</td>
							<td><span <if $admin['customers_used'] == $admin['customers_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['customers_used']} -&gt; {$admin['customers_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['domains']}:</td>
							<td><span <if $admin['domains_used'] == $admin['domains_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['domains_used']} -&gt; {$admin['domains_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['subdomains']}:</td>
							<td><span <if $admin['subdomains_used'] == $admin['subdomains_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['subdomains_used']} -&gt; {$admin['subdomains_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['diskspace']}:</td>
							<td><span <if $admin['diskspace_used'] == $admin['diskspace_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['diskspace_used']} -&gt; {$admin['diskspace_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['traffic']}:</td>
							<td><span <if $admin['traffic_used'] == $admin['traffic_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['traffic_used']} -&gt; {$admin['traffic_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['mysqls']}:</td>
							<td><span <if $admin['mysqls_used'] == $admin['mysqls_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['mysqls_used']} -&gt; {$admin['mysqls_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['emails']}:</td>
							<td><span <if $admin['emails_used'] == $admin['emails_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['emails_used']} -&gt; {$admin['emails_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['accounts']}:</td>
							<td><span <if $admin['email_accounts_used'] == $admin['email_accounts_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['email_accounts_used']} -&gt; {$admin['email_accounts_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['forwarders']}:</td>
							<td><span <if $admin['email_forwarders_used'] == $admin['email_forwarders_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['email_forwarders_used']} -&gt; {$admin['email_forwarders_used_new']}</b></span></td>
						</tr>
						<if $settings['system']['mail_quota_enabled'] == 1>
						<tr>
							<td>{$lng['customer']['email_quota']}:</td>
							<td><span <if $admin['email_quota_used'] == $admin['email_quota_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['email_quota_used']} -&gt; {$admin['email_quota_used_new']}</b></span></td>
						</tr>
						</if>
						<if $settings['autoresponder']['autoresponder_active'] == 1>
						<tr>
							<td>{$lng['customer']['autoresponder']}:</td>
							<td><span <if $admin['email_autoresponder_used'] == $admin['email_autoresponder_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['email_autoresponder_used']} -&gt; {$admin['email_autoresponder_used_new']}</b></span></td>
						</tr>
						</if>
						<tr>
							<td>{$lng['customer']['ftps']}:</td>
							<td><span <if $admin['ftps_used'] == $admin['ftps_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['ftps_used']} -&gt; {$admin['ftps_used_new']}</b></span></td>
						</tr>
						<if $settings['ticket']['enabled'] == '1'>
						<tr>
							<td>{$lng['customer']['tickets']}:</td>
							<td><span <if $admin['tickets_used'] == $admin['tickets_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['tickets_used']} -&gt; {$admin['tickets_used_new']}</b></span></td>
						</tr>
						</if>
						<if $settings['aps']['aps_active'] == '1'>
						<tr>
							<td>{$lng['customer']['aps']}:</td>
							<td><span <if $admin['aps_packages_used'] == $admin['aps_packages_used_new']>style="color:green"<else>style="color:red"</if>><b>{$admin['aps_packages_used']} -&gt; {$admin['aps_packages_used_new']}</b></span></td>
						</tr>
						</if>
					</table>
					<br /><br />
				</section>
			</td>
		</tr>
