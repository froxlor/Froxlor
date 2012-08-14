$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/group_edit.png" alt="" />&nbsp;
				{$lng['admin']['customers']}&nbsp;({$customercount})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'customers'))}" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if ($userinfo['customers_used'] < $userinfo['customers'] || $userinfo['customers'] == '-1') && 15 < $userinfo['customers_used'] >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/user_add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['customer_add']}</a>
				</div>
			</if>

			<table class="bradiusodd">
			<thead>
				<tr>
					<th>
						{$lng['customer']['name']}&nbsp;&nbsp;{$arrowcode['c.name']}&nbsp;
						{$lng['customer']['firstname']}&nbsp;&nbsp;{$arrowcode['c.firstname']}&nbsp;
						{$lng['login']['username']}&nbsp;{$arrowcode['c.loginname']}
						{$lng['admin']['admin']}&nbsp;{$arrowcode['a.loginname']}
					</th>
					<th>{$lng['panel']['options']}</th>
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
				$customers
			</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
			</p>

			</form>

			<if $userinfo['customers_used'] < $userinfo['customers'] || $userinfo['customers'] == '-1'>
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/user_add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['customer_add']}</a>
			</div>
			</if>

		</section>

	</article>
$footer
