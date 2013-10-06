 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/htaccess.png" alt="" />&nbsp;
				{$lng['menue']['extras']['pathoptions']}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'extras'))}" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if 15 < $count >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/htaccess_add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htaccess', 'action' => 'add'))}">{$lng['extras']['pathoptions_add']}</a>
				</div>
			</if>

			<table class="bradiusodd" id="sortable">
				<thead>
					<tr>
						<th>{$lng['panel']['path']}</th>
						<th>{$lng['extras']['view_directory']}</th>
						<th>{$lng['extras']['error404path']}</th>
						<th>{$lng['extras']['error403path']}</th>
						<th>{$lng['extras']['error500path']}</th>
						<if $cperlenabled == 1 >
						<th>{$lng['extras']['execute_perl']}</th>
						</if>
						<th class="nosort">{$lng['panel']['options']}</th>
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
					{$htaccess}
				</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
			</p>

			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/htaccess_add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htaccess', 'action' => 'add'))}">{$lng['extras']['pathoptions_add']}</a>
			</div>

		</section>
	</article>
$footer

