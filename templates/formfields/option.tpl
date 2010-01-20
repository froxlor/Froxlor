<tr>
	<td class="main_field_name"<if $multiple == true> valign="top"</if>>{$label}</td>
	<td class="main_field_display" nowrap="nowrap"><select class="dropdown_noborder" name="{$fieldname}<if $multiple == true>[]</if>"<if $multiple == true> multiple="multiple"</if>>{$options}</select></td>
</tr>
