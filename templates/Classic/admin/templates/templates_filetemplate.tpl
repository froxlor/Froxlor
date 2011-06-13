		<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
			<td class="field_name_border_left">{$lng['admin']['templates'][$row['varname']]}</td>
			<td class="field_name"><a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'deletef', 'id' => $row['id']))}">{$lng['panel']['delete']}</a></td>
			<td class="field_name"><a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'editf', 'id' => $row['id']))}">{$lng['panel']['edit']}</a></td>
		</tr>
