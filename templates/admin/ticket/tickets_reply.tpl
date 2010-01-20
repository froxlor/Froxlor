$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
 		<input type="hidden" name="id" value="$id" />
		<if 0 < $ticket_replies_count >
		$ticket_replies
		</if>
		<if $isclosed < 1 >
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['ticket']['ticket_reply']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['ticket']['subject']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="subject" value="Re: {$subject}" /></td>
			</tr>
 			<tr>
				<td class="main_field_name">{$lng['ticket']['priority']}:</td>
				<td class="main_field_display" nowrap="nowrap"><select class="tendina_nobordo"  name="priority">$priorities</select></td>
 			</tr>
 			<tr>
				<td class="main_field_name">{$lng['ticket']['category']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$row['name']}</td>
 			</tr>
			<tr>
				<td class="main_field_name" colspan="2">{$lng['ticket']['message']}:</td>
 			</tr>
			<tr>
				<td class="main_field_display" colspan="2"><textarea class="textarea_border" rows="12" cols="60" name="message"></textarea></td>
 			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['ticket']['ticket_reply']}" /></td>
			</tr>
		</table>
		</if>
		<if 0 < $isclosed >
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['ticket']['ticket_reopen']}</b></td>
			</tr>
			<tr>
				<td class="main_field_confirm"><a href="$filename?page=tickets&amp;action=reopen&amp;id={$id}&amp;s=$s">{$lng['ticket']['ticket_reopen']}</a></td>
			</tr>
		</table>
		</if>
	</form>
	<br />
	<br />
$footer