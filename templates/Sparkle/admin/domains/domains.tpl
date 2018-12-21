 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/domains_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['admin']['domains']}&nbsp;({$domainscount})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'domains'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />

				<div class="overviewsearch">
					{$searchcode}
				</div>
	
				<if (\Froxlor\User::getAll()['domains_used'] < \Froxlor\User::getAll()['domains'] || \Froxlor\User::getAll()['domains'] == '-1') && $countcustomers !=0 >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['domain_add']}</a>
					&nbsp;
					<img src="templates/{$theme}/assets/img/icons/archive.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'import'))}">{\Froxlor\I18N\Lang::getAll()['domains']['domain_import']}</a>
				</div>
				</if>
	
				<table class="full hl">
					<thead>
						<tr>
							<th>{\Froxlor\I18N\Lang::getAll()['domains']['domainname']}&nbsp;{$arrowcode['d.domain']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['admin']['ipsandports']['ip']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['admin']['customer']}&nbsp;{$arrowcode['c.loginname']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['panel']['options']}</th>
						</tr>
					</thead>
	
					<tbody>
						{$domains}
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
				<div class="warningtitle">{\Froxlor\I18N\Lang::getAll()['admin']['warning']}</div>
				<div class="warning">
					<a href="{$linker->getLink(array('section' => 'customers', 'page' => 'customers', 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['domain_nocustomeraddingavailable']}</a>
				</div>
			</div>
			</if>

			<if (\Froxlor\User::getAll()['domains_used'] < \Froxlor\User::getAll()['domains'] || \Froxlor\User::getAll()['domains'] == '-1') && 15 < $count && 0 < $countcustomers >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['domain_add']}</a>
			</div>
			</if>

		</section>
	</article>
$footer
