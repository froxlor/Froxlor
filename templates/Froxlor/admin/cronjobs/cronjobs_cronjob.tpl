<tr>
	<td>{$description}</td>
	<td>{$row['lastrun']}</td>
	<td>{$row['interval']}</td>
	<td>{$row['isactive']}</td>
	<td>
		<a href="$filename?s=$s&amp;page=$page&amp;action=edit&amp;id={$row['id']}" style="text-decoration:none;">
			<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>
	</td>
</tr>
