 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/domains.png" alt="" />&nbsp;
				{$lng['admin']['domains']}&nbsp;({$domainscount})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'domains'))}" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if ($userinfo['domains_used'] < $userinfo['domains'] || $userinfo['domains'] == '-1') && 15 < $count && 0 < $countcustomers >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/domain_add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['domain_add']}</a>
				</div>
			</if>

			<table class="bradiusodd">
				<thead>
					<tr>
						<th>{$lng['domains']['domainname']}&nbsp;{$arrowcode['d.domain']}</th>
						<th>{$lng['admin']['ipsandports']['ip']}&nbsp;{$arrowcode['ip.ip']}&nbsp;:&nbsp;{$lng['admin']['ipsandports']['port']}&nbsp;{$arrowcode['ip.port']}</th>
						<th>{$lng['admin']['customer']}&nbsp;&nbsp;{$arrowcode['c.loginname']}</th>
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

			<if $countcustomers == 0 >
				<div class="warningcontainer bradius">
					<div class="warningtitle">{$lng['admin']['warning']}</div>
					<div class="warning">
						<a href="{$linker->getLink(array('section' => 'customers', 'page' => 'customers', 'action' => 'add'))}">{$lng['admin']['domain_nocustomeraddingavailable']}</a>
					</div>
				</div>
			</if>

			<if ($userinfo['domains_used'] < $userinfo['domains'] || $userinfo['domains'] == '-1') && $countcustomers !=0 >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/domain_add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['domain_add']}</a>
				</div>
			</if>

		</section>
	</article>
$footer
