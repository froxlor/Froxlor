<tr>
	<td class="field_name_border_left">{$row['email']}</td>
	<td class="field_name"><if $row['enabled'] != 0>{$lng['panel']['yes']}</if><if $row['enabled'] == 0>{$lng['panel']['no']}</if></td>
	<td class="field_name"><a href="$filename?&amp;action=edit&amp;email={$row['email']}&amp;s=$s">{$lng['panel']['edit']}</a></td>
	<td class="field_name"><a href="$filename?&amp;action=delete&amp;email={$row['email']}&amp;s=$s">{$lng['panel']['delete']}</a></td>
</tr>