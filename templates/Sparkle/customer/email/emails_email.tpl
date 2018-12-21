<tr>
	<td>{$row['email_full']}</td>
	<td><if $row['destination'] == ''>&nbsp;<else>{$row['destination']}</if></td>
	<td><if $row['popaccountid'] != 0>{\Froxlor\I18N\Lang::getAll()['panel']['yes']} ({$row['mboxsize']})</if><if $row['popaccountid'] == 0>{\Froxlor\I18N\Lang::getAll()['panel']['no']}</if></td>
	<if \Froxlor\Settings::Get('catchall.catchall_enabled') == '1'><td><if $row['iscatchall'] != 0>{\Froxlor\I18N\Lang::getAll()['panel']['yes']}</if><if $row['iscatchall'] == 0>{\Froxlor\I18N\Lang::getAll()['panel']['no']}</if></td></if>
	<if \Froxlor\Settings::Get('system.mail_quota_enabled') == '1'><td><if $row['quota'] == 0>{\Froxlor\I18N\Lang::getAll()['emails']['noquota']}<else>{$row['quota']} MiB</if></if></td>
	<td>
		<a href="{$linker->getLink(array('section' => 'email', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'email', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
		</a>
	</td>
</tr>
