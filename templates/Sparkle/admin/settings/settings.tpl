<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings_big.png" alt="" />&nbsp;
				{$lng['admin']['serversettings']} &nbsp;
				[<a href="$filename?page=overview&amp;part=&amp;s=$s">{$lng['admin']['configfiles']['compactoverview']}</a>]
			</h2>
		</header>
		
		<section>
			<table class="full">
			$fields
			<tfoot>
				<tr>
					<td class="maintitle_apply_right" nowrap="nowrap" colspan="2" align="right">
						<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
					</td>
				</tr>
			</tfoot>
		</table>
		</section>
</article>
