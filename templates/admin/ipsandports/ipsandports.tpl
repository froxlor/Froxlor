$header
	<form action="$filename" method="post">
                <input type="hidden" name="s" value="$s"/>
                <input type="hidden" name="page" value="$page"/>
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left" colspan="5"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['admin']['ipsandports']['ipsandports']}</b></td>
				<td class="maintitle_search_right" colspan="5">{$searchcode}</td>
			</tr>
			<tr>
				<td class="field_display_border_left">{$lng['admin']['ipsandports']['ip']}&nbsp;&nbsp;{$arrowcode['ip']}&nbsp;:&nbsp;{$lng['admin']['ipsandports']['port']}&nbsp;&nbsp;{$arrowcode['port']}</td>
				<td class="field_display">Listen</td>
				<td class="field_display">NameVirtualHost</td>
				<td class="field_display">vHost-Container</td>
				<td class="field_display">Specialsettings</td>
				<td class="field_display">ServerName</td>
				<td class="field_display">SSL</td>
				<td class="field_display_search" colspan="2">{$sortcode}</td>
			</tr>
			$ipsandports
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="9" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left" colspan="9"><a href="$filename?page=$page&amp;action=add&amp;s=$s">{$lng['admin']['ipsandports']['add']}</a></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
