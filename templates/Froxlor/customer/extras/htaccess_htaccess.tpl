<tr>
	<td>{$row['path']}</td>
	<td>{$row['options_indexes']}</td>
	<td>{$row['error404path']}</td>
	<td>{$row['error403path']}</td>
	<td>{$row['error500path']}</td>
	<if $cperlenabled == 1 >
	<td>{$row['options_cgi']}</td>
	</if>
	<td>
		<a href="$filename?page=htaccess&amp;action=edit&amp;id={$row['id']}&amp;s=$s" style="text-decoration:none;">
			<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="$filename?page=htaccess&amp;action=delete&amp;id={$row['id']}&amp;s=$s" style="text-decoration:none;">
			<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
