<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/aps.png" alt="{$Xml->name}" />&nbsp;
			{$Xml->name}
		</h2>
	</header>
	
	<section class="fullform bradiusodd">

				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;</legend>

					<table class="formtable">
						<tr>
							<td colspan="2"><strong>$Summary</strong></td>
							<td style="text-align: center; padding: 10px; background-color:#FFFFFF;"><img src="{$Icon}" alt="{$Xml->name} Icon"/></td>
						</tr>
						<tr>
							<td colspan="3"><strong>{$lng['aps']['data']}</strong></td>
						</tr>
						$Data
						<tr>
							<td colspan="3">
							<if $action == 'overview' || $action == 'search'>
								<form method="get" action="$filename" style="float:left;">
									<input type="hidden" name="s" value="$s" />
									<input type="hidden" name="page" value="$page" />
									<input type="hidden" name="action" value="details" />
									<input type="hidden" name="id" value="{$Row['ID']}" />
									<input class="bottom" type="submit" value="{$lng['aps']['detail']}" />
								</form>
							</if>
							<if $action != 'overview' && $action !='search' && $action != 'customerstatus'>
								<form method="get" action="$filename" style="float:left;">
									<input type="hidden" name="s" value="$s" />
									<input type="hidden" name="page" value="$page" />
									<input type="hidden" name="action" value="overview" />
									<input class="bottom" type="submit" value="{$lng['aps']['back']}" />
								</form>
							</if>
							<if $action != 'customerstatus' && ( $userinfo['aps_packages'] != $userinfo['aps_packages_used'] ) && $db_info == ''>
								<form method="get" action="$filename" style="float:left; padding-left: 5px;">
									<input type="hidden" name="s" value="$s" />
									<input type="hidden" name="page" value="$page" />
									<input type="hidden" name="action" value="install" />
									<input type="hidden" name="id" value="{$Row['ID']}" />
									<input class="bottom" type="submit" value="{$lng['aps']['install']}" />
								</form>
							</if>
							<if $db_info != ''>
								<span style="padding-left: 5px;">{$db_info}</span>
							</if>
							<if ($action == 'customerstatus') && ($Row['Status'] == 2 || $Row['Status'] == 3)>
								<form method="get" action="$filename" style="float:left;">
									<input type="hidden" name="s" value="$s" />
									<input type="hidden" name="page" value="$page" />
									<input type="hidden" name="action" value="remove" />
									<input type="hidden" name="id" value="{$Row['ID']}" />
									<input class="bottom" type="submit" value="{$lng['aps']['uninstall']}" />
								</form>
							</if>
							</td>
						</tr>
					</table>
				</fieldset>
	</section>
</article>
