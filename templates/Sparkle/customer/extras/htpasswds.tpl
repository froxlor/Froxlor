 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/htpasswd_big.png" alt="" />&nbsp;
				{$lng['menue']['extras']['directoryprotection']}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'extras'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />

				<div class="overviewsearch">
					{$searchcode}
				</div>

				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htpasswds', 'action' => 'add'))}">{$lng['extras']['directoryprotection_add']}</a>
				</div>

				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['login']['username']}&nbsp;{$arrowcode['username']}</th>
							<th>{$lng['panel']['path']}&nbsp;{$arrowcode['path']}</th>
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
						{$htpasswds}
					</tbody>
				</table>

			</form>
			
			<if 15 < $count >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htpasswds', 'action' => 'add'))}">{$lng['extras']['directoryprotection_add']}</a>
			</div>
			</if>
			
		</section>
	</article>
$footer

