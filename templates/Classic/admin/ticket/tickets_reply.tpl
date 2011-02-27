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
				<td class="maintitle" colspan="2"><b><img src="images/Classic/title.gif" alt="{$title}" />&nbsp;{$title}</b></td>
			</tr>
			{$ticket_reply_form}
		</table>
		</if>
		<if 0 < $isclosed >
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['ticket']['ticket_reopen']}</b></td>
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