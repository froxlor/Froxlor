$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/group_edit_big.png" alt="" />&nbsp;
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
						{$lng['customer']['name']}&nbsp;&nbsp;{$arrowcode['c.name']}
						{$lng['customer']['firstname']}&nbsp;&nbsp;{$arrowcode['c.firstname']}
					</th>
					<th>
						{$lng['login']['username']}&nbsp;{$arrowcode['c.loginname']}
					</th>
					<th>
						{$lng['admin']['admin']}&nbsp;{$arrowcode['a.loginname']}
					</th>
					<th>{$lng['admin']['lastlogin_succ']}</th>
					<th></th>
					<th>{$lng['panel']['options']}</th>
				</tr>
			</thead>
			<if $pagingcode != ''>
				<tfoot>
					<tr>
						<td colspan="6">{$pagingcode}</td>
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
