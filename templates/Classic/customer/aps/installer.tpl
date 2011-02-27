<form method="post" action="$filename">
	<input type="hidden" name="s" value="$s" />
	<input type="hidden" name="page" value="$page" />
	<input type="hidden" name="action" value="install" />
	<input type="hidden" name="withinput" value="withinput" />
	<input type="hidden" name="id" value="{$Row['ID']}" />

	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle" colspan="3"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$Xml->name}</b></td>
		</tr>
		<tr>
			<td class="field_name_border_left" colspan="2" valign="top" width="99%"><strong>{$lng['aps']['install_wizard']}</strong>
			<if $ErrorMessage != 0>
				<div class="dataerror">{$lng['aps']['wizard_error']}</div>
			</if>
			</td>
			<td class="field_name" style="text-align: center; padding: 10px; background-color:#FFFFFF;" valign="middle"><img src="{$Icon}" alt="{$Xml->name} Icon"/></td>
		</tr>
		$Data
		<tr>
			<td class="field_name_border_left" colspan="3">
				<input class="bottom" type="submit" value="{$lng['aps']['install']}" />
			</td>
		</tr>
	</table>
</form>