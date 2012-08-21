$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<input type="hidden" name="action" value="$action"/>
		<if 0 < $success >
			<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
				<tr>
					<td class="maintitle" colspan="2">&nbsp;<b>{$successmessage}</b></td>
				</tr>
			</table>
			<br />
			<br />
		</if>
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle" colspan="2"><b><img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['admin']['message']}</b></td>
		</tr>
		<tr>
			<td class="main_field_name">{$lng['admin']['receipient']}</td>
			<td class="main_field_display" nowrap="nowrap"><select name="receipient">$receipients</select></td>
		</tr>
		<tr>
			<td class="main_field_name">{$lng['admin']['subject']}</td>
			<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="subject" value="{$lng['admin']['nosubject']}"/></td>
		</tr>
		<tr>
			<td class="main_field_name" valign="top">{$lng['admin']['text']}</td>
			<td class="main_field_display" nowrap="nowrap"><textarea class="textarea_noborder" rows="12" cols="80" name="message"></textarea></td>
		</tr>
		<tr>
			<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send"/><input class="bottom" type="submit" value="{$lng['panel']['send']}" /></td>
		</tr>
		</table>
	</form>
	<br />
	<br />
$footer

