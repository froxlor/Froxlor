<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings_big.png" alt="" />&nbsp;
				{$lng['admin']['serversettings']} &nbsp;
				[<a href="$filename?page=overview&amp;part=all&amp;s=$s">{$lng['admin']['configfiles']['overview']}</a>]
			</h2>
		</header>
		
		<section class="fullform bradius">
        	<table class="formtable">
			<thead>
				<tr>
					<th class="maintitle_apply_right" nowrap="nowrap" colspan="3" style="text-align: right !important;">
						<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
					</th>
				</tr>
			</thead>
			<tbody>
			$fields
			</tbody>
			<tfoot>
				<tr>
					<td class="maintitle_apply_right" nowrap="nowrap" colspan="3" style="text-align: right !important;">
						<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
					</td>
				</tr>
			</tfoot>
		</table>
		</section>
</article>
