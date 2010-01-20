<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$row['databasename']}</td>
	<td class="field_name">{$row['description']}</td>
	<if 1 < count($sql_root)><td class="field_name">{$sql_root[$row['dbserver']]['caption']}</td></if>
	<td class="field_name"><a href="$filename?page=mysqls&amp;action=edit&amp;id={$row['id']}&amp;s=$s">{$lng['panel']['edit']}</a></td>
	<td class="field_name"><a href="$filename?page=mysqls&amp;action=delete&amp;id={$row['id']}&amp;s=$s">{$lng['panel']['delete']}</a></td>
</tr>
