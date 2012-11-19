 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/mysqls.png" alt="" />&nbsp;
				{$lng['menue']['mysql']['databases']}&nbsp;({$mysqls_count})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'mysql'))}" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if ($userinfo['mysqls_used'] < $userinfo['mysqls'] || $userinfo['mysqls'] == '-1') && 15 < $mysqls_count >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/mysql_add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'mysql', 'page' => 'mysqls', 'action' => 'add'))}">{$lng['mysql']['database_create']}</a>
				</div>
			</if>

			<table class="bradiusodd">
				<thead>
					<tr>
						<th>{$lng['mysql']['databasename']}&nbsp;{$arrowcode['databasename']}</th>
						<th>{$lng['mysql']['databasedescription']}&nbsp;{$arrowcode['description']}</th>
						<th>{$lng['mysql']['size']}</th>
						<if 1 < count($sql_root)><th>{$lng['mysql']['mysql_server']}</th></if>
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
					{$mysqls}
				</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
			</p>

			</form>

			<if ($userinfo['mysqls_used'] < $userinfo['mysqls'] || $userinfo['mysqls'] == '-1') >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/mysql_add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'mysql', 'page' => 'mysqls', 'action' => 'add'))}">{$lng['mysql']['database_create']}</a>
				</div>
			</if>

		</section>
	</article>
$footer

