<tr>
	<td>{$row['name']}</td>
	<td>{$row['logicalorder']}</td>
	<td>{$row['ticketcount']}&nbsp;({$row['ticketcountnotclosed']}&nbsp;{$lng['ticket']['open']}&nbsp;|&nbsp;{$closedtickets_count}&nbsp;{$lng['ticket']['closed']})</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'categories', 'action' => 'editcategory', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'categories', 'action' => 'deletecategory', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>

