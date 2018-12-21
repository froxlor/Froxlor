<tr>
	<td>{$row['ip']}</td>
	<td>{$row['port']}</td>
	<if !$is_nginx><td><if $row['listen_statement']=='1'>{\Froxlor\I18N\Lang::getAll()['panel']['yes']}<else>{\Froxlor\I18N\Lang::getAll()['panel']['no']}</if></td></if>
	<if $is_apache && !$is_apache24><td><if $row['namevirtualhost_statement']=='1'>{\Froxlor\I18N\Lang::getAll()['panel']['yes']}<else>{\Froxlor\I18N\Lang::getAll()['panel']['no']}</if></td></if>
	<td><if $row['vhostcontainer']=='1'>{\Froxlor\I18N\Lang::getAll()['panel']['yes']}<else>{\Froxlor\I18N\Lang::getAll()['panel']['no']}</if></td>
	<td><if $row['specialsettings']!=''>{\Froxlor\I18N\Lang::getAll()['panel']['yes']}<else>{\Froxlor\I18N\Lang::getAll()['panel']['no']}</if></td>
	<if $is_apache><td><if $row['vhostcontainer_servername_statement']=='1'>{\Froxlor\I18N\Lang::getAll()['panel']['yes']}<else>{\Froxlor\I18N\Lang::getAll()['panel']['no']}</if></td></if>
	<td><if $row['ssl']=='1'>{\Froxlor\I18N\Lang::getAll()['panel']['yes']}<else>{\Froxlor\I18N\Lang::getAll()['panel']['no']}</if></td>
	<td>
		<a href="{$linker->getLink(array('section' => 'ipsandports', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'ipsandports', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
		</a>
	</td>
</tr>
