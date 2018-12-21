<tr class="top">
	<td><strong>{$row['description']}</strong></td>
	<td>{$configs}</td>
	<td>{$row['reload_cmd']}</td>
	<td>{$row['config_dir']}</td>
	<td>{$row['pm']}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
		</a>
		<if $row['id'] != 1>
		&nbsp;<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
		</a>
		</if>
	</td>
</tr>
