$header
	<form method="post" action="$filename">
	<input type="hidden" name="s" value="$s" />
	<input type="hidden" name="page" value="$page" />
	<input type="hidden" name="action" value="$action" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['ticket']['ticket_newcateory']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['ticket']['category']}:</b></td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="category" maxlength="50" /></td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['ticket']['logicalorder']}:</b><br />{$lng['ticket']['orderdesc']}</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="logicalorder" maxlength="3" value="{$order}" /></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['ticket']['ticket_newcateory']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer