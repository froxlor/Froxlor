<if $row['termination_date'] != ''>
	<tr class="{$row['termination_css']}">
</if>
<if $row['termination_date'] == ''>
	<tr>
</if>
	<td>
		<a href="http://{$row['domain']}" target="_blank"><b>{$row['domain']}</b></a>
		<if $row['registration_date'] != ''>
			<br><small>{$lng['domains']['registration_date']}: {$row['registration_date']}</small>
		</if>
		<if $row['termination_date'] != ''>
			<br><small><div class="red">({$lng['domains']['termination_date_overview']} {$row['termination_date']})</div></small>
		</if>
	</td>
	<td>
		<if $row['aliasdomain'] == ''>{$row['documentroot']}</if>
		<if isset($row['aliasdomainid']) && $row['aliasdomainid'] != 0>{$lng['domains']['aliasdomain']} {$row['aliasdomain']}</if>
	</td>
	<td>
		<if $row['caneditdomain'] == '1'>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'edit', 'id' => $row['id']))}">
				<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" title="{$lng['panel']['edit']}" />
			</a>&nbsp;
		</if>
		<if $userinfo['logviewenabled'] == '1'>
		<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'logfiles', 'domain_id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/view.png" alt="{$lng['panel']['viewlogs']}" title="{$lng['panel']['viewlogs']}" />
		</a>
		</if>
		<if $row['parentdomainid'] != '0' && !(isset($row['domainaliasid']) && $row['domainaliasid'] != 0)>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'delete', 'id' => $row['id']))}">
				<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" />
			</a>&nbsp;
		</if>
		<if $row['isbinddomain'] == '1' && $userinfo['dnsenabled'] == '1' && $row['caneditdomain'] == '1' && Settings::Get('system.bind_enable') == '1' && Settings::Get('system.dnsenabled') == '1'>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domaindnseditor', 'domain_id' => $row['id']))}">
				<img src="templates/{$theme}/assets/img/icons/dns_edit.png" alt="{$lng['dnseditor']['edit']}" title="{$lng['dnseditor']['edit']}" />
			</a>&nbsp;
		</if>
		<if $show_ssledit == 1>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domainssleditor', 'action' => 'view', 'id' => $row['id']))}">
				<img src="templates/{$theme}/assets/img/icons/ssl_<if $row['domain_hascert'] == 1>customer</if><if $row['domain_hascert'] == 2>shared</if><if $row['domain_hascert'] == 0>global</if>.png" alt="{$lng['panel']['ssleditor']}" title="{$lng['panel']['ssleditor']}" />
			</a>&nbsp;
		</if>
		<if $row['letsencrypt'] == '1'>
			<img src="templates/{$theme}/assets/img/icons/ssl_letsencrypt.png" alt="{$lng['panel']['letsencrypt']}" title="{$lng['panel']['letsencrypt']}" />
		</if>
		<if $row['parentdomainid'] == '0' && !(isset($row['domainaliasid']) && $row['domainaliasid'] != 0)>
			({$lng['domains']['isassigneddomain']})&nbsp;
		</if>
		<if isset($row['domainaliasid']) && $row['domainaliasid'] != 0>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'searchfield' => 'd.aliasdomain', 'searchtext' => $row['id']))}">{$lng['domains']['hasaliasdomains']}</a>
		</if>
	</td>
</tr>
