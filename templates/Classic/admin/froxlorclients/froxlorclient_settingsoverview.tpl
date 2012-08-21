		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" align="center" colspan="3">
					<b><img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['admin']['configfiles']['serverconfiguration']}&nbsp;"{$client->Get('name')}"</b>
					[<a href="$filename?page=clients&amp;action=settings&amp;part=all&amp;s=$s&amp;id={$id}">{$lng['admin']['configfiles']['overview']}</a>]
				</td>
			</tr>
			$fields
			<tr>
				<td class="maintitle_apply_right" nowrap="nowrap" colspan="3">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" />&nbsp;<input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
		</table>
