 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/lock_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['menue']['main']['apikeys']}
			</h2>
		</header>
		
		<if !empty($success_message)>
			<div class="successcontainer bradius">
				<div class="successtitle">{\Froxlor\I18N\Lang::getAll()['success']['success']}</div>
				<div class="success">
					$success_message
				</div>
			</div>
		</if>

		<section>

			<form action="{$linker->getLink(array('section' => 'index', 'page' => $page))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />

				<div class="overviewsearch">
					{$searchcode}
				</div>

				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />
					<a href="{$linker->getLink(array('section' => 'index', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['apikeys']['key_add']}</a>
				</div>

				<table class="full hl">
					<thead>
						<tr>
							<th>{\Froxlor\I18N\Lang::getAll()['login']['username']}</th>
							<th>API-key</th>
							<th>Secret</th>
							<th>{\Froxlor\I18N\Lang::getAll()['apikeys']['allowed_from']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['apikeys']['valid_until']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['panel']['options']}</th>
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
						{$apikeys}
					</tbody>
				</table>
			</form>

			<if 15 < $count >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />
				<a href="{$linker->getLink(array('section' => 'index', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['apikeys']['key_add']}</a>
			</div>
			</if>
		</section>
	</article>
$footer
