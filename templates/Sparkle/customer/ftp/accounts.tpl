 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/group_edit_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['menue']['ftp']['accounts']}&nbsp;({$ftps_count})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'ftp'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />

				<div class="overviewsearch">
					{$searchcode}
				</div>
	
				<if (\Froxlor\User::getAll()['ftps_used'] < \Froxlor\User::getAll()['ftps'] || \Froxlor\User::getAll()['ftps'] == '-1') >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'ftp', 'page' => 'accounts', 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['ftp']['account_add']}</a>
				</div>
				</if>

				<table class="full hl">
					<thead>
						<tr>
							<th>{\Froxlor\I18N\Lang::getAll()['login']['username']}&nbsp;{$arrowcode['username']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['panel']['ftpdesc']}&nbsp;{$arrowcode['description']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['panel']['path']}&nbsp;{$arrowcode['homedir']}</th>
							<if \Froxlor\Settings::Get('system.allow_customer_shell') == '1' >
							<th>{\Froxlor\I18N\Lang::getAll()['panel']['shell']}</th>
							</if>
							<th>{\Froxlor\I18N\Lang::getAll()['panel']['options']}</th>
						</tr>
					</thead>

					<if $pagingcode != ''>
					<tfoot>
						<tr>
							<td colspan="3">{$pagingcode}</td>
						</tr>
					</tfoot>
					</if>

					<tbody>
						{$accounts}
					</tbody>
				</table>
			</form>

			<if (\Froxlor\User::getAll()['ftps_used'] < \Froxlor\User::getAll()['ftps'] || \Froxlor\User::getAll()['ftps'] == '-1') && 15 < $ftps_count >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'ftp', 'page' => 'accounts', 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['ftp']['account_add']}</a>
			</div>
			</if>

		</section>
	</article>
$footer
