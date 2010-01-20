$header
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable_60">
		<tr>
			<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['emails']['emails_edit']}</b></td>
		</tr>
		<tr>
			<td class="field_display_border_left">{$lng['emails']['emailaddress']}:</td>
			<td class="field_name" nowrap="nowrap">{$result['email_full']}</td>
		</tr>
		<tr>
			<td class="field_display_border_left">{$lng['emails']['account']}:</td>
			<td class="field_name" nowrap="nowrap">
			<if $result['popaccountid'] != 0>
			{$lng['panel']['yes']} [<a href="$filename?page=accounts&amp;action=changepw&amp;id={$result['id']}&amp;s=$s">{$lng['menue']['main']['changepassword']}</a>] [<a href="$filename?page=accounts&amp;action=delete&amp;id={$result['id']}&amp;s=$s">{$lng['emails']['account_delete']}</a>]
			</if>
			<if $result['popaccountid'] == 0>
			{$lng['panel']['no']} [<a href="$filename?page=accounts&amp;action=add&amp;id={$result['id']}&amp;s=$s">{$lng['emails']['account_add']}</a>]
			</if>
			</td>
		</tr>
		<if $result['popaccountid'] != 0 && $settings['system']['mail_quota_enabled']>
		<tr>
			<td class="field_display_border_left">{$lng['customer']['email_quota']}:</td>
			<td class="field_name" nowrap="nowrap">{$result['quota']} {$lng['panel']['megabyte']} [<a href="$filename?page=accounts&amp;action=changequota&amp;id={$result['id']}&amp;s=$s">{$lng['emails']['quota_edit']}</a>]</td>
		</tr>
		</if>
		<tr>
			<td class="field_display_border_left">{$lng['emails']['catchall']}:</td>
			<td class="field_name" nowrap="nowrap">
			<if $result['iscatchall'] != 0>
			{$lng['panel']['yes']}
			</if>
			<if $result['iscatchall'] == 0>
			{$lng['panel']['no']}
			</if>
			[<a href="$filename?page=$page&amp;action=togglecatchall&amp;id={$result['id']}&amp;s=$s">{$lng['panel']['toggle']}</a>]
			</td>
		</tr>
		<tr>
			<td class="field_display_border_left">{$lng['emails']['forwarders']} ({$forwarders_count}):</td>
			<td class="field_name">$forwarders<a href="$filename?page=forwarders&amp;action=add&amp;id={$result['id']}&amp;s=$s">{$lng['emails']['forwarder_add']}</a></td>
		</tr>
	</table>
	<br />
	<br />
$footer