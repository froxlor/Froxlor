$header
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td  class="maintitle_search_left"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['menue']['email']['emails']}</b></td>
				<td class="maintitle_search_right" colspan="6">{$searchcode}</td>
			</tr>
			<if ($userinfo['emails_used'] < $userinfo['emails'] || $userinfo['emails'] == '-1') && 15 < $emails_count && $emaildomains_count !=0 >
			<tr>
				<td class="field_display_border_left" colspan="7"><a href="$filename?page={$page}&amp;action=add&amp;s=$s">{$lng['emails']['emails_add']}</a></td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left">{$lng['emails']['emailaddress']}&nbsp;&nbsp;{$arrowcode['m.email_full']}</td>
				<td class="field_display">{$lng['emails']['forwarders']}&nbsp;&nbsp;{$arrowcode['m.destination']}</td>
				<td class="field_display">{$lng['emails']['account']}</td>
				<td class="field_display">{$lng['emails']['catchall']}</td>
				<if $settings['system']['mail_quota_enabled'] == '1'><td class="field_display">{$lng['emails']['quota']}</td></if>
				<td class="field_display_search" colspan="2">{$sortcode}</td>
			</tr>
			$accounts
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="7" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<if ($userinfo['emails_used'] < $userinfo['emails'] || $userinfo['emails'] == '-1') && $emaildomains_count !=0 >
			<tr>
				<td class="field_display_border_left" colspan="7"><a href="$filename?page={$page}&amp;action=add&amp;s=$s">{$lng['emails']['emails_add']}</a></td>
			</tr>
			</if>
		</table>
	</form>
	<br />
	<br />
$footer