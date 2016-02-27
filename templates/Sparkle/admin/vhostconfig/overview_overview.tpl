<tr class="top">
	<td><strong>{$row['description']}</strong></td>
	<td>{$domains}</td>
	<td>{$webserver}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'vhostsettings', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" title="{$lng['panel']['edit']}" />
		</a>
		&nbsp;<a href="{$linker->getLink(array('section' => 'vhostsettings', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
