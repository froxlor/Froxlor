$header
	<form action="$yesfile" method="post">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="send" value="send" />
		$hiddenparams
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b>&nbsp;<img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['question']['question']}</b></td>
			</tr>
			<tr>
				<td class="field_name_center_noborder">$text</td>
				<td class="field_name">$checkbox</td>
			</tr>
			<tr>
				<td class="field_name_border_left" nowrap="nowrap" style="text-align: center;" colspan="2"><input type="submit" class="bottom" name="submitbutton" value="{$lng['panel']['yes']}" />&nbsp;<input type="button" class="bottom" value="{$lng['panel']['no']}" id="yesnobutton" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
