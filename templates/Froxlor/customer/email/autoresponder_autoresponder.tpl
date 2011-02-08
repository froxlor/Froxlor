<tr>
	<td>{$row['email']}</td>
	<td>
		<if $row['enabled'] != 0>{$lng['panel']['yes']}</if>
		<if $row['enabled'] == 0>{$lng['panel']['no']}</if>
	</td>
	<td>$activated_date</td>
	<td>
		<a href="$filename?&amp;action=edit&amp;email={$row['email']}&amp;s=$s" style="text-decoration:none;">
			<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="$filename?&amp;action=delete&amp;email={$row['email']}&amp;s=$s" style="text-decoration:none;">
			<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>

