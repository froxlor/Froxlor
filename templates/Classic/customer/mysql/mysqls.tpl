$header
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left" colspan="2"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['menue']['mysql']['databases']}</b>&nbsp;({$mysqls_count})</td>
				<td class="maintitle_search_right" colspan="3">{$searchcode}</td>
			</tr>
			<if ($userinfo['mysqls_used'] < $userinfo['mysqls'] || $userinfo['mysqls'] == '-1') && 15 < $mysqls_count >
			<tr>
				<td class="field_display_border_left" colspan="5"><a href="$filename?page=mysqls&amp;action=add&amp;s=$s">{$lng['mysql']['database_create']}</a></td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left">{$lng['mysql']['databasename']}&nbsp;&nbsp;{$arrowcode['databasename']}</td>
				<td class="field_display">{$lng['mysql']['databasedescription']}&nbsp;&nbsp;{$arrowcode['description']}</td>
				<if 1 < count($sql_root)><td class="field_display">{$lng['mysql']['mysql_server']}</td></if>
				<td class="field_display_search" colspan="2">{$sortcode}</td>
			</tr>
			$mysqls
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="5" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<if ($userinfo['mysqls_used'] < $userinfo['mysqls'] || $userinfo['mysqls'] == '-1') >
			<tr>
				<td class="field_display_border_left" colspan="5"><a href="$filename?page=mysqls&amp;action=add&amp;s=$s">{$lng['mysql']['database_create']}</a></td>
			</tr>
			</if>
		</table>
	</form>
	<br />
	<br />
$footer