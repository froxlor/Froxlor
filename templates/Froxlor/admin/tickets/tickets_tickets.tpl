<tr>
	<td>{$row['lastchange']}</td>
	<td>{$row['ticket_answers']}</td>
	<td>{$row['subject']}</td>
	<td>{$row['status']}</td>
	<td>{$row['lastreplier']}</td>
	<td>{$row['priority']}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'answer', 'id' => $row['id']))}" style="text-decoration:none;">
			<if $cananswer < 1 >
				<img src="templates/{$theme}/assets/img/icons/ticket_show.png" alt="{$lng['ticket']['show']}"/>
			</if>
			<if 0 < $cananswer >
				<img src="templates/{$theme}/assets/img/icons/ticket_answer.png" alt="{$lng['ticket']['answer']}"/>
			</if>
		</a>
		<if $reopen < 1 >
			&nbsp;<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'close', 'id' => $row['id']))}" style="text-decoration:none;">
				<img src="templates/{$theme}/assets/img/icons/ticket_close.png" alt="{$lng['ticket']['close']}"/>
			</a>
		</if>
		<if 0 < $reopen >
			&nbsp;<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'reopen', 'id' => $row['id']))}" style="text-decoration:none;">
				<img src="templates/{$theme}/assets/img/icons/ticket_reopen.png" alt="{$lng['ticket']['reopen']}"/>
			</a>
		</if>
		&nbsp;<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'archive', 'id' => $row['id']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/archive_ticket.png" alt="{$lng['ticket']['archive']}"/>
		</a>
		&nbsp;<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'delete', 'id' => $row['id']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}"/>
		</a>
	</td>
</tr>
