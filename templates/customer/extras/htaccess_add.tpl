$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['extras']['pathoptions_add']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">
					<b>{$lng['panel']['path']}:</b><br />
					<if $settings['panel']['pathedit'] != 'Dropdown'><font size="1">{$lng['panel']['pathDescription']}</font></if>
				</td>
				<td class="main_field_display" nowrap="nowrap">{$pathSelect}</td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['extras']['directory_browsing']}:</b></td>
				<td class="main_field_display" nowrap="nowrap">$options_indexes</td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['extras']['errordocument404path']}:</b><br />{$lng['panel']['descriptionerrordocument']}</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="error404path" value="" size="30" maxlength="255" /></td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['extras']['errordocument403path']}:</b><br />{$lng['panel']['descriptionerrordocument']}
				<if $settings['system']['webserver'] == 'lighttpd'><div style="color:red">{$lng['panel']['not_supported']}lighttpd</div></if>
				</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="error403path" value="" size="30" maxlength="255" /></td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['extras']['errordocument500path']}:</b><br />{$lng['panel']['descriptionerrordocument']}
				<if $settings['system']['webserver'] == 'lighttpd'><div style="color:red">{$lng['panel']['not_supported']}lighttpd</div></if>
				</td>
				<td class="main_field_display" nowrap="nowrap"><input type="text" class="text" name="error500path" value="" size="30" maxlength="255" /></td>
			</tr>
			<if $cperlenabled == 1 >
				<tr>
					<td class="main_field_name"><b>{$lng['extras']['execute_perl']}:</b></td>
					<td class="main_field_display" nowrap="nowrap">$options_cgi</td>
				</tr>
			</if>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['extras']['pathoptions_add']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
