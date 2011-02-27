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
	</td>
	<td rowspan="2">
		<a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$row['adminid']}" style="text-decoration:none;">
			<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="$filename?s=$s&amp;page=$page&amp;action=delete&amp;id={$row['adminid']}" style="text-decoration:none;">
			<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
<tr>
	<td>
		<table class="overviewcustomerextras">
		<tr>
			<td style="width: 300px;">
				Webspace:&nbsp;
				<if $row['diskspace'] != 'UL'>
					<span class="progressBar" title="{$row['diskspace_used']} / {$row['diskspace']} MB">
						<if (($row['diskspace']/100)*90) < $row['diskspace_used']>
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
			</td>
			<td style="width: 300px;">
				Traffic:&nbsp;
				<if $row['traffic'] != 'UL'>
					<span class="progressBar" title="{$row['traffic_used']} / {$row['traffic']} GB">
						<if (($row['traffic']/100)*90) < $row['traffic_used']>
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
			</td>
			<td>
				{$lng['admin']['customers']}: {$row['customers_used']}
			</td>
		</tr>
		</table>
	</td>
</tr>

