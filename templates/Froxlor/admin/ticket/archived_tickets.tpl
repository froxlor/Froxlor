<tr>
	<td>{$ticket['lastchange']}</td>
	<td>{$ticket['ticket_answers']}</td>
	<td>{$ticket['subject']}</td>
	<td>{$ticket['lastreplier']}</td>
	<td>{$ticket['priority']}</td>
	<td>
		<a href="$filename?page=archive&amp;action=view&amp;id={$ticket['id']}&amp;s=$s" style="text-decoration:none;">
			<img src="images/Froxlor/icons/show_ticket.png" alt="{$lng['ticket']['show']}"/>
		</a>
	</td>
</tr>
