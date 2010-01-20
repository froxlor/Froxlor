<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$row['username']}</td>
	<td class="field_name">{$row['path']}</td>
	<td class="field_name"><a href="$filename?page=htpasswds&amp;action=edit&amp;id={$row['id']}&amp;s=$s">{$lng['menue']['main']['changepassword']}</a></td>
	<td class="field_name"><a href="$filename?page=htpasswds&amp;action=delete&amp;id={$row['id']}&amp;s=$s">{$lng['panel']['delete']}</a></td>
</tr>
