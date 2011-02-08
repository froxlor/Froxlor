<tr>
	<td>{$row['username']}</td>
	<td>{$row['path']}</td>
	<td>
		<a href="$filename?page=htpasswds&amp;action=edit&amp;id={$row['id']}&amp;s=$s" style="text-decoration:none;">
			<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="$filename?page=htpasswds&amp;action=delete&amp;id={$row['id']}&amp;s=$s" style="text-decoration:none;">
			<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
