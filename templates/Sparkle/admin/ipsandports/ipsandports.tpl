$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/ipsports_big.png" alt="" />&nbsp;
				{$lng['admin']['ipsandports']['ipsandports']}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'ipsandports'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<div class="overviewsearch">
					{$searchcode}
				</div>

				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'ipsandports', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['ipsandports']['add']}</a>
				</div>

				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['admin']['ipsandports']['ip']}&nbsp;{$arrowcode['ip']}</th>
							<th>{$lng['admin']['ipsandports']['port']}&nbsp;{$arrowcode['port']}</th>
							<if !$is_nginx><th>Listen</th></if>
							<if $is_apache && !$is_apache24><th>NameVirtualHost</th></if>
							<th>vHost-Container</th>
							<th>Specialsettings</th>
							<if $is_apache><th>ServerName</th></if>
							<th>SSL</th>
							<th>{$lng['panel']['options']}</th>
						</tr>
					</thead>

					<if $pagingcode != ''>
					<tfoot>
						<tr>
							<td colspan="<if $is_apache>8<else>6</if>">{$pagingcode}</td>
						</tr>
					</tfoot>
					</if>

					<tbody>
						$ipsandports
					</tbody>
				</table>
			</form>

			<if 15 < $count>
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'ipsandports', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['ipsandports']['add']}</a>
			</div>
			</if>

		</section>

	</article>
$footer
