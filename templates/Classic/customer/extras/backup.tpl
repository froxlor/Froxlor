$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="action" value="$action" />
		
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['backup']}</b></td>
			</tr>
			<tr>
				<td class="main_field_name">{$lng['extras']['backup_info']}
				<if $settings['system']['backup_bigfile'] == 1 >{$lng['extras']['backup_info_big']}</if>
				<if $settings['system']['backup_bigfile'] == 0 >{$lng['extras']['backup_info_sep']}</if>
				<if $settings['system']['backup_count'] == 1 > {$lng['extras']['backup_count_info']} </if>:</td>
				<td class="main_field_display" nowrap="nowrap">{$lng['extras']['backup_create']}&nbsp;$backup_enabled</td>
 			</tr>
 			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['panel']['save']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
