<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['admin']['serversettings']} &nbsp;
				[<a href="$filename?page=overview&amp;part=all&amp;s=$s">{\Froxlor\I18N\Lang::getAll()['admin']['configfiles']['overview']}</a>] &nbsp;
				[<a href="$filename?page=importexport&amp;s=$s">{\Froxlor\I18N\Lang::getAll()['admin']['configfiles']['importexport']}</a>]
			</h2>
		</header>
		
		<section>
			<table class="full">
				<thead>
					<tr>
						<th colspan="3" class="right">
							<input class="bottom" type="reset" value="{\Froxlor\I18N\Lang::getAll()['panel']['reset']}" /><input class="bottom" type="submit" value="{\Froxlor\I18N\Lang::getAll()['panel']['save']}" />
						</th>
					</tr>
				</thead>
				<tbody>
				$fields
				</tbody>
				<tfoot>
					<tr>
						<td nowrap="nowrap" colspan="3" class="right">
							<input class="bottom" type="reset" value="{\Froxlor\I18N\Lang::getAll()['panel']['reset']}" /><input class="bottom" type="submit" value="{\Froxlor\I18N\Lang::getAll()['panel']['save']}" />
						</td>
					</tr>
				</tfoot>
			</table>
		</section>
</article>
