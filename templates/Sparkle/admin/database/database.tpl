$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/mysql_big.png" alt="" />&nbsp;
				{$lng['admin']['databases']}&nbsp;({$databasecount})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'databases'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />

				<div class="overviewsearch">
					{$searchcode}
				</div>
	
				<if ($userinfo['mysqls_used'] < $userinfo['mysqls'] || $userinfo['mysqls'] == '-1') && $countcustomers !=0 >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'databases', 'page' => $page, 'action' => 'add'))}">{$lng['mysql']['database_create']}</a>
				</div>
				</if>
	
				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['mysql']['databasename']}&nbsp;{$arrowcode['d.databasename']}</th>
							<th>{$lng['mysql']['databasedescription']}&nbsp;{$arrowcode['d.description']}</th>
							<th>{$lng['mysql']['size']}</th>
                                                        <if 1 < $count_mysqlservers><th>{$lng['mysql']['mysql_server']}</th></if>
							<th>{$lng['admin']['customer']}&nbsp;{$arrowcode['c.loginname']}</th>
						</tr>
					</thead>
	
					<tbody>
						{$mysqls}
					</tbody>
					
					<if $pagingcode != ''>
					<tfoot>
						<tr>
							<td colspan="4">{$pagingcode}</td>
						</tr>
					</tfoot>
					</if>
				</table>

			</form>

			<if $countcustomers == 0 >
			<div class="warningcontainer bradius">
				<div class="warningtitle">{$lng['admin']['warning']}</div>
				<div class="warning">
					<a href="{$linker->getLink(array('section' => 'customers', 'page' => 'customers', 'action' => 'add'))}">{$lng['admin']['domain_nocustomeraddingavailable']}</a>
				</div>
			</div>
			</if>

			<if ($userinfo['domains_used'] < $userinfo['domains'] || $userinfo['domains'] == '-1') && 15 < $count && 0 < $countcustomers >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['domain_add']}</a>
			</div>
			</if>

		</section>
	</article>
$footer
