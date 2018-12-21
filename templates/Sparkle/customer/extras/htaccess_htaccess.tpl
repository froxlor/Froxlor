<tr>
	<td>{$row['path']}</td>
	<td>{$row['options_indexes']}</td>
	<td>{$row['error404path']}</td>
	<td>{$row['error403path']}</td>
	<td>{$row['error500path']}</td>
	<if $cperlenabled == 1 >
	<td>{$row['options_cgi']}</td>
	</if>
	<td>
		<a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htaccess', 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'extras', 'page' => 'htaccess', 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
		</a>
	</td>
</tr>
