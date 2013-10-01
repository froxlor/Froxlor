<tr>
	<td>{$description}</td>
	<td>{$row['lastrun']}</td>
	<td>{$row['interval']}</td>
	<td>{$row['isactive']}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'cronjobs', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>
	</td>
</tr>
