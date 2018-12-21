<tr>
	<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates'][$row['varname']]}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'editf', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'deletef', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
		</a>
	</td>
</tr>
