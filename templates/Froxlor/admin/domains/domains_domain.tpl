<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td>{$row['domain']}
		<if (isset($row['standardsubdomain']) && $row['standardsubdomain'] == $row['id'])>
			&nbsp;({$lng['admin']['stdsubdomain']})
		</if>
	</td>
	<td>{$row['ipandport']}</td>
	<td>{$row['customername']}&nbsp;
		(<a href="admin_customers.php?s=$s&amp;page=customers&amp;action=su&amp;id={$row['customerid']}" rel="external">{$row['loginname']}</a>)
	</td>
	<td>
		<a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$row['id']}" style="text-decoration:none;">
			<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>
		<if !(isset($row['domainaliasid']) && $row['domainaliasid'] != 0)>
			<if !(isset($row['standardsubdomain']) && $row['standardsubdomain'] == $row['id'])>
				&nbsp;<a href="$filename?s=$s&amp;page=$page&amp;action=delete&amp;id={$row['id']}" style="text-decoration:none;">
					<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
				</a>
			</if>
		</if>
		<if isset($row['domainaliasid']) && $row['domainaliasid'] != 0>
			&nbsp;<a href="$filename?s=$s&amp;page=$page&amp;searchfield=d.aliasdomain&amp;searchtext={$row['id']}">{$lng['domains']['hasaliasdomains']}</a>
		</if>
	</td>
</tr>
