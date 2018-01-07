<tr class="top">
	<td><strong>{$row['description']}</strong></td>
	<td>{$configs}</td>
	<td>{$row['reload_cmd']}</td>
	<td>{$row['config_dir']}</td>
	<td>{$row['pm']}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" title="{$lng['panel']['edit']}" />
		</a>
		<if $row['id'] != 1>
		&nbsp;<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" />
		</a>
		</if>
	</td>
</tr>
