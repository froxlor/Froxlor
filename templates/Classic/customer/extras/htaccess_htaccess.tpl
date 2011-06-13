<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$row['path']}</td>
	<td class="field_name">{$row['options_indexes']}</td>
	<td class="field_name">{$row['error404path']}</td>
	<td class="field_name">{$row['error403path']}</td>
	<td class="field_name">{$row['error500path']}</td>
	<if $cperlenabled == 1 ><td class="field_name">{$row['options_cgi']}</td></if>
	<td class="field_name"><a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htaccess', 'action' => 'edit', 'id' => $row['id']))}">{$lng['panel']['edit']}</a></td>
	<td class="field_name"><a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htaccess', 'action' => 'delete', 'id' => $row['id']))}">{$lng['panel']['delete']}</a></td>
</tr>
