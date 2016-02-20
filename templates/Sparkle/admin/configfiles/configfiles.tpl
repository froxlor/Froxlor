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
				<p>{$lng['admin']['configfiles']['legend']}</p><br />
				<p>
					{$lng['admin']['configfiles']['commands']}<br />
					<textarea class="shell" rows="2" readonly>
chmod u+x example-script.sh
./example-script.sh</textarea>
				</p><br />
				<p>
					{$lng['admin']['configfiles']['files']}<br />
					<textarea class="filecontent" rows="5">Lorem ipsum dolor sit amet,
consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt
ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero
eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren,
no sea takimata sanctus est Lorem ipsum dolor sit amet.</textarea>
				</p>
				<form id="configfiles_setmysqlpw" action="#">
					MYSQL_PASSWORD: <input type="text" class="text" id="configfiles_mysqlpw" name="configfiles_mysqlpw" value="" />
					<input type="submit" value="{$lng['panel']['set']}" />
				</form>
			</div>
		</section>

		<section>
			{$configpage}
		</section>
</article>
$footer
