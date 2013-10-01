		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="templates/${theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['admin']['froxlorclient_settings']}&nbsp;
					"<a href="$filename?s=$s&amp;page=$page&amp;action=view&amp;id={$id}">{$client->Get('name')}</a>"</b>
				[<a href="$filename?page=clients&amp;action=settings&amp;part=&amp;s=$s&amp;id={$id}">{$lng['admin']['configfiles']['compactoverview']}</a>]</td>
			</tr>
			$fields
			<tr>
				<td class="maintitle_apply_right" nowrap="nowrap" colspan="2">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
		</table>
