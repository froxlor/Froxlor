$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings_big.png" alt="{$lng['admin']['configfiles']['serverconfiguration']}" />&nbsp;
				{$lng['admin']['configfiles']['serverconfiguration']} &nbsp;
				[<a href="{$linker->getLink(array('section' => 'configfiles', 'page' => 'overview'))}">{$lng['admin']['configfiles']['overview']}</a>]
			</h2>
		</header>

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
						</tfoot>
					</table>
				</fieldset>	
			</form>
		</section>
	</article>
$footer
