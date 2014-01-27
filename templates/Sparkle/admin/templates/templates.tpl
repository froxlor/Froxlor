$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/templates_big.png" alt="" />&nbsp;
				{$lng['admin']['templates']['email']}
			</h2>
		</header>

		<section>
			<h3>
				{$lng['admin']['templates']['templates']}
			</h3>
			<if $add>
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['templates']['template_add']}</a>
				</div>
			</if>
		
			<table class="full hl">
			<thead>
				<tr>
					<th>{$lng['login']['language']}</th>
					<th>{$lng['admin']['templates']['action']}</th>
					<th>{$lng['panel']['options']}</th>
				</tr>
			</thead>
			<tbody>
				{$templates}
			</tbody>
			</table>
		</section>
		<br />
		<br />
		<section>
			<h3>
				{$lng['admin']['templates']['filetemplates']}
			</h3>
			<if $filetemplateadd>
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'add', 'files' => 'files'))}">{$lng['admin']['templates']['template_add']}</a>
				</div>
			</if>
			
			<table class="full hl">
			<thead>
				<tr>
					<th>{$lng['admin']['templates']['action']}</th>
					<th>{$lng['panel']['options']}</th>
				</tr>
			</thead>
			<tbody>
				{$filetemplates}
			</tbody>
			</table>
		</section>

	</article>
$footer
