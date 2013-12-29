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
						<div class="progress progress-danger tipper" title="{$row['diskspace_used']} MiB {$lng['panel']['used']}, {$row['diskspace']} MiB {$lng['panel']['assigned']}">
							<div class="bar" style="width: {$disk_percent}%"></div>
						</div>
					<else>
						<div class="progress tipper" title="{$row['diskspace_used']} MiB {$lng['panel']['used']}, {$row['diskspace']} MiB {$lng['panel']['assigned']}">
							<div class="bar" style="width: {$disk_percent}%"></div>
						</div>
					</if>
				<else>
					<div class="progress">∞
							<div class="bar" style="width: 0%"></div>
					</div>
				</if>
			</span>
			<span class="overviewcustomerextras">
				<span>Traffic:</span>
				<if $row['traffic'] != 'UL'>
					<if (($row['traffic']/100)*(int)Settings::Get('system.report_trafficmax')) < $row['traffic_used']>
						<div class="progress progress-danger tipper" title="{$row['traffic_used']} GiB {$lng['panel']['used']}, {$row['traffic']} GiB {$lng['panel']['assigned']}">
							<div class="bar" style="width: {$traffic_percent}%"></div>
						</div>
					<else>
						<div class="progress tipper" title="{$row['traffic_used']} GiB {$lng['panel']['used']}, {$row['traffic']} GiB {$lng['panel']['assigned']}">
							<div class="bar" style="width: {$traffic_percent}%"></div>
						</div>
					</if>
				<else>
					<div class="progress">∞
						<div class="bar" style="width: 0%"></div>
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
		</a>&nbsp;
		<if $islocked == 1>
		<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'unlock', 'id' => $row['customerid']))}">
			<img src="templates/{$theme}/assets/img/icons/unlock.png" alt="{$lng['panel']['unlock']}" title="{$lng['panel']['unlock']}" />
		</a>
		</if>
	</td>

</tr>
