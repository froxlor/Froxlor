<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
	<tr>
		<td  class="maintitle" colspan="2"><b><img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['aps']['specialoptions']}</b></td>
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
			<form method="post" action="$filename" style="float:left; padding-left: 2em;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="save" value="save" />
				<input type="submit" name="updateallpackages" value="{$lng['aps']['updateallpackages']}" />
			</form>
			<br/>
			<br/>
			<form method="post" action="$filename" style="float:left;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="save" value="save" />
				<input type="submit" name="enablenewest" value="{$lng['aps']['enablenewest']}" />
			</form>
			<form method="post" action="$filename" style="float:left; padding-left: 2em;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="save" value="save" />
				<input type="submit" name="removeunused" value="{$lng['aps']['removeunused']}" />
			</form>
		</td>
	</tr>
	<tr>
		<td class="field_name_border_left" valign="top"><strong>{$lng['aps']['statistics']}</strong></td>
		<td class="field_name">$Statistics</td>
	</tr>
</table>
<br/>
<form method="post" action="$filename">
	<input type="hidden" name="s" value="$s" />
	<input type="hidden" name="action" value="$action" />
	<input type="hidden" name="page" value="$page" />

	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td  class="maintitle" colspan="6"><b><img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['aps']['managepackages']}</b></td>
		</tr>
		<tr>
			<td class="field_display_border_left" width="30%">{$lng['aps']['packagenameandversion']}</td>
			<td class="field_display">{$lng['ticket']['status']}</td>
			<td class="field_display">{$lng['aps']['installations']}</td>
			<td class="field_display" width="7%">{$lng['aps']['lock']}</td>
			<td class="field_display" width="7%">{$lng['aps']['unlock']}</td>
			<td class="field_display" width="7%">{$lng['aps']['remove']}</td>
		</tr>
		$Packages
		<tr>
			<td class="field_display_border_left" colspan="3">{$lng['aps']['allpackages']}</td>
			<td class="field_display" width="7%" style="text-align:center;"><input type="radio" name="all" value="lock"/></td>
			<td class="field_display" width="7%" style="text-align:center;"><input type="radio" name="all" value="unlock"/></td>
			<td class="field_display" width="7%" style="text-align:center;"><input type="radio" name="all" value="remove"/></td>
		</tr>
		<tr>
			<td  class="maintitle_apply_right" colspan="6"><input class="bottom" type="reset" value="{$lng['panel']['reset']}"/>&nbsp;<input class="bottom" type="submit" name="save" value="{$lng['panel']['save']}"/></td>
		</tr>
	</table>
</form>
<br />
<br />
