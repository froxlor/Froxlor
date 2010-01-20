$header
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle_search_left"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['ticket']['lastarchived']}</b></td>
        		<td class="maintitle_search_right" colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td class="field_display_border_left">{$lng['ticket']['archivedtime']}</td>
			<td class="field_display">{$lng['ticket']['ticket_answers']}</td>
			<td class="field_display">{$lng['ticket']['subject']}</td>
			<td class="field_display">{$lng['ticket']['lastreplier']}</td>
			<td class="field_display">{$lng['ticket']['priority']}</td>
        		<td class="field_display_search">&nbsp;</td>
		</tr>
		$tickets
		</table>
	</form>
	<br />
	<br />
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['ticket']['search']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['ticket']['subject']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" name="subject" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['ticket']['priority']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$priorities_options}</td>
			</tr>
 			<tr>
				<td class="main_field_name">{$lng['ticket']['category']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$category_options}</td>
 			</tr>
 			<tr>
				<td class="main_field_name">{$lng['ticket']['lastchange']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$lng['ticket']['lastchange_from']}<br /><input type="text" name="fromdate" /><br />{$lng['ticket']['lastchange_to']}<br /><input type="text" name="todate" /></td>
 			</tr>
			<tr>
				<td class="main_field_name" colspan="2">{$lng['ticket']['message']}:</td>
			</tr>
			<tr>
				<td class="main_field_display" nowrap="nowrap" colspan="2"><textarea class="textarea_border" rows="12" cols="60" name="message"></textarea></td>
			</tr>
 			<tr>
				<td class="main_field_name">{$lng['ticket']['customer']}:</td>
				<td class="main_field_display" nowrap="nowrap"><select class="tendina_nobordo"  name="customer">$customers</select></td>
 			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['panel']['search']}" /></td>
			</tr>
		</table>
	</form>
$footer