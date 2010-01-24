$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<input type="hidden" name="id" value="$id" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['emails']['forwarder_add']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['emails']['from']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$result['email_full']}</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['emails']['to']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" id="destination" name="destination" size="30" /></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['emails']['forwarder_add']}" />&nbsp;<input type="button" class="bottom" value="{$lng['panel']['abort']}" onclick="history.back();" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
	<script type="text/javascript">
		document.forms[0].elements.destination.focus();
	</script>
$footer
