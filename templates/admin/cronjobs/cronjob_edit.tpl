$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<input type="hidden" name="id" value="$id" />
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['cronjob_edit']}</b></td>
			</tr>
			<tr>
				<td class="maintitle_apply_left">
					<b><img src="images/title.gif" alt="" />&nbsp;{$lng['cronjob']['cronjobsettings']}</b>
				</td>
				<td class="maintitle_apply_right" nowrap="nowrap">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
			<tr>
				<td class="main_field_name">Cronjob:</td>
				<if $change_cronfile == 1 >
					<td class="main_field_display" nowrap="nowrap">"><input type="text" name="cronfile" value="{$result['cronfile']}" /></td>
				<else>
					<td class="main_field_display" nowrap="nowrap">{$result['cronfile']}</td>
				<if>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['activated']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$isactive}</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['cronjob']['cronjobinterval']}:</td>
				<td class="main_field_display" nowrap="nowrap">
					<input type="text" name="interval_value" value="{$interval_value}" />&nbsp;
					<select class="dropdown_noborder" name="interval_interval">$interval_interval</select>
				</td>
			</tr>
			<tr>
				<td class="maintitle_apply_right" nowrap="nowrap" colspan="2">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
