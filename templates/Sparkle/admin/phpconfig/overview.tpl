$header
<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/phpsettings_big.png"
				alt="" />&nbsp; {\Froxlor\I18N\Lang::getAll()['menue']['phpsettings']['maintitle']}
		</h2>
	</header>

	<section>

		<div class="overviewadd">
			<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
			<a
				href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['addnew']}</a>
		</div>

		<table class="full hl">
			<thead>
				<tr>
					<th>{\Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['description']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['activedomains']}</th>
					<if \Froxlor\Settings::Get('phpfpm.enabled') == '1'>
					<th>{\Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['fpmdesc']}</th>
					<else>
					<th>{\Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['binary']}</th></if>
					<th>{\Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['file_extensions']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['panel']['options']}</th>
			</thead>
			<tbody>$tablecontent
			</tbody>
		</table>

		<if 15 < $count>
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['addnew']}</a>
				</div>
			</if>

		</section>

</article>
$footer
