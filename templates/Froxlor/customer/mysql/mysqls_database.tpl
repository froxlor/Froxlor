<tr>
	<td>{$row['databasename']}</td>
	<td>{$row['description']}</td>
	<if 1 < count($sql_root)><td>{$sql_root[$row['dbserver']]['caption']}</td></if>
	<if $row['apsdb'] != '1'>
		<td>
			<a href="{$linker->getLink(array('section' => 'mysql', 'page' => 'mysqls', 'action' => 'edit', 'id' => $row['id']))}" style="text-decoration:none;">
				<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
			</a>&nbsp;
			<a href="{$linker->getLink(array('section' => 'mysql', 'page' => 'mysqls', 'action' => 'delete', 'id' => $row['id']))}" style="text-decoration:none;">
				<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
			</a>
		</td>
	<else>
		<td>{$lng['aps']['cannoteditordeleteapsdb']}</td>
	</if>
</tr>
