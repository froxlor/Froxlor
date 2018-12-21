<tr>
	<td>{$row['username']}</td>
	<td>{$row['path']}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htpasswds', 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htpasswds', 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
		</a>
	</td>
</tr>
