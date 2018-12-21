$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/group_edit_big.png" alt="" /> 
				{\Froxlor\I18N\Lang::getAll()['admin']['customers']} ({$customercount})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'customers'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				
				<div class="overviewsearch">
					{$searchcode}
				</div>
			
				<if \Froxlor\User::getAll()['customers_used'] < \Froxlor\User::getAll()['customers'] || \Froxlor\User::getAll()['customers'] == '-1'>
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['customer_add']}</a>
				</div>
				</if>

				<table class="full hl">
					<thead>
						<tr>
							<th>
								{\Froxlor\I18N\Lang::getAll()['customer']['name']},
								{\Froxlor\I18N\Lang::getAll()['customer']['firstname']}&nbsp;{$arrowcode['c.name']}
							</th>
							<th>
								{\Froxlor\I18N\Lang::getAll()['login']['username']}&nbsp;{$arrowcode['c.loginname']}
							</th>
							<th>
								{\Froxlor\I18N\Lang::getAll()['admin']['admin']}&nbsp;{$arrowcode['a.loginname']}
							</th>
							<th>{\Froxlor\I18N\Lang::getAll()['admin']['lastlogin_succ']}</th>
							<th></th>
							<th>{\Froxlor\I18N\Lang::getAll()['panel']['options']}</th>
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

			<if (\Froxlor\User::getAll()['customers_used'] < \Froxlor\User::getAll()['customers'] || \Froxlor\User::getAll()['customers'] == '-1') && 15 < \Froxlor\User::getAll()['customers_used'] >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['customer_add']}</a>
			</div>
			</if>

		</section>

	</article>
$footer
