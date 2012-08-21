$header
<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
	<tr>
		<td class="maintitle" colspan="3"><b><img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['menue']['traffic']['traffic']}</b></td>
	</tr>
	<tr>
		<td colspan="3" class="field_name_border_left">
			<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable" width="100%">
				<tr>
					<td class="title">{$lng['traffic']['sumftp']} GB</td>
					<td class="title">{$lng['traffic']['sumhttp']} GB</td>
					<td class="title">{$lng['traffic']['summail']} GB</td>
				</tr>
				<tr>
					<td class="field_name_border_left"><div style="color:#019522;text-align:center">{$traffic_complete['ftp']}</div></td>
					<td class="field_name"><div style="color:#0000FF;text-align:center">{$traffic_complete['http']}</div></td>
					<td class="field_name"><div style="color:#800000;text-align:center">{$traffic_complete['mail']}</div></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="title">{$lng['traffic']['month']}</td>
		<td class="title">{$lng['traffic']['distribution']}</td>
		<td class="title" align="right">{$lng['customer']['traffic']}</td>
	</tr>
	$traffic
</table>
$footer

