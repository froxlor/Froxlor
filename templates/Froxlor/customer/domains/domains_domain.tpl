<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td><a href="http://{$row['domain']}" target="_blank">{$row['domain']}</a></td>
	<td>
		<if $row['aliasdomain'] == ''>{$row['documentroot']}</if>
		<if isset($row['aliasdomainid']) && $row['aliasdomainid'] != 0>{$lng['domains']['aliasdomain']} {$row['aliasdomain']}</if>
	</td>
	<td>
		<if $row['caneditdomain'] == '1'>
			<a href="$filename?page=domains&amp;action=edit&amp;id={$row['id']}&amp;s=$s" style="text-decoration:none;">
				<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
			</a>&nbsp;
		</if>
		<if $row['parentdomainid'] != '0' && !(isset($row['domainaliasid']) && $row['domainaliasid'] != 0)>
			<a href="$filename?page=domains&amp;action=delete&amp;id={$row['id']}&amp;s=$s" style="text-decoration:none;">
				<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
			</a>&nbsp;
		</if>
		<if $row['parentdomainid'] == '0' && !(isset($row['domainaliasid']) && $row['domainaliasid'] != 0)>
			({$lng['domains']['isassigneddomain']})&nbsp;
		</if>
		<if isset($row['domainaliasid']) && $row['domainaliasid'] != 0>
			<a href="$filename?page=domains&amp;searchfield=d.aliasdomain&amp;searchtext={$row['id']}&amp;s=$s">{$lng['domains']['hasaliasdomains']}</a>
		</if>
	</td>
</tr>
