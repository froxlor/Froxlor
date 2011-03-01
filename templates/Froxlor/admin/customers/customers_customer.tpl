<tr>
	<td>
		<strong>
		<if $row['name'] != '' && $row['firstname'] != ''>
			{$row['name']}&nbsp;{$row['firstname']}
		</if>
		<if ($row['name'] == '' || $row['firstname'] == '') && $row['company'] != ''>
			{$row['company']}
		</if>
		&nbsp;(<a href="$filename?s=$s&amp;page=$page&amp;action=su&amp;id={$row['customerid']}" rel="external">{$row['loginname']}</a> | {$row['adminname']})
		</strong>
		<div>
			<span class="overviewcustomerextras">
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
			</span>
			<span class="overviewcustomerextras">
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
			</span>
			<span style="clear: both !important;">
				{$last_login}
			</span>
		</div>
	</td>
	<td>
		<a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$row['customerid']}" style="text-decoration:none;">
			<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="$filename?s=$s&amp;page=$page&amp;action=delete&amp;id={$row['customerid']}" style="text-decoration:none;">
			<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
