$header
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['menue']['logger']['logger']}</b></td>
				<td class="maintitle_search_right" colspan="2">{$searchcode}</td>
			</tr>
			<if 15 < $log_count >
			<tr>
				<td class="field_display_border_left" colspan="4"><a href="$filename?page=log&amp;action=truncate&amp;s=$s">{$lng['logger']['truncate']}</a></td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left" width="120">{$lng['logger']['date']}&nbsp;&nbsp;{$arrowcode['date']}</td>
				<td class="field_display">{$lng['logger']['type']}&nbsp;&nbsp;{$arrowcode['type']}</td>
				<td class="field_display">{$lng['logger']['user']}&nbsp;&nbsp;{$arrowcode['user']}</td>
				<td class="field_display_search">{$sortcode}</td>
			</tr>
			$log
			<tr>
				<td class="field_display_border_left" colspan="4"><a href="$filename?page=log&amp;action=truncate&amp;s=$s">{$lng['logger']['truncate']}</a></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer