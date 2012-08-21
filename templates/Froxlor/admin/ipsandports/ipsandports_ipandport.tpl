<tr>
	<td>{$row['ip']}:{$row['port']}</td>
	<td><if $row['listen_statement']=='1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></td>
	<td><if $row['namevirtualhost_statement']=='1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></td>
	<td><if $row['vhostcontainer']=='1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></td>
	<td><if $row['specialsettings']!=''>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></td>
	<td><if $row['vhostcontainer_servername_statement']=='1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></td>
	<td><if $row['ssl']=='1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></td>
	<td>
		<a href="{$linker->getLink(array('section' => 'ipsandports', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'ipsandports', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
