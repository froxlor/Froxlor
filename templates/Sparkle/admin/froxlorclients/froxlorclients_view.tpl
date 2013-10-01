$header
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<input type="hidden" name="id" value="$id"/>
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="4"><b><img src="templates/${theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['menue']['multiserver']['clients']}&nbsp;"{$client->Get('name')}"</b></td>
			</tr>
			<tr>
				<td class="field_name_border_left">
					<img src="templates/{$theme}/assets/img/multiserver/server.png" alt="Client #{$row['id']}" style="border:0;" />
				</td>
				<td class="field_display" colspan="3">
					<h3>Froxlor-client "{$client->Get('name')}"</h3>
					<p>{$client->Get('desc')}</p>
				</td>
			</tr>
			<tr>
				<td class="field_name_border_left" colspan="4" style="text-align:right;">
					<if $client_enabled ==1>
					<a href="$filename?s=$s&amp;page=$page&amp;action=settings&amp;id={$id}" title="{$lng['admin']['froxlorclients']['settings']}">
						<img src="templates/{$theme}/assets/img/multiserver/settings.png" alt="{$lng['admin']['froxlorclients']['settings']}" style="border:0;" />
					</a>&nbsp;
					<a href="$filename?s=$s&amp;page=$page&amp;action=deploy&amp;id={$id}" title="{$lng['admin']['froxlorclients']['deploy']}">
						<img src="templates/{$theme}/assets/img/multiserver/deploy.png" alt="{$lng['admin']['froxlorclients']['deploy']}" style="border:0;" />
					</a>&nbsp;
					<else>
						<img src="templates/{$theme}/assets/img/multiserver/settings_dis.png" alt="{$lng['admin']['froxlorclients']['settings']} :: {$lng['admin']['froxlorclients']['clientdisabled']}" style="border:0;" />&nbsp;
						<img src="templates/{$theme}/assets/img/multiserver/deploy_dis.png" alt="{$lng['admin']['froxlorclients']['deploy']} :: {$lng['admin']['froxlorclients']['clientdisabled']}" style="border:0;" />
					</if>
					<a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$id}" title="{$lng['panel']['edit']}">
						<img src="templates/{$theme}/assets/img/multiserver/edit.png" alt="{$lng['panel']['edit']}" style="border:0;" />
					</a>&nbsp;
					<a href="$filename?s=$s&amp;page=$page&amp;action=delete&amp;id={$id}" title="{$lng['panel']['delete']}">
						<img src="templates/{$theme}/assets/img/multiserver/trash.png" alt="{$lng['panel']['delete']}" style="border:0;" />
					</a>
				</td>
			</tr>
		</table>
		<br /><br />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><strong>{$lng['froxlorclient']['base_config']}</strong></td>
			</tr>
			<if $client_enabled ==1>
			<tr>
				<td class="field_name_border_left" colspan="2" style="text-align:right;">
					{$lastrefresh}
					<if $refreshactive >
					<a href="$filename?s=$s&amp;page=$page&amp;action=refreshsysinfo&amp;id={$id}" title="{$lng['admin']['froxlorclients']['refreshsysinfo']}">
						<img src="templates/{$theme}/assets/img/multiserver/refresh.png" alt="{$lng['admin']['froxlorclients']['refreshsysinfo']}" style="border:0;" />
					</a>
					<else>
						<img src="templates/{$theme}/assets/img/multiserver/refresh_dis.png" alt="{$lastrefresh}" style="border:0;" />
					</if>
				</td>
			</tr>
			</if>
			<tr>
				<td class="field_name_border_left">{$lng['froxlorclient']['ipaddress']}:</td>
				<td class="field_display">{$client->getSetting('client', 'ipaddress')}</td>
			</tr>
			<tr>
				<td class="field_name_border_left">{$lng['froxlorclient']['hostname']}:</td>
				<td class="field_display">{$client->getSetting('client', 'hostname')}</td>
			</tr>
			<tr>
				<td class="field_name_border_left">{$lng['froxlorclient']['install_destination']}:</td>
				<td class="field_display">{$client->getSetting('client', 'install_destination')}</td>
			</tr>
			$info
		</table>
	</form>
	<br />
	<br />
$footer
