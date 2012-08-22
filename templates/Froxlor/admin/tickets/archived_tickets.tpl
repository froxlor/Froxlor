<tr>
	<td>{$ticket['lastchange']}</td>
	<td>{$ticket['ticket_answers']}</td>
	<td>{$ticket['subject']}</td>
	<td>{$ticket['lastreplier']}</td>
	<td>{$ticket['priority']}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'archive', 'action' => 'view', 'id' => $ticket['id']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/ticket_show.png" alt="{$lng['ticket']['show']}"/>
		</a>
	</td>
</tr>
