<tr>
	<td>{$row['name']}</td>
	<td>{$row['logicalorder']}</td>
	<td>{$row['ticketcount']}&nbsp;({$row['ticketcountnotclosed']}&nbsp;{$lng['ticket']['open']}&nbsp;|&nbsp;{$closedtickets_count}&nbsp;{$lng['ticket']['closed']})</td>
	<td>
		<a href="$filename?page=categories&amp;action=editcategory&amp;id={$row['id']}&amp;s=$s">
			<img src="images/Froxlor/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="$filename?page=categories&amp;action=deletecategory&amp;id={$row['id']}&amp;s=$s">
			<img src="images/Froxlor/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>

