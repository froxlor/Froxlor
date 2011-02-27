<tr>
	<td>{$Row2['Version']} (Release {$Row2['Release']})</td>
	<td><if $Row2['Status'] == PACKAGE_LOCKED>{$lng['aps']['package_locked']}</if><if $Row2['Status'] == PACKAGE_ENABLED>{$lng['aps']['package_enabled']}</if></td>
	<td>{$Installations}</td>
	<td style="text-align:center;">$Lock</td>
	<td style="text-align:center;">$Unlock</td>
	<td style="text-align:center;"><if $Installations == 0>$Remove</if></td>
</tr>
