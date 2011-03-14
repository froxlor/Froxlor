<tr>
	<td>
		<strong>
		{$row['name']}
		<if $row['adminid'] != $userinfo['userid']>
		&nbsp;(<a href="$filename?s=$s&amp;page=$page&amp;action=su&amp;id={$row['adminid']}" rel="external">{$row['loginname']}</a>)
		</if>
		<if $row['adminid'] == $userinfo['userid']>
		&nbsp;({$row['loginname']})
		</if>
		</strong>
		<div>
			<span class="overviewcustomerextras">
				Webspace:&nbsp;
				<if $row['diskspace'] != 'UL'>
					<span class="progressBar" title="{$row['diskspace_used']} / {$row['diskspace']} MB">
						<if (($row['diskspace']/100)*(int)$settings['system']['report_webmax']) < $row['diskspace_used']>
							<span class="redbar">
						<else>
							<span>
						</if>
						<em style="left: {$doublepercent}px;">{$percent}%</em></span>
					</span>
				<else>
					<span class="progressBar" title="{$lng['customer']['unlimited']}">
						<span class="greybar"><em style="left: 200px;">100%</em></span>
					</span>
				</if>
			</span>
			<span class="overviewcustomerextras">
				Traffic:&nbsp;
				<if $row['traffic'] != 'UL'>
					<span class="progressBar" title="{$row['traffic_used']} / {$row['traffic']} GB">
						<if (($row['traffic']/100)*(int)$settings['system']['report_trafficmax']) < $row['traffic_used']>
							<span class="redbar">
						<else>
							<span>
						</if>
						<em style="left: {$doublepercent}px;">{$percent}%</em></span>
					</span>
				<else>
					<span class="progressBar" title="{$lng['customer']['unlimited']}">
						<span class="greybar"><em style="left: 200px;">100%</em></span>
					</span>
				</if>
			</span>
			<span style="clear: both !important;">
				{$lng['admin']['customers']}: {$row['customers_used']}
			</span>
		</div>
	</td>
	<td>
		<a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$row['adminid']}" style="text-decoration:none;">
			<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="$filename?s=$s&amp;page=$page&amp;action=delete&amp;id={$row['adminid']}" style="text-decoration:none;">
			<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
