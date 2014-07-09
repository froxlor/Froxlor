$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/phpsettings_big.png" alt="" />&nbsp;
				{$lng['menue']['phpsettings']['maintitle']}
			</h2>
		</header>

		<section>

			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['phpsettings']['addnew']}</a>
			</div>

			<table class="full hl">
				<thead>
					<tr>
						<th>{$lng['admin']['phpsettings']['description']}</th>
						<th>{$lng['admin']['phpsettings']['activedomains']}</th>
						<th>{$lng['admin']['phpsettings']['binary']}</th>
						<th>{$lng['admin']['phpsettings']['file_extensions']}</th>
						<th>{$lng['panel']['options']}</th>
				</thead>
				<tbody>
					$tablecontent
				</tbody>
			</table>
			
			<if 15 < $count>
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['phpsettings']['addnew']}</a>
				</div>
			</if>

		</section>

	</article>
$footer
