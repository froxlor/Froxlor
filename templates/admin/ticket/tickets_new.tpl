$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['ticket']['ticket_new']}</b></td>
			</tr>
 			<tr>
				<td class="main_field_name">{$lng['ticket']['customer']}:</td>
				<td class="main_field_display" nowrap="nowrap"><select name="customer">$customers</select></td>
 			</tr>
			<tr>
				<td class="main_field_name">{$lng['ticket']['subject']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="subject" maxlength="70" /></td>
			</tr>
 			<tr>
				<td class="main_field_name">{$lng['ticket']['priority']}:</td>
				<td class="main_field_display" nowrap="nowrap"><select class="tendina_nobordo"  name="priority">$priorities</select></td>
 			</tr>
 			<tr>
				<td class="main_field_name">{$lng['ticket']['category']}:</td>
				<td class="main_field_display" nowrap="nowrap"><select class="tendina_nobordo"  name="category">$categories</select></td>
 			</tr>
			<tr>
				<td class="main_field_name" colspan="2">{$lng['ticket']['message']}:</td>
 			</tr>
			<tr>
				<td class="main_field_display" colspan="2"><textarea class="textarea_border" rows="12" cols="60" name="message"></textarea></td>
 			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['ticket']['ticket_new']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer