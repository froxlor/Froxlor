<if $row['termination_css'] != ''>
	<tr class="{$row['termination_css']}<if $row['deactivated'] == 1> disabled</if>">
</if>
<if $row['termination_css'] == ''>
	<tr <if $row['deactivated'] == 1>class="disabled"</if>>
</if>
	<td><b>{$row['domain']}</b>
		<if (isset($row['standardsubdomain']) && $row['standardsubdomain'] == $row['id'])>
			&nbsp;({\Froxlor\I18N\Lang::getAll()['admin']['stdsubdomain']})
		</if>
		<if $row['registration_date'] != ''>
			<br><small>{\Froxlor\I18N\Lang::getAll()['domains']['registration_date']}: {$row['registration_date']}</small>
		</if>
		<if $row['termination_date'] != ''>
			<br><small><div class="red">({\Froxlor\I18N\Lang::getAll()['domains']['termination_date_overview']} {$row['termination_date']})</div></small>
		</if>
	</td>
	<td>{$row['ipandport']}</td>
	<td>{$row['customername']}&nbsp;
		<if !empty($row['loginname'])>(<a href="{$linker->getLink(array('section' => 'customers', 'page' => 'customers', 'action' => 'su', 'id' => $row['customerid']))}" rel="external">{$row['loginname']}</a>)</if>
	</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
		</a>
		<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'logfiles', 'domain_id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/view.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['viewlogs']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['viewlogs']}" />
		</a>
		<if $row['isbinddomain'] == '1' && \Froxlor\Settings::Get('system.bind_enable') == '1' && \Froxlor\Settings::Get('system.dnsenabled') == '1'>
			&nbsp;<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domaindnseditor', 'domain_id' => $row['id']))}">
				<img src="templates/{$theme}/assets/img/icons/dns_edit.png" alt="{\Froxlor\I18N\Lang::getAll()['dnseditor']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['dnseditor']['edit']}" />
			</a>
		</if>
		<if $row['letsencrypt'] == '1'>
			&nbsp;<img src="templates/{$theme}/assets/img/icons/ssl_letsencrypt.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['letsencrypt']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['letsencrypt']}" />
		</if>
		<if !(isset($row['domainaliasid']) && $row['domainaliasid'] != 0) && $row['id'] != \Froxlor\Settings::Get('system.hostname_id')>
			<if !(isset($row['standardsubdomain']) && $row['standardsubdomain'] == $row['id'])>
				&nbsp;<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}">
					<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
				</a>
			</if>
		</if>
		<if isset($row['domainaliasid']) && $row['domainaliasid'] != 0>
			&nbsp;<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'searchfield' => 'd.aliasdomain', 'searchtext' => $row['id']))}">{\Froxlor\I18N\Lang::getAll()['domains']['hasaliasdomains']}</a>
		</if>
	</td>
</tr>
