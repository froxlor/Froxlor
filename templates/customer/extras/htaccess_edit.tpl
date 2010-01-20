$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<input type="hidden" name="id" value="$id" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['extras']['pathoptions_edit']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['panel']['path']}:</b></td>
				<td class="main_field_display" nowrap="nowrap">{$result['path']}</td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['extras']['directory_browsing']}:</b></td>
				<td class="main_field_display" nowrap="nowrap">$options_indexes</td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['extras']['errordocument404path']}:</b><br />{$lng['panel']['emptyfordefault']}</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="error404path" value="{$result['error404path']}" size="30" maxlength="255" /></td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['extras']['errordocument403path']}:</b><br />{$lng['panel']['emptyfordefault']}
				<if $settings['system']['webserver'] == 'lighttpd'><div style="color:red">{$lng['panel']['not_supported']}lighttpd</div></if>
				</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="error403path" value="{$result['error403path']}" size="30" maxlength="255" /></td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['extras']['errordocument500path']}:</b><br />{$lng['panel']['emptyfordefault']}
				<if $settings['system']['webserver'] == 'lighttpd'><div style="color:red">{$lng['panel']['not_supported']}lighttpd</div></if>
				</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="error500path" value="{$result['error500path']}" size="30" maxlength="255" /></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['extras']['pathoptions_edit']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
