<tr>
	<td>{$row['email']}</td>
	<td>
		<if $row['enabled'] != 0>{$lng['panel']['yes']}</if>
		<if $row['enabled'] == 0>{$lng['panel']['no']}</if>
	</td>
	<td>$activated_date</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'autoresponder', 'action' => 'edit', 'email' => $row['email']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'autoresponder', 'action' => 'delete', 'email' => $row['email']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>

