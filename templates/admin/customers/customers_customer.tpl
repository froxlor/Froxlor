<tr>
	<td class="field_name_border_left"><a href="$filename?s=$s&amp;page=$page&amp;action=su&amp;id={$row['customerid']}" target="_blank">{$row['loginname']}</a></td>
	<td class="field_name">{$row['adminname']}</td>
	<td class="field_name"><if $row['name'] != '' && $row['firstname'] != ''>{$row['name']}<br />{$row['firstname']}</if><if ($row['name'] == '' || $row['firstname'] == '') && $row['company'] != ''>{$row['company']}</if></td>
	<td class="field_name"><if $row['domains'] != 0><a href="admin_domains.php?s=$s&amp;page=domains&amp;searchfield=c.loginname&amp;searchtext={$row['loginname']}">{$row['domains']}</a><else>{$row['domains']}</if></td>
	<if $settings['ticket']['enabled'] == 1 ><td class="field_name"><span<if $row['tickets'] < $row['tickets_used'] && $row['tickets'] != 'UL'> style="color:red"</if><if $row['tickets_used'] < $row['tickets'] || $row['tickets'] == 'UL'> style="color:green"</if>><b>{$row['tickets_used']}</b>/<b><font color="#FD6204">{$row['tickets']}</font></b></span></td></if>
	<td class="field_name">
	<span<if $row['diskspace'] < $row['diskspace_used'] && $row['diskspace'] != 'UL'> style="color:red"</if><if $row['diskspace_used'] < $row['diskspace'] || $row['diskspace'] == 'UL'> style="color:green"</if>><b>{$row['diskspace_used']}</b>/<b><font color="#FD6204">{$row['diskspace']}</font></b></span> (MB)
	<br />
	<span<if $row['traffic'] < $row['traffic_used'] && $row['traffic'] != 'UL'> style="color:red"</if><if $row['traffic_used'] < $row['traffic'] || $row['traffic'] == 'UL'> style="color:green"</if>><b>{$row['traffic_used']}</b>/<b><font color="#FD6204">{$row['traffic']}</font></b></span> (GB)
	</td>
	<td class="field_name"><b><font color="green">{$row['mysqls_used']}</font></b>/<b><font color="#FD6204">{$row['mysqls']}</font></b><br /><b><font color="green">{$row['ftps_used']}</font></b>/<b><font color="#FD6204">{$row['ftps']}</font></b></td>
	<td class="field_name"><b><font color="green">{$row['emails_used']}</font></b>/<b><font color="#FD6204">{$row['emails']}</font></b><br /><b><font color="green">{$row['subdomains_used']}</font></b>/<b><font color="#FD6204">{$row['subdomains']}</font></b></td>
	<td class="field_name"><b><font color="green">{$row['email_accounts_used']}</font></b>/<b><font color="#FD6204">{$row['email_accounts']}</font></b><br /><b><font color="green">{$row['email_forwarders_used']}</font></b>/<b><font color="#FD6204">{$row['email_forwarders']}</font></b></td>
	<td class="field_name" style=" text-align: center; "><if $row['deactivated'] == '1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></td>
	<td class="field_name"><a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$row['customerid']}">{$lng['panel']['edit']}</a><br /><a href="$filename?s=$s&amp;page=$page&amp;action=delete&amp;id={$row['customerid']}">{$lng['panel']['delete']}</a></td>
</tr>
