$header
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable_60">
		<tr>
			<td class="maintitle"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$configfiles[$distribution]['label']}&nbsp;&raquo;&nbsp;{$configfiles[$distribution]['services'][$service]['label']}&nbsp;&raquo;&nbsp;{$configfiles[$distribution]['services'][$service]['daemons'][$daemon]['label']}</b> [<a href="$filename?s=$s&amp;page=$page&amp;distribution=$distribution&amp;service=$service">{$lng['panel']['back']}</a>]</td>
		</tr>
		{$configpage}
		<if $restart != ''>
		<tr>
			<td class="field_display_border_left">{$lng['admin']['configfiles']['restart']}<br /><br /><textarea class="textarea_border" rows="3" cols="70" readonly="readonly">$restart</textarea></td>
		</tr>
		</if>
	</table>
	<br />
	<br />
$footer