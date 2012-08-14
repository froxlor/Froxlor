$header
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle"><b><img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['admin']['warning']}</b></td>
			</tr>
			<tr>
				<td class="field_name_border_left">
					<span style="font-weight: bold; color: #ff0000;">
						{$lng['cron']['changewarning']}
					</span>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="5"><b><img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['admin']['cron']['cronsettings']}</b></td>
			</tr>
			<tr>
				<td class="field_display_border_left">{$lng['cron']['description']}</td>
				<td class="field_display">{$lng['cron']['lastrun']}</td>
				<td class="field_display">{$lng['cron']['interval']}</td>
				<td class="field_display">{$lng['cron']['isactive']}</td>
				<td class="field_display">{$lng['panel']['options']}</td>
			</tr>
			$crons
		</table>
	</form>
	<br />
	<br />
$footer
