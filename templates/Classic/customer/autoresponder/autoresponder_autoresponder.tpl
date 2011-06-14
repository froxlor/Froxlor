<tr>
	<td class="field_name_border_left">{$row['email']}</td>
	<td class="field_name"><if $row['enabled'] != 0>{$lng['panel']['yes']}</if><if $row['enabled'] == 0>{$lng['panel']['no']}</if></td>
	<td class="field_name">$activated_date</td>
	<td class="field_name"><a href="{$linker->getLink(array('section' => 'autoresponder', 'action' => 'edit', 'email' => $row['email']))}">{$lng['panel']['edit']}</a></td>
	<td class="field_name"><a href="{$linker->getLink(array('section' => 'autoresponder', 'action' => 'delete', 'email' => $row['email']))}">{$lng['panel']['delete']}</a></td>
</tr>
