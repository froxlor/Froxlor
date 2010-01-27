$header
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left" colspan="4"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['cron']['cronsettings']}</b></td>
				<td class="maintitle_search_right" colspan="2">{$searchcode}</td>
			</tr>
			<tr>
				<td class="field_display_border_left">{$lng['cron']['cronname']}&nbsp;&nbsp;{$arrowcode['c.cronfile']}</td>
				<td class="field_display">{$lng['cron']['lastrun']}&nbsp;&nbsp;{$arrowcode['c.lastrun']}</td>
				<td class="field_display">{$lng['cron']['interval']}&nbsp;&nbsp;{$arrowcode['c.interval']}</td>
				<td class="field_display">{$lng['cron']['isactive']}&nbsp;&nbsp;{$arrowcode['c.isactive']}</td>
				<td class="field_display_search" colspan="2">{$sortcode}</td>
			</tr>
			$crons
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="6" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left" colspan="6"><a href="$filename?page=$page&amp;action=add&amp;s=$s">{$lng['admin']['cron']['add']}</a></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
