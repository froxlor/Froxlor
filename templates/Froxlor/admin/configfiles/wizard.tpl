$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings.png" alt="{$lng['admin']['configfiles']['serverconfiguration']}" />&nbsp;
				{$lng['admin']['configfiles']['serverconfiguration']} &nbsp;
				[<a href="{$linker->getLink(array('section' => 'configfiles', 'page' => 'overview'))}">{$lng['admin']['configfiles']['overview']}</a>]
			</h2>
		</header>

		<section class="fullform bradiusodd">
			<form action="$filename" method="get" enctype="application/x-www-form-urlencoded">
			<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;Wizard</legend>
						<input type="hidden" name="s" value="$s" />
						<input type="hidden" name="page" value="$page" />

						<table class="formtable">
							<tr>
								<td><b>{$lng['admin']['configfiles']['distribution']}:</b></td>
								<td><if $distribution != ''><input type="hidden" name="distribution" value="$distribution"/><a href="{$linker->getLink(array('section' => 'configfiles', 'page' => $page))}">{$configfiles[$distribution]['label']}</a><else><select id="config_distribution" name="distribution"><option value="choose">{$lng['admin']['configfiles']['choosedistribution']}</option>{$distributions_select}</select></if></td>
							</tr>
							<tr>
								<td><b>{$lng['admin']['configfiles']['service']}:</b></td>
								<td><if $service != ''><input type="hidden" name="service" value="$service"/><a href="{$linker->getLink(array('section' => 'configfiles', 'page' => $page, 'distribution' => $distribution))}">{$configfiles[$distribution]['services'][$service]['label']}</a><else><select id="config_service" name="service"><option value="choose">{$lng['admin']['configfiles']['chooseservice']}</option>{$services_select}</select></if></td>
							</tr>
							<tr>
								<td><b>{$lng['admin']['configfiles']['daemon']}:</b></td>
								<td><select id="config_daemon" name="daemon"><option value="choose">{$lng['admin']['configfiles']['choosedaemon']}</option>{$daemons_select}</select></td>
							</tr>
							<tr>
								<td><input class="bottom" type="submit" value="{$lng['panel']['next']}" /></td>
							</tr>
						</table>
			</fieldset>
			</form>
		</section>
	</article>
$footer
