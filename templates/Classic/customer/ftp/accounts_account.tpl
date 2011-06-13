<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$row['username']}</td>
	<td class="field_name">{$row['documentroot']}</td>
	<td class="field_name"><a href="{$linker->getLink(array('section' => 'ftp', 'page' => 'accounts', 'action' => 'edit', 'id' => $row['id']))}">{$lng['panel']['edit']}</a></td>
	<td class="field_name"><a href="{$linker->getLink(array('section' => 'ftp', 'page' => 'accounts', 'action' => 'delete', 'id' => $row['id']))}">{$lng['panel']['delete']}</a></td>
</tr>
