<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td><a href="http://{$row['domain']}" target="_blank">{$row['domain']}</a></td>
	<td>
		<if $row['aliasdomain'] == ''>{$row['documentroot']}</if>
		<if isset($row['aliasdomainid']) && $row['aliasdomainid'] != 0>{$lng['domains']['aliasdomain']} {$row['aliasdomain']}</if>
	</td>
	<td>
		<if $row['caneditdomain'] == '1'>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'edit', 'id' => $row['id']))}" style="text-decoration:none;">
				<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" />
			</a>&nbsp;
		</if>
		<if $row['parentdomainid'] != '0' && !(isset($row['domainaliasid']) && $row['domainaliasid'] != 0)>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'delete', 'id' => $row['id']))}" style="text-decoration:none;">
				<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" />
			</a>&nbsp;
		</if>
		<if $row['parentdomainid'] == '0' && !(isset($row['domainaliasid']) && $row['domainaliasid'] != 0)>
			({$lng['domains']['isassigneddomain']})&nbsp;
		</if>
		<if isset($row['domainaliasid']) && $row['domainaliasid'] != 0>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'searchfield' => 'd.aliasdomain', 'searchtext' => $row['id']))}">{$lng['domains']['hasaliasdomains']}</a>
		</if>
	</td>
</tr>
