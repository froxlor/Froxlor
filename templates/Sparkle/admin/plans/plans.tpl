$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/templates_big.png" alt="" />&nbsp;
				{$lng['admin']['plans']['plans']}
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
					<a href="{$linker->getLink(array('section' => 'plans', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['plans']['add']}</a>
				</div>

				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['admin']['plans']['name']}&nbsp;{$arrowcode['p.name']}</th>
							<th>{$lng['admin']['plans']['description']}&nbsp;{$arrowcode['p.description']}</th>
							<th>{$lng['admin']['admin']}&nbsp;{$arrowcode['adminname']}</th>
							<th>{$lng['admin']['plans']['last_update']}&nbsp;{$arrowcode['p.ts']}</th>
							<th>{$lng['panel']['options']}</th>
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
				<a href="{$linker->getLink(array('section' => 'plans', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['plans']['add']}</a>
			</div>
			</if>

		</section>

	</article>
$footer
