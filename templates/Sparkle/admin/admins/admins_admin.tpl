<tr>
	<td>
		{$row['name']}
	</td>
	<td>
		<if $row['adminid'] != \Froxlor\User::getAll()['userid']>
		<a href="{$linker->getLink(array('section' => 'admins', 'page' => $page, 'action' => 'su', 'id' => $row['adminid']))}" rel="external">{$row['loginname']}</a>
		</if>
		<if $row['adminid'] == \Froxlor\User::getAll()['userid']>
		{$row['loginname']}
		</if>
	</td>
	<td>
		{$row['customers_used']}
	</td>
	<td>
		<div>
			<span class="overviewcustomerextras">
				<span>Webspace:</span>
				<if $row['diskspace'] != 'UL'>
					<if (($row['diskspace']/100)*(int)\Froxlor\Settings::Get('system.report_webmax')) < $row['diskspace_used']>
						<div class="progress progress-danger tipper" title="{$row['diskspace_used']} MiB {\Froxlor\I18N\Lang::getAll()['panel']['used']}, {$row['diskspace']} MiB {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}">
							<div class="bar" aria-valuenow="{$disk_percent}" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					<else>
						<if (($row['diskspace']/100)*((int)\Froxlor\Settings::Get('system.report_webmax') - 15)) < $row['diskspace_used']>
							<div class="progress progress-warn tipper" title="{$row['diskspace_used']} MiB {\Froxlor\I18N\Lang::getAll()['panel']['used']}, {$row['diskspace']} MiB {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}">
								<div class="bar" aria-valuenow="{$disk_percent}" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						<else>
							<div class="progress tipper" title="{$row['diskspace_used']} MiB {\Froxlor\I18N\Lang::getAll()['panel']['used']}, {$row['diskspace']} MiB {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}">
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
					<if (($row['traffic']/100)*(int)\Froxlor\Settings::Get('system.report_trafficmax')) < $row['traffic_used']>
						<div class="progress progress-danger tipper" title="{$row['traffic_used']} GiB {\Froxlor\I18N\Lang::getAll()['panel']['used']}, {$row['traffic']} GiB {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}">
							<div class="bar" aria-valuenow="{$traffic_percent}" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					<else>
						<if (($row['traffic']/100)*((int)\Froxlor\Settings::Get('system.report_trafficmax') - 15)) < $row['traffic_used']>
							<div class="progress progress-warn tipper" title="{$row['traffic_used']} GiB {\Froxlor\I18N\Lang::getAll()['panel']['used']}, {$row['traffic']} GiB {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}">
								<div class="bar" aria-valuenow="{$traffic_percent}" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						<else>
							<div class="progress tipper" title="{$row['traffic_used']} GiB {\Froxlor\I18N\Lang::getAll()['panel']['used']}, {$row['traffic']} GiB {\Froxlor\I18N\Lang::getAll()['panel']['assigned']}">
								<div class="bar" aria-valuenow="{$traffic_percent}" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</if>
					</if>
				<else>
					<div class="progress">∞
						<div class="bar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</if>
			</span>
		</div>
	</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'admins', 'page' => $page, 'action' => 'edit', 'id' => $row['adminid']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'admins', 'page' => $page, 'action' => 'delete', 'id' => $row['adminid']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
		</a>
		<if $row['custom_notes'] != ''>
			&nbsp;<img src="templates/{$theme}/assets/img/icons/info.png" class="notes" data-id="{$row['loginname']}" alt="{\Froxlor\I18N\Lang::getAll()['usersettings']['custom_notes']['title']}" title="{\Froxlor\I18N\Lang::getAll()['usersettings']['custom_notes']['title']}" />
		</if>
	</td>
</tr>
<if $row['custom_notes'] != ''>
	<tr class="notes_block" id="notes_{$row['loginname']}">
		<td colspan="5">
			{$row['custom_notes']}
		</td>
	</tr>
</if>
