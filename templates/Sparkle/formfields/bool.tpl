<tr>
	<td>{$label}</td>
	<td>
		<input type="hidden" name="{$fieldname}" value="0" />
		<input <if $do_show == 0>disabled="disabled"</if> type="checkbox" name="{$fieldname}" value="1" <if( $fielddata['value'] == '1' )>checked="checked"</if> />
	</td>
</tr>
