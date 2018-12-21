<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['admin']['serversettings']} &nbsp;
				[<a href="$filename?page=overview&amp;part=&amp;s=$s">{\Froxlor\I18N\Lang::getAll()['admin']['configfiles']['compactoverview']}</a>] &nbsp;
				[<a href="$filename?page=importexport&amp;s=$s">{\Froxlor\I18N\Lang::getAll()['admin']['configfiles']['importexport']}</a>]
			</h2>
		</header>
		
		<section>
			<table class="full">
			$fields
			<tfoot>
				<tr>
					<td class="maintitle_apply_right" nowrap="nowrap" colspan="2" align="right">
						<input class="bottom" type="reset" value="{\Froxlor\I18N\Lang::getAll()['panel']['reset']}" /><input class="bottom" type="submit" value="{\Froxlor\I18N\Lang::getAll()['panel']['save']}" />
					</td>
				</tr>
			</tfoot>
		</table>
		</section>
</article>
