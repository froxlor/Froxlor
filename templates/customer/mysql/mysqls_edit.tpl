$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<input type="hidden" name="id" value="$id" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['menue']['main']['changepassword']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['mysql']['databasename']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$result['databasename']}</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['mysql']['databasedescription']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="description" maxlength="100" value="{$result['description']}" /></td>
			</tr>
			<if 1 < count($sql_root)>
			<tr>
				<td class="main_field_name">{$lng['mysql']['mysql_server']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$sql_root[$result['dbserver']]['caption']}</td>
			</tr>
			</if>
			<tr>
				<td class="main_field_name">{$lng['changepassword']['new_password_ifnotempty']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="password" name="mysql_password" maxlength="50" /></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['panel']['save']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer