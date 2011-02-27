$header
	<form action="$filename" method="post">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['menue']['extras']['pathoptions']}</b></td>
				<td class="maintitle_search_right" colspan="<if $cperlenabled == 1 >7<else>6</if>">{$searchcode}</td>
			</tr>
			<tr>
				<td class="field_display_border_left">{$lng['panel']['path']}&nbsp;&nbsp;{$arrowcode['path']}</td>
				<td class="field_display">{$lng['extras']['view_directory']}&nbsp;&nbsp;{$arrowcode['options_indexes']}</td>
				<td class="field_display">{$lng['extras']['error404path']}&nbsp;&nbsp;{$arrowcode['error404path']}</td>
				<td class="field_display">{$lng['extras']['error403path']}&nbsp;&nbsp;{$arrowcode['error403path']}</td>
				<td class="field_display">{$lng['extras']['error500path']}&nbsp;&nbsp;{$arrowcode['error500path']}</td>
				<if $cperlenabled == 1 ><td class="field_display">{$lng['extras']['execute_perl']}&nbsp;&nbsp;{$arrowcode['options_cgi']}</td></if>
				<td class="field_display_search" colspan="2">{$sortcode}</td>
			</tr>
			$htaccess
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="<if $cperlenabled == 1 >8<else>7</if>" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left" colspan="<if $cperlenabled == 1 >8<else>7</if>"><a href="$filename?page=htaccess&amp;action=add&amp;s=$s">{$lng['extras']['pathoptions_add']}</a></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer