$header
	<form action="$filename" method="post">
                <input type="hidden" name="s" value="$s"/>
                <input type="hidden" name="page" value="$page"/>
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left" colspan="4"><b><img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['menue']['multiserver']['clients']}&nbsp;"{$client->Get('name')}"</b></td>
			</tr>
			<tr>
				<td colspan="4">@TODO infos about client "{$client->Get('name')}"</td>
			<tr>
				<td colspan="4">
					<a href="$filename?s=$s&amp;page=$page&amp;action=settings&amp;id={$id}">{$lng['admin']['froxlorclients']['settings']}</a>&nbsp;
					<a href="$filename?s=$s&amp;page=$page&amp;action=deploy&amp;id={$id}">{$lng['admin']['froxlorclients']['deploy']}</a>&nbsp;
					<a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$id}">{$lng['panel']['edit']}</a>&nbsp;
					<a href="$filename?s=$s&amp;page=$page&amp;action=delete&amp;id={$id}">{$lng['panel']['delete']}</a>
				</td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
