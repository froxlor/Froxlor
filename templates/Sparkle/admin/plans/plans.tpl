$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/templates_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['admin']['plans']['plans']}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'plans'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<div class="overviewsearch">
					{$searchcode}
				</div>

				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'plans', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['plans']['add']}</a>
				</div>

				<table class="full hl">
					<thead>
						<tr>
							<th>{\Froxlor\I18N\Lang::getAll()['admin']['plans']['name']}&nbsp;{$arrowcode['p.name']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['admin']['plans']['description']}&nbsp;{$arrowcode['p.description']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['admin']['admin']}&nbsp;{$arrowcode['adminname']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['admin']['plans']['last_update']}&nbsp;{$arrowcode['p.ts']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['panel']['options']}</th>
						</tr>
					</thead>

					<if $pagingcode != ''>
					<tfoot>
						<tr>
							<td colspan="5">{$pagingcode}</td>
						</tr>
					</tfoot>
					</if>

					<tbody>
						$plans
					</tbody>
				</table>
			</form>

			<if 15 < $count>
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'plans', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['plans']['add']}</a>
			</div>
			</if>

		</section>

	</article>
$footer
