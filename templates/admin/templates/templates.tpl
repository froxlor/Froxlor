$header
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td colspan="4" class="maintitle"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['templates']['templates']}</b></td>
		</tr>
		<tr>
			<td class="field_display_border_left">{$lng['login']['language']}</td>
			<td class="field_display">{$lng['admin']['templates']['action']}</td>
			<td class="field_display" colspan="2">&nbsp;</td>
		</tr>
		$templates
		<if $add>
		<tr>
			<td colspan="4" class="field_display_border_left"><a href="$filename?page=$page&amp;action=add&amp;s=$s">{$lng['admin']['templates']['template_add']}</a></td>
		</tr>
		</if>
	</table>
	<br/>
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td colspan="3" class="maintitle"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['templates']['filetemplates']}</b></td>
		</tr>
		<tr>
			<td class="field_display_border_left">{$lng['admin']['templates']['action']}</td>
			<td class="field_display">&nbsp;</td>
			<td class="field_display">&nbsp;</td>
		</tr>
		$filetemplates
		<if $filetemplateadd>
		<tr>
			<td colspan="4" class="field_display_border_left"><a href="$filename?page=$page&amp;action=add&amp;s=$s&amp;files=files">{$lng['admin']['templates']['template_add']}</a></td>
		</tr>
		</if>
	</table>
	<br />
	<br />
$footer