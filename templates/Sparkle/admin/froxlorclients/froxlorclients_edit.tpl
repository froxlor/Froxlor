$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<input type="hidden" name="id" value="$id" />
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="templates/${theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['admin']['froxlorclients']['edit']}</b></td>
			</tr>
			<tr>
				<td class="maintitle_apply_left">
					<b><img src="templates/${theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['admin']['froxlorclients']['client']}</b>
				</td>
				<td class="maintitle_apply_right" nowrap="nowrap">
					<input class="bottom" type="reset" value="{$lng['panel']['reset']}" /><input class="bottom" type="submit" value="{$lng['panel']['save']}" />
				</td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['admin']['froxlorclients']['name']}:</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="name" value="{$client->Get('name')}" size="255" /></td>
			</tr>
			<tr>
				<td class="main_field_name" valign="top">{$lng['admin']['froxlorclients']['desc']}:</td>
				<td class="main_field_display" nowrap="nowrap"><textarea class="textarea_border" rows="12" cols="60" name="desc">{$client->Get('desc')}</textarea></td>
			</tr>
			<tr>
				<td class="main_field_name" valign="top">{$lng['admin']['froxlorclients']['enabled']}:</td>
				<td class="main_field_display" nowrap="nowrap">$client_enabled</td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input class="bottom" type="submit" value="{$lng['panel']['save']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
