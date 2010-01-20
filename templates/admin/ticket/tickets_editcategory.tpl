$header
	<form method="post" action="$filename">
	<input type="hidden" name="s" value="$s" />
	<input type="hidden" name="page" value="$page" />
	<input type="hidden" name="action" value="$action" />
	<input type="hidden" name="id" value="$id" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['ticket']['ticket_editcateory']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['ticket']['category']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="category" maxlength="50" value="{$row['name']}" /></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['ticket']['ticket_editcateory']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer