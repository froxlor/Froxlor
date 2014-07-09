 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/group_edit_big.png" alt="" />&nbsp;
				{$lng['menue']['ftp']['accounts']}&nbsp;({$ftps_count})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'ftp'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />

				<div class="overviewsearch">
					{$searchcode}
				</div>
	
				<if ($userinfo['ftps_used'] < $userinfo['ftps'] || $userinfo['ftps'] == '-1') >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'ftp', 'page' => 'accounts', 'action' => 'add'))}">{$lng['ftp']['account_add']}</a>
				</div>
				</if>

				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['login']['username']}&nbsp;{$arrowcode['username']}</th>
							<th>{$lng['panel']['ftpdesc']}&nbsp;{$arrowcode['description']}</th>
							<th>{$lng['panel']['path']}&nbsp;{$arrowcode['homedir']}</th>
							<th>{$lng['panel']['options']}</th>
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

			<if ($userinfo['ftps_used'] < $userinfo['ftps'] || $userinfo['ftps'] == '-1') && 15 < $ftps_count >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'ftp', 'page' => 'accounts', 'action' => 'add'))}">{$lng['ftp']['account_add']}</a>
			</div>
			</if>

		</section>
	</article>
$footer

