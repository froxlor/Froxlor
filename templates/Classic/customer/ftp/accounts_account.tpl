<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$row['username']}</td>
	<td class="field_name">{$row['documentroot']}</td>
	<td class="field_name"><a href="$filename?page=accounts&amp;action=edit&amp;id={$row['id']}&amp;s=$s">{$lng['panel']['edit']}</a></td>
	<td class="field_name"><a href="$filename?page=accounts&amp;action=delete&amp;id={$row['id']}&amp;s=$s">{$lng['panel']['delete']}</a></td>
</tr>
