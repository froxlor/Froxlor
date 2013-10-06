<tr <if $row['deactivated'] == 1>class="disabled"</if>>
	<td>
		<strong>
		<if $row['name'] != '' && $row['firstname'] != ''>
			{$row['name']}&nbsp;{$row['firstname']}
		</if>
		<if ($row['name'] == '' || $row['firstname'] == '') && $row['company'] != ''>
			{$row['company']}
		</if>
		</strong>
	</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'su', 'id' => $row['customerid']))}" rel="external">{$row['loginname']}</a>
	</td>
	<td>
		{$row['adminname']}
	</td>
	<td>
		{$last_login}
	</td>
	<td>
		<span class="overviewcustomerextras">
			Webspace:&nbsp;
			<if $row['diskspace'] != 'UL'>
				<span class="progressBar" title="{$row['diskspace_used']} / {$row['diskspace']} MB">
					<if (($row['diskspace']/100)*(int)$settings['system']['report_webmax']) < $row['diskspace_used']>
						<span class="redbar">
					<else>
						<span>
					</if>
					<em style="left: {$disk_doublepercent}px;">{$disk_percent}%</em></span>
				</span>
			<else>
				<span class="progressBar" title="{$lng['customer']['unlimited']}">
					<span class="greybar"><em style="left: 200px;">100%</em></span>
				</span>
			</if>
		</span><br />
		<span class="overviewcustomerextras">
			Traffic:&nbsp;
			<if $row['traffic'] != 'UL'>
				<span class="progressBar" title="{$row['traffic_used']} / {$row['traffic']} GB">
					<if (($row['traffic']/100)*(int)$settings['system']['report_trafficmax']) < $row['traffic_used']>
						<span class="redbar">
					<else>
						<span>
					</if>
					<em style="left: {$traffic_doublepercent}px;">{$traffic_percent}%</em></span>
				</span>
			<else>
				<span class="progressBar" title="{$lng['customer']['unlimited']}">
					<span class="greybar"><em style="left: 200px;">100%</em></span>
				</span>
			</if>
		</span>
	</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'edit', 'id' => $row['customerid']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'delete', 'id' => $row['customerid']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>&nbsp;
		<if $islocked == 1>
		<a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'unlock', 'id' => $row['customerid']))}">
			<img src="templates/{$theme}/assets/img/icons/unlock.png" alt="{$lng['panel']['unlock']}" />
		</a>
		</if>
	</td>
</tr>
