$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/ipsports.png" alt="" />&nbsp;
				{$lng['admin']['ipsandports']['ipsandports']}
			</h2>
		</header>

		<section>
			
			<form action="{$linker->getLink(array('section' => 'ipsandports'))}" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if 15 < $count>
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/ipsports_add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'ipsandports', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['ipsandports']['add']}</a>
			</div>
			</if>

			<table class="bradiusodd">
			<thead>
				<tr>
					<th>{$lng['admin']['ipsandports']['ip']}&nbsp;{$arrowcode['ip']}&nbsp;:&nbsp;{$lng['admin']['ipsandports']['port']}&nbsp;{$arrowcode['port']}</th>
					<th>Listen</th>
					<th>NameVirtualHost</th>
					<th>vHost-Container</th>
					<th>Specialsettings</th>
					<th>ServerName</th>
					<th>SSL</th>
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
				$ipsandports
			</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
			</p>

			</form>

			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/ipsports_add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'ipsandports', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['ipsandports']['add']}</a>
			</div>

		</section>

	</article>
$footer
