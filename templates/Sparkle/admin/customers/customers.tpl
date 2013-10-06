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

			<if ($userinfo['customers_used'] < $userinfo['customers'] || $userinfo['customers'] == '-1') && 15 < $userinfo['customers_used'] >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/user_add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['customer_add']}</a>
				</div>
			</if>
			
			<div class="overviewsearch">
				{$searchcode}
			</div>

			<table class="bradius" id="sortable" sort-column="1">
			<thead>
				<tr>
					<th>
						{$lng['customer']['name']},
						{$lng['customer']['firstname']}
					</th>
					<th>
						{$lng['login']['username']}
					</th>
					<th>
						{$lng['admin']['admin']}
					</th>
					<th>{$lng['admin']['lastlogin_succ']}</th>
					<th class="nosort"></th>
					<th class="nosort">{$lng['panel']['options']}</th>
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
