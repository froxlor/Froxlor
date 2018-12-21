$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/phpsettings_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['menue']['phpsettings']['fpmdaemons']}
			</h2>
		</header>

		<section>

			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['addnew']}</a>
			</div>

			<table class="full hl">
				<thead>
					<tr>
						<th>{\Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['description']}</th>
						<th>{\Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['activephpconfigs']}</th>
						<th>{\Froxlor\I18N\Lang::getAll()['serversettings']['phpfpm_settings']['reload']}</th>
						<th>{\Froxlor\I18N\Lang::getAll()['serversettings']['phpfpm_settings']['configdir']}</th>
						<th>{\Froxlor\I18N\Lang::getAll()['serversettings']['phpfpm_settings']['pm']}</th>
						<th>{\Froxlor\I18N\Lang::getAll()['panel']['options']}</th>
				</thead>
				<tbody>
					$tablecontent
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
