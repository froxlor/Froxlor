<tr>
	<td>{$row['username']}</td>
	<td>{$row['description']}</td>
	<td>{$row['documentroot']}</td>
	<if \Froxlor\Settings::Get('system.allow_customer_shell') == '1' >
		<td>{$row['shell']}</td>
	</if>
	<td>
		<a href="{$linker->getLink(array('section' => 'ftp', 'page' => 'accounts', 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'ftp', 'page' => 'accounts', 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
		</a>
	</td>
</tr>
