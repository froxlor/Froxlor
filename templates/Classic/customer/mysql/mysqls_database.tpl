<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$row['databasename']}</td>
	<td class="field_name">{$row['description']}</td>
	<td class="field_name">{$row['size']}</td>
	<if 1 < count($sql_root)><td class="field_name">{$sql_root[$row['dbserver']]['caption']}</td></if>
	<if $row['apsdb'] != '1'>
		<td class="field_name"><a href="{$linker->getLink(array('section' => 'mysql', 'page' => 'mysqls', 'action' => 'edit', 'id' => $row['id']))}">{$lng['panel']['edit']}</a></td>
		<td class="field_name"><a href="{$linker->getLink(array('section' => 'mysql', 'page' => 'mysqls', 'action' => 'delete', 'id' => $row['id']))}">{$lng['panel']['delete']}</a></td>
	<else>
		<td class="field_name" colspan="2">{$lng['aps']['cannoteditordeleteapsdb']}</td>
	</if>
</tr>
