 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/domains.png" alt="" />&nbsp;
				{$lng['domains']['domainsettings']}&nbsp;({$domains_count})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'domains'))}" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if ($userinfo['subdomains_used'] < $userinfo['subdomains'] || $userinfo['subdomains'] == '-1') && 15 < $domains_count && $parentdomains_count != 0 >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/domain_add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'add'))}">{$lng['domains']['subdomain_add']}</a>
				</div>
			</if>

			<table class="bradiusodd">
				<thead>
					<tr>
						<th>{$lng['domains']['domainname']}&nbsp;&nbsp;{$arrowcode['d.domain']}</th>
						<th>{$lng['panel']['path']}&nbsp;&nbsp;{$arrowcode['d.documentroot']}
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
					{$domains}
				</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
			</p>

			</form>

			<if ($userinfo['subdomains_used'] < $userinfo['subdomains'] || $userinfo['subdomains'] == '-1') && $parentdomains_count != 0 >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/domain_add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'add'))}">{$lng['domains']['subdomain_add']}</a>
				</div>
			</if>

		</section>
	</article>
$footer
