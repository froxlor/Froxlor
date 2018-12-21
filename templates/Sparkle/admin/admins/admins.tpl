$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/group_edit_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['admin']['admins']}&nbsp;({$admincount})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'admins'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				
				<div class="overviewsearch">
					{$searchcode}
				</div>

				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />
					<a href="{$linker->getLink(array('section' => 'admins', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['admin_add']}</a>
				</div>

				<table class="full hl">
					<thead>
						<tr>
							<th>{\Froxlor\I18N\Lang::getAll()['customer']['name']}&nbsp;{$arrowcode['name']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['login']['username']}&nbsp;{$arrowcode['loginname']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['admin']['customers']}</th>
							<th>&nbsp;</th>
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
						$admins
					</tbody>
				</table>
			</form>

			<if 15 < $count >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />
				<a href="{$linker->getLink(array('section' => 'admins', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['admin_add']}</a>
			</div>
			</if>

		</section>

	</article>
$footer
