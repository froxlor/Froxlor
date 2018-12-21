<tr>
	<td>{$language}</td>
	<td>{$template}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'edit', 'subjectid' => $subjectid, 'mailbodyid' => $mailbodyid))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'delete', 'subjectid' => $subjectid, 'mailbodyid' => $mailbodyid))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
		</a>
	</td>
</tr>
