<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$description}</td>
	<td class="field_name">{$row['lastrun']}</td>
	<td class="field_name">{$row['interval']}</td>
	<td class="field_name">{$row['isactive']}</td>
	<td class="field_name"><a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$row['id']}">{$lng['panel']['edit']}</a></td>
</tr>
