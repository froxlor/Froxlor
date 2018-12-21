$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings_big.png" alt="" />&nbsp;
				{$dist_display}&nbsp;&raquo;&nbsp;
				{$services[$service]->title}&nbsp;&raquo;&nbsp;
				{$daemons[$daemon]->title}&nbsp;[<a href="{$linker->getLink(array('section' => 'configfiles', 'page' => $page, 'distribution' => $distribution, 'service' => $service))}">{\Froxlor\I18N\Lang::getAll()['panel']['back']}</a>]
			</h2>
		</header>

		<section>
			<div class="info">
				<p>{\Froxlor\I18N\Lang::getAll()['admin']['configfiles']['legend']}</p>
				<p>{\Froxlor\I18N\Lang::getAll()['admin']['configfiles']['commands']}</p>
				<p>{\Froxlor\I18N\Lang::getAll()['admin']['configfiles']['files']}</p>
				<p>
				<form id="configfiles_setmysqlpw" action="#">
					FROXLOR_MYSQL_PASSWORD: <input type="text" class="text" id="configfiles_mysqlpw" name="configfiles_mysqlpw" value="" />
					<input type="submit" value="{\Froxlor\I18N\Lang::getAll()['panel']['set']}" />
				</form>
				</p>
			</div>
		</section>

		<section>
			{$configpage}
		</section>
</article>
$footer
