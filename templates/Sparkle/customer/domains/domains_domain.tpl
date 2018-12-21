<if $row['termination_date'] != ''>
	<tr class="{$row['termination_css']}">
</if>
<if $row['termination_date'] == ''>
	<tr>
</if>
	<td>
		<a href="http://{$row['domain']}" target="_blank"><b>{$row['domain']}</b></a>
		<if $row['registration_date'] != ''>
			<br><small>{\Froxlor\I18N\Lang::getAll()['domains']['registration_date']}: {$row['registration_date']}</small>
		</if>
		<if $row['termination_date'] != ''>
			<br><small><div class="red">({\Froxlor\I18N\Lang::getAll()['domains']['termination_date_overview']} {$row['termination_date']})</div></small>
		</if>
	</td>
	<td>
		<if $row['aliasdomain'] == ''>{$row['documentroot']}</if>
		<if isset($row['aliasdomainid']) && $row['aliasdomainid'] != 0>{\Froxlor\I18N\Lang::getAll()['domains']['aliasdomain']} {$row['aliasdomain']}</if>
	</td>
	<td>
		<if $row['caneditdomain'] == '1'>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'edit', 'id' => $row['id']))}">
				<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
			</a>&nbsp;
		</if>
		<if \Froxlor\User::getAll()['logviewenabled'] == '1'>
		<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'logfiles', 'domain_id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/view.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['viewlogs']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['viewlogs']}" />
		</a>
		</if>
		<if $row['parentdomainid'] != '0' && !(isset($row['domainaliasid']) && $row['domainaliasid'] != 0)>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'delete', 'id' => $row['id']))}">
				<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
			</a>&nbsp;
		</if>
		<if $row['isbinddomain'] == '1' && \Froxlor\User::getAll()['dnsenabled'] == '1' && $row['caneditdomain'] == '1' && \Froxlor\Settings::Get('system.bind_enable') == '1' && \Froxlor\Settings::Get('system.dnsenabled') == '1'>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domaindnseditor', 'domain_id' => $row['id']))}">
				<img src="templates/{$theme}/assets/img/icons/dns_edit.png" alt="{\Froxlor\I18N\Lang::getAll()['dnseditor']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['dnseditor']['edit']}" />
			</a>&nbsp;
		</if>
		<if $show_ssledit == 1>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domainssleditor', 'action' => 'view', 'id' => $row['id']))}">
				<img src="templates/{$theme}/assets/img/icons/ssl_<if $row['domain_hascert'] == 1>customer</if><if $row['domain_hascert'] == 2>shared</if><if $row['domain_hascert'] == 0>global</if>.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['ssleditor']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['ssleditor']}" />
			</a>&nbsp;
		</if>
		<if $row['letsencrypt'] == '1'>
			<img src="templates/{$theme}/assets/img/icons/ssl_letsencrypt.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['letsencrypt']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['letsencrypt']}" />
		</if>
		<if $row['parentdomainid'] == '0' && !(isset($row['domainaliasid']) && $row['domainaliasid'] != 0)>
			({\Froxlor\I18N\Lang::getAll()['domains']['isassigneddomain']})&nbsp;
		</if>
		<if isset($row['domainaliasid']) && $row['domainaliasid'] != 0>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'searchfield' => 'd.aliasdomain', 'searchtext' => $row['id']))}">{\Froxlor\I18N\Lang::getAll()['domains']['hasaliasdomains']}</a>
		</if>
	</td>
</tr>
