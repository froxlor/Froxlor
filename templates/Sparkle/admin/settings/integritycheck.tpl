$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/res_recalculate_big.png" alt="" />&nbsp;
				{$lng['admin']['integritycheck']}
			</h2>
		</header>

		<section>
			<table class="full">
				<thead>
				<tr>
					<th>{$lng['admin']['integrityid']}</th>
					<th>{$lng['admin']['integrityname']}</th>
					<th>{$lng['admin']['integrityresult']}</th>
				</tr>
				</thead>
				<tfoot>
					<td colspan="3"><a href="{$linker->getLink(array('section' => 'settings', 'page' => $page, 'action' => 'fix'))}">{$lng['admin']['integrityfix']}</a></td>
				</tfoot>
				<tbody>
					{$integritycheck}
				</tbody>
			</table>
		</section>
</article>
$footer
