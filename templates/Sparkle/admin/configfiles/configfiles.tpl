$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings_big.png" alt="" />&nbsp;
				{$dist_display}&nbsp;&raquo;&nbsp;
				{$services[$service]->title}&nbsp;&raquo;&nbsp;
				{$daemons[$daemon]->title}&nbsp;[<a href="{$linker->getLink(array('section' => 'configfiles', 'page' => $page, 'distribution' => $distribution, 'service' => $service))}">{$lng['panel']['back']}</a>]
			</h2>
		</header>

		<section>
			<div class="info">
				<p>{$lng['admin']['configfiles']['legend']}</p>
				<p>{$lng['admin']['configfiles']['commands']}</p>
				<p>{$lng['admin']['configfiles']['files']}</p>
				<p>
				<form id="configfiles_setmysqlpw" action="#">
					FROXLOR_MYSQL_PASSWORD: <input type="text" class="text" id="configfiles_mysqlpw" name="configfiles_mysqlpw" value="" />
					<input type="submit" value="{$lng['panel']['set']}" />
				</form>
				</p>
			</div>
		</section>

		<section>
			{$configpage}
		</section>
</article>
$footer
