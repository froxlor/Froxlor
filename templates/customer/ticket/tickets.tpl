$header
	<form action="$filename" method="post">
	<input type="hidden" name="s" value="$s" />
	<input type="hidden" name="page" value="$page" />
	<input type="hidden" name="send" value="send" />
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle_search_left"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['ticket']['supportstatus']}</b></td>
			<td class="maintitle_search_right">&nbsp;</td>
		</tr>
		<tr>
			<td class="field_name_border_left" colspan="2">
				<if 0 < $supportavailable >
				{$lng['ticket']['supportavailable']}
				</if>
				<if $supportavailable < 1 >
				{$lng['ticket']['supportnotavailable']}
				</if>
			</td>
		</tr>
	</table>
	<br />
	<br />
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle_search_left"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['menue']['ticket']['ticket']}</b></td>
			<td class="maintitle_search_right" colspan="7">{$searchcode}</td>
		</tr>
		<if ($userinfo['tickets_used'] < $userinfo['tickets'] || $userinfo['tickets'] == '-1') && 15 < $tickets_count && ($ticketsopen < $settings['ticket']['concurrently_open'] || ($settings['ticket']['concurrently_open'] == '-1' || $settings['ticket']['concurrently_open'] == '')) >
		<tr>
			<td class="field_display_border_left" colspan="8"><a href="$filename?page=tickets&amp;action=new&amp;s=$s">{$lng['ticket']['ticket_new']}</a></td>
		</tr>
		</if>
		<tr>
			<td class="field_display_border_left">{$lng['ticket']['lastchange']}&nbsp;&nbsp;{$arrowcode['lastchange']}</td>
			<td class="field_display">{$lng['ticket']['ticket_answers']}&nbsp;&nbsp;{$arrowcode['ticket_answers']}</td>
			<td class="field_display">{$lng['ticket']['subject']}&nbsp;&nbsp;{$arrowcode['subject']}</td>
			<td class="field_display">{$lng['ticket']['status']}&nbsp;&nbsp;{$arrowcode['status']}</td>
			<td class="field_display">{$lng['ticket']['lastreplier']}&nbsp;&nbsp;{$arrowcode['lastreplier']}</td>
			<td class="field_display">{$lng['ticket']['priority']}&nbsp;&nbsp;{$arrowcode['priority']}</td>
			<td class="field_display_search" colspan="2">{$sortcode}</td>
		</tr>
		$tickets
		<if $pagingcode != ''>
		<tr>
			<td class="field_display_border_left" colspan="8" style=" text-align: center; ">{$pagingcode}</td>
		</tr>
		</if>
		<if ($userinfo['tickets_used'] < $userinfo['tickets'] || $userinfo['tickets'] == '-1') && ($ticketsopen < $settings['ticket']['concurrently_open'] || ($settings['ticket']['concurrently_open'] == '-1' || $settings['ticket']['concurrently_open'] == '')) >
		<tr>
			<td class="field_display_border_left" colspan="8"><a href="$filename?page=tickets&amp;action=new&amp;s=$s">{$lng['ticket']['ticket_new']}</a></td>
		</tr>
		</if>
	</table>
	</form>
	<br />
	<br />
$footer