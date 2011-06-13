		<tr>
			<td style="width: 35%;">
				<b><if $customer['name'] != '' && $customer['firstname'] != ''>{$customer['name']}, {$customer['firstname']}</if><if $customer['name'] != '' && $customer['firstname'] != '' && $customer['company'] != ''> | </if><if $customer['company'] != ''>{$customer['company']}</if> (<a href="{$linker->getLink(array('section' => 'customers', 'page' => 'customers', 'action' => 'su', 'id' => $customer['customerid']))}" target="_blank">{$customer['loginname']}</a>):</b>
			</td>
			<td>
				<section class="fullform bradiusodd">
					<table class="formtable" border="0" style="text-align: left; width: 100%">
						<tr>
							<td>{$lng['customer']['subdomains']}:</td>
							<td><span <if $customer['subdomains_used'] == $customer['subdomains_used_new']>style="color:green"<else>style="color:red"</if>><b>{$customer['subdomains_used']} -&gt; {$customer['subdomains_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['mysqls']}:</td>
							<td><span <if $customer['mysqls_used'] == $customer['mysqls_used_new']>style="color:green"<else>style="color:red"</if>><b>{$customer['mysqls_used']} -&gt; {$customer['mysqls_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['emails']}:</td>
							<td><span <if $customer['emails_used'] == $customer['emails_used_new']>style="color:green"<else>style="color:red"</if>><b>{$customer['emails_used']} -&gt; {$customer['emails_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['accounts']}:</td>
							<td><span <if $customer['email_accounts_used'] == $customer['email_accounts_used_new']>style="color:green"<else>style="color:red"</if>><b>{$customer['email_accounts_used']} -&gt; {$customer['email_accounts_used_new']}</b></span></td>
						</tr>
						<tr>
							<td>{$lng['customer']['forwarders']}:</td>
							<td><span <if $customer['email_forwarders_used'] == $customer['email_forwarders_used_new']>style="color:green"<else>style="color:red"</if>><b>{$customer['email_forwarders_used']} -&gt; {$customer['email_forwarders_used_new']}</b></span></td>
						</tr>
						<if $settings['system']['mail_quota_enabled'] == 1>
						<tr>
							<td>{$lng['customer']['email_quota']}:</td>
							<td><span <if $customer['email_quota_used'] == $customer['email_quota_used_new']>style="color:green"<else>style="color:red"</if>><b>{$customer['email_quota_used']} -&gt; {$customer['email_quota_used_new']}</b></span></td>
						</tr>
						</if>
						<if $settings['autoresponder']['autoresponder_active'] == 1>
						<tr>
							<td>{$lng['customer']['autoresponder']}:</td>
							<td><span <if $customer['email_autoresponder_used'] == $customer['email_autoresponder_used_new']>style="color:green"<else>style="color:red"</if>><b>{$customer['email_autoresponder_used']} -&gt; {$customer['email_autoresponder_used_new']}</b></span></td>
						</tr>
						</if>
						<tr>
							<td>{$lng['customer']['ftps']}:</td>
							<td><span <if $customer['ftps_used'] == $customer['ftps_used_new']>style="color:green"<else>style="color:red"</if>><b>{$customer['ftps_used']} -&gt; {$customer['ftps_used_new']}</b></span></td>
						</tr>
						<if $settings['ticket']['enabled'] == '1'>
						<tr>
							<td>{$lng['customer']['tickets']}:</td>
							<td><span <if $customer['tickets_used'] == $customer['tickets_used_new']>style="color:green"<else>style="color:red"</if>><b>{$customer['tickets_used']} -&gt; {$customer['tickets_used_new']}</b></span></td>
						</tr>
						</if>
						<if $settings['aps']['aps_active'] == '1'>
						<tr>
							<td>{$lng['customer']['aps']}:</td>
							<td><span <if $customer['aps_packages_used'] == $customer['aps_packages_used_new']>style="color:green"<else>style="color:red"</if>><b>{$customer['aps_packages_used']} -&gt; {$customer['aps_packages_used_new']}</b></span></td>
						</tr>
						</if>
					</table>
					<br /><br />
				</section>
			</td>
		</tr>
