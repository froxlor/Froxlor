$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/phpsettings.png" alt="" />&nbsp;
				{$lng['menue']['phpsettings']['maintitle']}
			</h2>
		</header>

		<section>

			<if 15 < $count>
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/phpsettings_add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['phpsettings']['addnew']}</a>
			</div>
			</if>

			<table class="bradiusodd">
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

			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/phpsettings_add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['phpsettings']['addnew']}</a>
			</div>

		</section>

	</article>
$footer
