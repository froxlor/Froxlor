$header
	<form action="$filename" method="post">
                <input type="hidden" name="s" value="$s"/>
                <input type="hidden" name="page" value="$page"/>
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left" colspan="4"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['menue']['multiserver']['clients']}</b></td>
				<td class="maintitle_search_right" colspan="3">{$searchcode}</td>
			</tr>
			<tr>
				<td class="field_display_border_left">ID#&nbsp;{$arrowcode['id']}</td>
				<td class="field_display">{$lng['admin']['froxlorclients']['name']}&nbsp;{$arrowcode['name']}</td>
				<td class="field_display">{$lng['admin']['froxlorclients']['desc']}</td>
				<td class="field_display">{$lng['admin']['froxlorclients']['enabled']}&nbsp;{$arrowcode['enabled']}</td>
				<td class="field_display_search" colspan="3">{$sortcode}</td>
			</tr>
			$froxlorclients
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="7" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left" colspan="7"><a href="$filename?page=$page&amp;action=add&amp;s=$s">{$lng['admin']['froxlorclients']['add']}</a></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
