<tr>
	<td>{$row['username']}</td>
	<td>{$row['description']}</td>
	<td>{$row['documentroot']}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'ftp', 'page' => 'accounts', 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" title="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'ftp', 'page' => 'accounts', 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
