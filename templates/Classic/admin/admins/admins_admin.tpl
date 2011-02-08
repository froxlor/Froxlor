<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left"><if $row['adminid'] != $userinfo['userid']><a href="$filename?s=$s&amp;page=$page&amp;action=su&amp;id={$row['adminid']}" target="_blank">{$row['loginname']}</a></if><if $row['adminid'] == $userinfo['userid']>{$row['loginname']}</if></td>
	<td class="field_name">{$row['name']}</td>
	<td class="field_name"><b><font color="green">{$row['customers_used']}</font></b>/<b><font color="#FD6204">{$row['customers']}</font></b><br /><b><font color="green">{$row['domains_used']}</font></b>/<b><font color="#FD6204">{$row['domains']}</font></b></td>
	<td class="field_name"><b><font color="green">{$row['diskspace_used']}</font></b>/<b><font color="#FD6204">{$row['diskspace']}</font></b> (MB)<br /><b><font color="green">{$row['traffic_used']}</font></b>/<b><font color="#FD6204">{$row['traffic']}</font></b> (GB)</td>
	<td class="field_name"><b><font color="green">{$row['mysqls_used']}</font></b>/<b><font color="#FD6204">{$row['mysqls']}</font></b><br /><b><font color="green">{$row['ftps_used']}</font></b>/<b><font color="#FD6204">{$row['ftps']}</font></b></td>
	<if ($settings['ticket']['enabled'] == 1 || $settings['autoresponder']['autoresponder_active'] == 1) >
		<if ($settings['ticket']['enabled'] == 1 && $settings['autoresponder']['autoresponder_active'] == 0) >
			<td class="field_name"><b><font color="green">{$row['tickets_used']}</font></b>/<b><font color="#FD6204">{$row['tickets']}</font></b></td>
		</if>
		<if ($settings['ticket']['enabled'] == 0 && $settings['autoresponder']['autoresponder_active'] == 1) >
			<td class="field_name"><b><font color="green">{$row['email_autoresponder_used']}</font></b>/<b><font color="#FD6204">{$row['email_autoresponder']}</font></b></td>
		</if>
		<if ($settings['ticket']['enabled'] == 1 && $settings['autoresponder']['autoresponder_active'] == 1) >
			<td class="field_name">
				<b><font color="green">{$row['tickets_used']}</font></b>/<b><font color="#FD6204">{$row['tickets']}</font></b>
				<br />
				<b><font color="green">{$row['email_autoresponder_used']}</font></b>/<b><font color="#FD6204">{$row['email_autoresponder']}</font></b>
			</td>
		</if>
	</if>
	<td class="field_name"><b><font color="green">{$row['emails_used']}</font></b>/<b><font color="#FD6204">{$row['emails']}</font></b><br /><b><font color="green">{$row['subdomains_used']}</font></b>/<b><font color="#FD6204">{$row['subdomains']}</font></b></td>
	<td class="field_name"><b><font color="green">{$row['email_accounts_used']}</font></b>/<b><font color="#FD6204">{$row['email_accounts']}</font></b><br /><b><font color="green">{$row['email_forwarders_used']}</font></b>/<b><font color="#FD6204">{$row['email_forwarders']}</font></b></td>
	<td class="field_name" style=" text-align: center; "><if $row['deactivated'] == '1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></td>
	<td class="field_name"><a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$row['adminid']}">{$lng['panel']['edit']}</a><br /><a href="$filename?s=$s&amp;page=$page&amp;action=delete&amp;id={$row['adminid']}">{$lng['panel']['delete']}</a></td>
</tr>
