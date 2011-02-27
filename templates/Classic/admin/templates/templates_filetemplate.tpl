		<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
			<td class="field_name_border_left">{$lng['admin']['templates'][$row['varname']]}</td>
			<td class="field_name"><a href="$filename?s=$s&amp;page=$page&amp;action=deletef&amp;id={$row['id']}">{$lng['panel']['delete']}</a></td>
			<td class="field_name"><a href="$filename?s=$s&amp;page=$page&amp;action=editf&amp;id={$row['id']}">{$lng['panel']['edit']}</a></td>
		</tr>
