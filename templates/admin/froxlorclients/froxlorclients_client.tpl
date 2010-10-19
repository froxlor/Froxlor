<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left"><font size="-1">{$row['id']}</font></td>
	<td class="field_name">{$row['name']}</td>
	<td class="field_name">{$row['desc']}</td>
	<td class="field_name">{$row['enabled']}</td>
	<td class="field_name">
		<a href="$filename?s=$s&amp;page=$page&amp;action=settings&amp;id={$row['id']}">{$lng['admin']['froxlorclients']['settings']}</a>&nbsp;
		<a href="$filename?s=$s&amp;page=$page&amp;action=deploy&amp;id={$row['id']}">{$lng['admin']['froxlorclients']['deploy']}</a>&nbsp;
		<a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$row['id']}">{$lng['panel']['edit']}</a>&nbsp;
		<a href="$filename?s=$s&amp;page=$page&amp;action=delete&amp;id={$row['id']}">{$lng['panel']['delete']}</a>
	</td>
</tr>
