 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/domains_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['domains']['domainsettings']}&nbsp;({$domains_count})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'domains'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />

				<div class="overviewsearch">
					{$searchcode}
				</div>
	
				<if (\Froxlor\User::getAll()['subdomains_used'] < \Froxlor\User::getAll()['subdomains'] || \Froxlor\User::getAll()['subdomains'] == '-1') && $parentdomains_count != 0 >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['domains']['subdomain_add']}</a>
				</div>
				</if>
	
				<table class="full hl">
					<thead>
						<tr>
							<th>{\Froxlor\I18N\Lang::getAll()['domains']['domainname']}&nbsp;{$arrowcode['d.domain']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['panel']['path']}</th>
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
						{$domains}
					</tbody>
				</table>
			</form>

			<if (\Froxlor\User::getAll()['subdomains_used'] < \Froxlor\User::getAll()['subdomains'] || \Froxlor\User::getAll()['subdomains'] == '-1') && 15 < $domains_count && $parentdomains_count != 0 >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['domains']['subdomain_add']}</a>
			</div>
			</if>

		</section>
	</article>
$footer
