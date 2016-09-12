<tr>
	<td>{$label}</td>
	<td><select <if $do_show == 0>disabled="disabled"</if> name="{$fieldname}<if $multiple == true>[]</if>"<if $multiple == true> multiple="multiple"</if>>{$options}</select></td>
</tr>
