<tr>
	<td>{$ticket['lastchange']}</td>
	<td>{$ticket['ticket_answers']}</td>
	<td>{$ticket['subject']}</td>
	<td>{$ticket['lastreplier']}</td>
	<td>{$ticket['priority']}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'archive', 'action' => 'view', 'id' => $ticket['id']))}">
			<img src="templates/{$theme}/assets/img/icons/view.png" alt="{$lng['ticket']['show']}" title="{$lng['ticket']['show']}" class="tipper"/>
		</a>
	</td>
</tr>
