<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left"><font size="-1">{$row['ip']}:{$row['port']}</font></td>
	<td class="field_name"><font size="-1"><if $row['listen_statement']=='1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></font></td>
	<td class="field_name"><font size="-1"><if $row['namevirtualhost_statement']=='1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></font></td>
	<td class="field_name"><font size="-1"><if $row['vhostcontainer']=='1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></font></td>
	<td class="field_name"><font size="-1"><if $row['specialsettings']!=''>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></font></td>
	<td class="field_name"><font size="-1"><if $row['vhostcontainer_servername_statement']=='1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></font></td>
	<td class="field_name"><font size="-1"><if $row['ssl']=='1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></font></td>
	<td class="field_name"><a href="{$linker->getLink(array('section' => 'ipsandports', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}">{$lng['panel']['edit']}</a></td>
	<td class="field_name"><a href="{$linker->getLink(array('section' => 'ipsandports', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}">{$lng['panel']['delete']}</a></td>
</tr>
