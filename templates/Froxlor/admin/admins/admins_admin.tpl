<tr>
	<td>
		<strong>
		{$row['name']}
		<if $row['adminid'] != $userinfo['userid']>
		&nbsp;(<a href="{$linker->getLink(array('section' => 'admins', 'page' => $page, 'action' => 'su', 'id' => $row['adminid']))}" rel="external">{$row['loginname']}</a>)
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
                                                <em style="left: {$disk_doublepercent}px;">{$disk_percent}%</em></span>
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
                                                <em style="left: {$traffic_doublepercent}px;">{$traffic_percent}%</em></span>
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
		<a href="{$linker->getLink(array('section' => 'admins', 'page' => $page, 'action' => 'edit', 'id' => $row['adminid']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'admins', 'page' => $page, 'action' => 'delete', 'id' => $row['adminid']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
