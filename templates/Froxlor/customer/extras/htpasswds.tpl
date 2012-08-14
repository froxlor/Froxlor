 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/htpasswd.png" alt="" />&nbsp;
				{$lng['menue']['extras']['directoryprotection']}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'extras'))}" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if 15 < $count >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/htpasswd_add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htpasswds', 'action' => 'add'))}">{$lng['extras']['directoryprotection_add']}</a>
				</div>
			</if>

			<table class="bradiusodd">
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
							<td>{$pagingcode}</td>
						</tr>
					</tfoot>
				</if>
				<tbody>
					{$htpasswds}
				</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
			</p>

			</form>

			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/htpasswd_add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htpasswds', 'action' => 'add'))}">{$lng['extras']['directoryprotection_add']}</a>
			</div>

		</section>
	</article>
$footer

