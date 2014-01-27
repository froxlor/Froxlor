 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/domains_big.png" alt="" />&nbsp;
				{$lng['domains']['domainsettings']}&nbsp;({$domains_count})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'domains'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />

				<div class="overviewsearch">
					{$searchcode}
				</div>
	
				<if ($userinfo['subdomains_used'] < $userinfo['subdomains'] || $userinfo['subdomains'] == '-1') && $parentdomains_count != 0 >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'add'))}">{$lng['domains']['subdomain_add']}</a>
				</div>
				</if>
	
				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['domains']['domainname']}&nbsp;{$arrowcode['d.domain']}</th>
							<th>{$lng['panel']['path']}</th>
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
						{$domains}
					</tbody>
				</table>
			</form>

			<if ($userinfo['subdomains_used'] < $userinfo['subdomains'] || $userinfo['subdomains'] == '-1') && 15 < $domains_count && $parentdomains_count != 0 >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'add'))}">{$lng['domains']['subdomain_add']}</a>
			</div>
			</if>

		</section>
	</article>
$footer
