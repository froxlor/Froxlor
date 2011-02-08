<tr>
	<td style="vertical-align:top;"><strong>{$row['description']}</strong></td>
	<td style="vertical-align:top;">{$domains}</td>
	<td style="vertical-align:top;">{$row['binary']}</td>
	<td style="vertical-align:top;">{$row['file_extensions']}</td>
	<td style="vertical-align:top;">
		<a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$row['id']}" style="text-decoration:none;">
			<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>
		<if $row['id'] != 1>
			&nbsp;<a href="$filename?s=$s&amp;page=$page&amp;action=delete&amp;id={$row['id']}" style="text-decoration:none;">
				<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
			</a>
		</if>
	</td>
</tr>
