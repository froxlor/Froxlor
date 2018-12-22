$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings_big.png" alt="{$lng['admin']['configfiles']['serverconfiguration']}" />&nbsp;
				{$lng['admin']['configfiles']['serverconfiguration']} &nbsp;
				[<a href="{$linker->getLink(array('section' => 'configfiles', 'page' => 'overview'))}">{$lng['admin']['configfiles']['overview']}</a>]
			</h2>
		</header>

		<div class="messagewrapperfull">
		<div class="warningcontainer bradius">
			<div class="warningtitle">{$lng['admin']['warning']}</div>
			<div class="warning">{$lng['panel']['settings_before_configuration']}</div>
		</div>
		</div>

		<section>
			<form action="$filename" method="get" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<input type="hidden" name="s" value="$s" />
					<input type="hidden" name="page" value="$page" />

					<table class="tiny center">
						<tr>
							<td><b>{$lng['admin']['configfiles']['distribution']}:</b></td>
							<td>
								<if $distribution != ''>
									<input type="hidden" name="distribution" value="$distribution"/>
									<a href="{$linker->getLink(array('section' => 'configfiles', 'page' => $page))}">{$dist_display}</a>
								<else>
									<select id="config_distribution" name="distribution">
										<option value="choose">{$lng['admin']['configfiles']['choosedistribution']}</option>
										{$distributions_select}
									</select>
								</if>
							</td>
						</tr>
						<tr>
							<td><b>{$lng['admin']['configfiles']['service']}:</b></td>
							<td>
								<if $service != ''>
									<input type="hidden" name="service" value="$service"/>
									<a href="{$linker->getLink(array('section' => 'configfiles', 'page' => $page, 'distribution' => $distribution))}">{$services[$service]->title}</a>
								<else>
									<select id="config_service" name="service">
										<option value="choose">{$lng['admin']['configfiles']['chooseservice']}</option>
										{$services_select}
									</select>
								</if>
							</td>
						</tr>
						<tr>
							<td><b>{$lng['admin']['configfiles']['daemon']}:</b></td>
							<td><select id="config_daemon" name="daemon"><option value="choose">{$lng['admin']['configfiles']['choosedaemon']}</option>{$daemons_select}</select></td>
						</tr>
						<tfoot>
							<tr>
								<td colspan="2" align="center"><input class="bottom" type="submit" value="{$lng['panel']['next']}" /></td>
							</tr>
							<tr>
								<if \Froxlor\Settings::Get('panel.is_configured') == '0'>
								<td colspan="2" align="center">{$lng['panel']['done_configuring']}:<br><br><a href="{$linker->getLink(array('section' => 'configfiles', 'page' => 'overview', 'action' => 'setconfigured'))}" class="btnlink">{$lng['panel']['ihave_configured']}</a><br><br></td>
								<else>
								<td colspan="2" align="center">{$lng['panel']['system_is_configured']}</td>
								</if>
							</tr>
						</tfoot>
					</table>
				</fieldset>	
			</form>
		</section>

		<br><br><br>
		<section>
		<p><strong>{$lng['panel']['alternative_cmdline_config']}:</strong></p>
			<div class="pushbot">
				<textarea class="shell" rows="2" readonly>php {$basedir}/install/scripts/config-services.php --froxlor-dir={$basedir} --create</textarea>
			</div>
		</section>
	</article>
$footer
