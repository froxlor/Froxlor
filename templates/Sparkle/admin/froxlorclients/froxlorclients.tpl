$header
	<form action="$filename" method="post">
                <input type="hidden" name="s" value="$s"/>
                <input type="hidden" name="page" value="$page"/>
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left" colspan="3"><b><img src="templates/${theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['menue']['multiserver']['clients']}</b></td>
				<td class="maintitle_search_right" colspan="1">{$searchcode}</td>
			</tr>
			<tr>
				<td class="field_display_border_left" style="width:70px;">#</td>
				<td class="field_display">{$lng['admin']['froxlorclients']['name']}&nbsp;{$arrowcode['name']}<br />{$lng['admin']['froxlorclients']['desc']}</td>
				<td class="field_display" style="width:35px;">{$lng['admin']['froxlorclients']['enabled']}&nbsp;{$arrowcode['enabled']}</td>
				<td class="field_display_search" style="width:250px;">{$sortcode}</td>
			</tr>
			$froxlorclients
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="4" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left" colspan="4"><a href="$filename?page=$page&amp;action=add&amp;s=$s">{$lng['admin']['froxlorclients']['add']}</a></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
