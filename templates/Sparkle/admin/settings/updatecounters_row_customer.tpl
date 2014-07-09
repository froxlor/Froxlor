		<tr class="top">
			<td>
				<b><if $customer['name'] != '' && $customer['firstname'] != ''>{$customer['name']}, {$customer['firstname']}</if><if $customer['name'] != '' && $customer['firstname'] != '' && $customer['company'] != ''> | </if><if $customer['company'] != ''>{$customer['company']}</if> (<a href="{$linker->getLink(array('section' => 'customers', 'page' => 'customers', 'action' => 'su', 'id' => $customer['customerid']))}" target="_blank">{$customer['loginname']}</a>)</b>
			</td>
			<td>
				{$lng['customer']['subdomains']}: <span <if $customer['subdomains_used'] == $customer['subdomains_used_new']>class="green"<else>class="red"</if>><b>{$customer['subdomains_used']} -&gt; {$customer['subdomains_used_new']}</b></span><br />
				{$lng['customer']['mysqls']}: <span <if $customer['mysqls_used'] == $customer['mysqls_used_new']>class="green"<else>class="red"</if>><b>{$customer['mysqls_used']} -&gt; {$customer['mysqls_used_new']}</b></span><br />
				{$lng['customer']['emails']}: <span <if $customer['emails_used'] == $customer['emails_used_new']>class="green"<else>class="red"</if>><b>{$customer['emails_used']} -&gt; {$customer['emails_used_new']}</b></span><br />
				{$lng['customer']['accounts']}: <span <if $customer['email_accounts_used'] == $customer['email_accounts_used_new']>class="green"<else>class="red"</if>><b>{$customer['email_accounts_used']} -&gt; {$customer['email_accounts_used_new']}</b></span><br />
			</td>
			<td>
				{$lng['customer']['forwarders']}: <span <if $customer['email_forwarders_used'] == $customer['email_forwarders_used_new']>class="green"<else>class="red"</if>><b>{$customer['email_forwarders_used']} -&gt; {$customer['email_forwarders_used_new']}</b></span><br />
				<if Settings::Get('system.mail_quota_enabled') == 1>
				{$lng['customer']['email_quota']}: <span <if $customer['email_quota_used'] == $customer['email_quota_used_new']>class="green"<else>class="red"</if>><b>{$customer['email_quota_used']} -&gt; {$customer['email_quota_used_new']}</b></span><br />
				</if>
				{$lng['customer']['ftps']}: <span <if $customer['ftps_used'] == $customer['ftps_used_new']>class="green"<else>class="red"</if>><b>{$customer['ftps_used']} -&gt; {$customer['ftps_used_new']}</b></span><br />
				<if Settings::Get('ticket.enabled') == '1'>
				{$lng['customer']['tickets']}: <span <if $customer['tickets_used'] == $customer['tickets_used_new']>class="green"<else>class="red"</if>><b>{$customer['tickets_used']} -&gt; {$customer['tickets_used_new']}</b></span><br />
				</if>
			</td>
		</tr>
