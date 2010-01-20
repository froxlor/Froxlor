<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
	<tr>
		<td  class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['aps']['specialoptions']}</b></td>
	</tr>
	<tr>
		<td class="field_name_border_left" valign="top" width="15%"><strong>{$lng['admin']['phpsettings']['actions']}</strong></td>
		<td class="field_name">
			<form method="post" action="$filename" style="float:left;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="save" value="save" />
				<input type="submit" name="downloadallpackages" value="{$lng['aps']['downloadallpackages']}" />
			</form>
		</td>
	</tr>
</table>
<br/>
<br/>