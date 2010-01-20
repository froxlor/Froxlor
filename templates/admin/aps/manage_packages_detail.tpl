<tr>
	<td class="field_name_border_left">{$Row2['Version']} (Release {$Row2['Release']})</td>
	<td class="field_name"><if $Row2['Status'] == PACKAGE_LOCKED>{$lng['aps']['package_locked']}</if><if $Row2['Status'] == PACKAGE_ENABLED>{$lng['aps']['package_enabled']}</if></td>
	<td class="field_name">{$Installations}</td>
	<td class="field_name" style="text-align:center;">$Lock</td>
	<td class="field_name" style="text-align:center;">$Unlock</td>
	<td class="field_name" style="text-align:center;"><if $Installations == 0>$Remove</if></td>
</tr>
