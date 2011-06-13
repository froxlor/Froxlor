<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$row['username']}</td>
	<td class="field_name">{$row['path']}</td>
	<td class="field_name"><a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htpasswds', 'action' => 'edit', 'id' => $row['id']))}">{$lng['panel']['edit']}</a></td>
	<td class="field_name"><a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htpasswds', 'action' => 'delete', 'id' => $row['id']))}">{$lng['panel']['delete']}</a></td>
</tr>
