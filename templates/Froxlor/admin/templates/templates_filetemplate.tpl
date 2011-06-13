<tr>
	<td>{$lng['admin']['templates'][$row['varname']]}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'editf', 'id' => $row['id']))}">
			<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'deletef', 'id' => $row['id']))}">
			<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>

