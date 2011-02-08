$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['menue']['main']['changetheme']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['panel']['theme']}</td>
				<td class="main_field_display" nowrap="nowrap"><select class="dropdown_noborder" name="theme">$theme_options</select></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input class="bottom" type="submit" value="{$lng['menue']['main']['changetheme']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
