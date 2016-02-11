$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/group_edit_big.png" alt="" /> 
				{$lng['admin']['customers']} ({$customercount})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'customers'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				
				<div class="overviewsearch">
					{$searchcode}
				</div>
			
				<if $userinfo['customers_used'] < $userinfo['customers'] || $userinfo['customers'] == '-1'>
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['customer_add']}</a>
				</div>
				</if>

				<table class="full hl">
					<thead>
						<tr>
							<th>
								{$lng['customer']['name']},
								{$lng['customer']['firstname']}&nbsp;{$arrowcode['c.name']}
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
			
					<tbody>
						$customers
					</tbody>
			
					<if $pagingcode != ''>
					<tfoot>
						<tr>
							<td colspan="6">{$pagingcode}</td>
						</tr>
					</tfoot>
					</if>
				</table>

			</form>

			<if ($userinfo['customers_used'] < $userinfo['customers'] || $userinfo['customers'] == '-1') && 15 < $userinfo['customers_used'] >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['customer_add']}</a>
			</div>
			</if>

		</section>

	</article>
$footer
