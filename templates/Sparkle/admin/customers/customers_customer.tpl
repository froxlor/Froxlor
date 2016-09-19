<tr <if $row['deactivated'] == 1>class="disabled"</if>>
	<td>
		<if $row['company'] != '' && $row['name'] != ''>
			{$row['company']}<br />
			<small>{$row['name']}, {$row['firstname']}</small>
		</if>
		<if $row['company'] != '' && $row['name'] == ''>
			{$row['company']}
		</if>
		<if $row['company'] == ''>
			{$row['name']}, {$row['firstname']}
		</if>
	</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'su', 'sort' => $row['loginname'], 'id' => $row['customerid']))}" rel="external">{$row['loginname']}</a>
	</td>
	<td>
		{$row['adminname']}
	</td>
	<td>
		{$last_login}
	</td>
	<td>
		<div>
			<span class="overviewcustomerextras">
				<span>Webspace:</span>
				<if $row['diskspace'] != 'UL'>
					<if (($row['diskspace']/100)*(int)Settings::Get('system.report_webmax')) < $row['diskspace_used']>
						<div class="progress progress-danger tipper" title="{$lng['panel']['used']}:<br>web: {$row['webspace_used']} {$lng['customer']['mib']}<br>mail: {$row['mailspace_used']} {$lng['customer']['mib']}<br>mysql: {$row['dbspace_used']} MiB<br><br>{$lng['panel']['assigned']}:<br>{$row['diskspace']} {$lng['customer']['mib']}">
							<div class="bar" aria-valuenow="{$disk_percent}" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					<else>
						<if (($row['diskspace']/100)*((int)Settings::Get('system.report_webmax') - 15)) < $row['diskspace_used']>
							<div class="progress progress-warn tipper" title="{$lng['panel']['used']}:<br>web: {$row['webspace_used']} {$lng['customer']['mib']}<br>mail: {$row['mailspace_used']} {$lng['customer']['mib']}<br>mysql: {$row['dbspace_used']} MiB<br><br>{$lng['panel']['assigned']}:<br>{$row['diskspace']} {$lng['customer']['mib']}">
								<div class="bar" aria-valuenow="{$disk_percent}" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						<else>
							<div class="progress tipper" title="{$lng['panel']['used']}:<br>web: {$row['webspace_used']} {$lng['customer']['mib']}<br>mail: {$row['mailspace_used']} {$lng['customer']['mib']}<br>mysql: {$row['dbspace_used']} MiB<br><br>{$lng['panel']['assigned']}:<br>{$row['diskspace']} {$lng['customer']['mib']}">
								<div class="bar" aria-valuenow="{$disk_percent}" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</if>
					</if>
				<else>
					<div class="progress">∞
							<div class="bar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</if>
			</span>
			<span class="overviewcustomerextras">
				<span>Traffic:</span>
				<if $row['traffic'] != 'UL'>
					<if (($row['traffic']/100)*(int)Settings::Get('system.report_trafficmax')) < $row['traffic_used']>
						<div class="progress progress-danger tipper" title="{$row['traffic_used']} GiB {$lng['panel']['used']}, {$row['traffic']} GiB {$lng['panel']['assigned']}">
							<div class="bar" aria-valuenow="{$traffic_percent}" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					<else>
						<if (($row['traffic']/100)*((int)Settings::Get('system.report_trafficmax') - 15)) < $row['traffic_used']>
							<div class="progress progress-warn tipper" title="{$row['traffic_used']} GiB {$lng['panel']['used']}, {$row['traffic']} GiB {$lng['panel']['assigned']}">
								<div class="bar" aria-valuenow="{$traffic_percent}" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						<else>
							<div class="progress tipper" title="{$row['traffic_used']} GiB {$lng['panel']['used']}, {$row['traffic']} GiB {$lng['panel']['assigned']}">
								<div class="bar" aria-valuenow="{$traffic_percent}" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</if>
					</if>
				<else>
					<div class="progress">∞
						<div class="bar" aria-valuenow="{$traffic_percent}" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</if>
			</span>
		</div>
	</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'edit', 'id' => $row['customerid']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" title="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'delete', 'id' => $row['customerid']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" />
		</a>
		<if $islocked == 1>
			&nbsp;<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'unlock', 'id' => $row['customerid']))}">
				<img src="templates/{$theme}/assets/img/icons/unlock.png" alt="{$lng['panel']['unlock']}" title="{$lng['panel']['unlock']}" />
			</a>
		</if>
		<if $row['custom_notes'] != ''>
			&nbsp;<img src="templates/{$theme}/assets/img/icons/info.png" class="notes" data-id="{$row['loginname']}" alt="{$lng['usersettings']['custom_notes']['title']}" title="{$lng['usersettings']['custom_notes']['title']}" />
		</if>
	</td>
</tr>
<if $row['custom_notes'] != ''>
	<tr class="notes_block" id="notes_{$row['loginname']}">
		<td colspan="6">
			{$row['custom_notes']}
		</td>
	</tr>
</if>
