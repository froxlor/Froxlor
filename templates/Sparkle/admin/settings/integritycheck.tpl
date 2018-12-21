$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/res_recalculate_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['admin']['integritycheck']}
			</h2>
		</header>

		<section>
			<table class="full">
				<thead>
				<tr>
					<th>{\Froxlor\I18N\Lang::getAll()['admin']['integrityid']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['admin']['integrityname']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['admin']['integrityresult']}</th>
				</tr>
				</thead>
				<tfoot>
					<td colspan="3"><a href="{$linker->getLink(array('section' => 'settings', 'page' => $page, 'action' => 'fix'))}">{\Froxlor\I18N\Lang::getAll()['admin']['integrityfix']}</a></td>
				</tfoot>
				<tbody>
					{$integritycheck}
				</tbody>
			</table>
		</section>
</article>
$footer
