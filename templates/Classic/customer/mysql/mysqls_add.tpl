$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['mysql']['database_create']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['mysql']['databasedescription']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="description" maxlength="100" /></td>
			</tr>
			<if 1 < count($sql_root)>
			<tr>
				<td class="main_field_name">{$lng['mysql']['mysql_server']}:</td>
				<td class="main_field_display" nowrap="nowrap"><select name="mysql_server">$mysql_servers</select></td>
			</tr>
			</if>
			<tr>
				<td class="main_field_name">{$lng['login']['password']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="password" name="mysql_password" maxlength="50" /></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['customer']['sendinfomail']}:</td>
				<td class="main_field_display" nowrap="nowrap">{$sendinfomail}</td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['mysql']['database_create']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer