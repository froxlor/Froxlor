<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
	<tr>
		<td  class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['aps']['specialoptions']}</b></td>
	</tr>
	<tr>
		<td class="field_name_border_left" valign="top" width="15%"><strong>{$lng['aps']['statistics']}</strong></td>
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
			<td  class="maintitle" colspan="3"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['aps']['manageinstances']}</b></td>
		</tr>
		<tr>
			<td class="field_display_border_left">{$lng['aps']['packagenameandstatus']}</td>
			<td class="field_display" width="7%">{$lng['aps']['stopinstall']}</td>
			<td class="field_display" width="7%">{$lng['aps']['uninstall']}</td>
		</tr>
		<tr>
			<td  class="title" colspan="3" style="font-size: 1.1em;"><strong>{$lng['aps']['instance_install']}</strong></td>
		</tr>
		$InstancesInstall
		<tr>
			<td  class="title" colspan="3" style="font-size: 1.1em;"><strong>{$lng['aps']['instance_task_active']}</strong></td>
		</tr>
		$InstancesTaskActive
		<tr>
			<td  class="title" colspan="3" style="font-size: 1.1em;"><strong>{$lng['aps']['instance_success']}</strong></td>
		</tr>
		$InstancesSuccess
		<tr>
			<td  class="title" colspan="3" style="font-size: 1.1em;"><strong>{$lng['aps']['instance_error']}</strong></td>
		</tr>
		$InstancesError
		<tr>
			<td  class="title" colspan="3" style="font-size: 1.1em;"><strong>{$lng['aps']['instance_uninstall']}</strong></td>
		</tr>
		$InstancesUninstall
		<tr>
			<td  class="maintitle_apply_right" colspan="3"><input class="bottom" type="reset" value="{$lng['panel']['reset']}"/>&nbsp;<input class="bottom" type="submit" name="save" value="{$lng['panel']['save']}"/></td>
		</tr>
	</table>
</form>
<br />
<br />
