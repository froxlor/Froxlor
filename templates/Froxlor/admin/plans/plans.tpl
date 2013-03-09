$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/domains.png" alt="" />&nbsp;
				{$lng['admin']['plans']['plan']}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'plans'))}" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<table class="bradiusodd table-striped">
			<thead>
				<tr>
					<th>
                        {$lng['customer']['name']}{$arrowcode['plan_name']}
					</th>
					<th>
						{$lng['admin']['plans']['plan_group']}{$arrowcode['plan_type']}
					</th>
					<th>
						{$lng['customer']['diskspace']}&nbsp;{$arrowcode['diskspace']}
					</th>
					<th>
						{$lng['customer']['traffic']}&nbsp;{$arrowcode['traffic']}
					</th>
					<th>
						{$lng['panel']['options']}
					</th>
				</tr>
			</thead>
			<if $pagingcode != ''>
				<tfoot>
					<tr>
						<td>{$pagingcode}</td>
					</tr>
				</tfoot>
			</if>
			<tbody>
				$plan
			</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
			</p>

			</form>

			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/domain_add.png" alt="" />&nbsp;
				<a class="btn" href="{$linker->getLink(array('section' => 'plans', 'page' => $page, 'action' => 'add'))}"><i class="icon-plus"></i> {$lng['admin']['plans']['plan_add']}</a>
			</div>

		</section>

	</article>
$footer
