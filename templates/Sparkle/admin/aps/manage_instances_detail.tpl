<tr>
	<td  class="field_name_border_left" style="padding-left: 2em;">{$Row['name']}, {$Row['firstname']} <if $Row['company'] != ''> | {$Row['company']}</if> ({$Row['loginname']}): {$database}; {$main_domain}</td>
	<td class="field_name" style="text-align:center;"><if isset($Stop) == true>$Stop</if></td>
	<td class="field_name" style="text-align:center;"><if isset($Remove) == true>$Remove</if></td>
</tr>
