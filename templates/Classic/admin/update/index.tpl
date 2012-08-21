$header
	<form action="{$linker->getLink(array('section' => 'updates'))}" method="post">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle"><b><img src="templates/{$theme}/assets/img/title.gif" alt="" />&nbsp;{$lng['update']['update']}</b></td>
			</tr>
			<tr>
				<td class="field_name_center">{$update_information}</td>
			</tr>
			<tr>
				<td class="field_name_center"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['update']['proceed']}" /></td>
			</tr>
			</if>
		</table>
	</form>
	<br />
	<br />
$footer
