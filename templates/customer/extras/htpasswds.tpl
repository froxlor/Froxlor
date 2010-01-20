$header
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['menue']['extras']['directoryprotection']}</b></td>
				<td class="maintitle_search_right" colspan="3">{$searchcode}</td>
			</tr>
			<tr>
				<td class="field_display_border_left">{$lng['login']['username']}&nbsp;&nbsp;{$arrowcode['username']}</td>
				<td class="field_display">{$lng['panel']['path']}&nbsp;&nbsp;{$arrowcode['path']}</td>
				<td class="field_display_search" colspan="2">{$sortcode}</td>
			</tr>
			$htpasswds
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="4" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left" colspan="4"><a href="$filename?page=htpasswds&amp;action=add&amp;s=$s">{$lng['extras']['directoryprotection_add']}</a></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer