$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/templates_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['admin']['templates']['email']}
			</h2>
		</header>

		<section>
			<h3>
				{\Froxlor\I18N\Lang::getAll()['admin']['templates']['templates']}
			</h3>
			<if $add>
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['templates']['template_add']}</a>
				</div>
			</if>
		
			<table class="full hl">
			<thead>
				<tr>
					<th>{\Froxlor\I18N\Lang::getAll()['login']['language']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['action']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['panel']['options']}</th>
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
				{\Froxlor\I18N\Lang::getAll()['admin']['templates']['filetemplates']}
			</h3>
			<if $filetemplateadd>
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'add', 'files' => 'files'))}">{\Froxlor\I18N\Lang::getAll()['admin']['templates']['template_add']}</a>
				</div>
			</if>
			
			<table class="full hl">
			<thead>
				<tr>
					<th>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['action']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['panel']['options']}</th>
				</tr>
			</thead>
			<tbody>
				{$filetemplates}
			</tbody>
			</table>
		</section>

	</article>
$footer
