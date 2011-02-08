$header
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['menue']['ftp']['accounts']}</b>&nbsp;({$ftps_count})</td>
				<td class="maintitle_search_right" colspan="3">{$searchcode}</td>
			</tr>
			<if ($userinfo['ftps_used'] < $userinfo['ftps'] || $userinfo['ftps'] == '-1') && 15 < $ftps_count >
			<tr>
				<td class="field_display_border_left" colspan="4"><a href="$filename?page=accounts&amp;action=add&amp;s=$s">{$lng['ftp']['account_add']}</a></td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left">{$lng['login']['username']}&nbsp;&nbsp;{$arrowcode['username']}</td>
				<td class="field_display">{$lng['panel']['path']}&nbsp;&nbsp;{$arrowcode['homedir']}</td>
				<td class="field_display_search" colspan="2">{$sortcode}</td>
			</tr>
			$accounts
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="4" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<if ($userinfo['ftps_used'] < $userinfo['ftps'] || $userinfo['ftps'] == '-1') >
			<tr>
				<td class="field_display_border_left" colspan="4"><a href="$filename?page=accounts&amp;action=add&amp;s=$s">{$lng['ftp']['account_add']}</a></td>
			</tr>
			</if>
		</table>
	</form>
	<br />
	<br />
$footer