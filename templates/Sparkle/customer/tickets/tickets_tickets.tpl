<tr>
	<td>{$row['lastchange']}</td>
	<td>{$row['ticket_answers']}</td>
	<td>{$row['subject']}</td>
	<td>{$row['status']}</td>
	<td>{$row['lastreplier']}</td>
	<td>{$row['priority']}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'answer', 'id' => $row['id']))}">
			<if $cananswer < 1 >
				<img src="templates/{$theme}/assets/img/icons/view.png" alt="{$lng['ticket']['show']}" title="{$lng['ticket']['show']}" />
			</if>
			<if 0 < $cananswer >
				<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['ticket']['answer']}" title="{$lng['ticket']['answer']}" />
			</if>
		</a>
		<if $reopen < 1 >
			&nbsp;<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'close', 'id' => $row['id']))}">
				<img src="templates/{$theme}/assets/img/icons/lock.png" alt="{$lng['ticket']['close']}" title="{$lng['ticket']['close']}" />
			</a>
		</if>
		<if 0 < $reopen >
			&nbsp;<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'reopen', 'id' => $row['id']))}">
				<img src="templates/{$theme}/assets/img/icons/unlock.png" alt="{$lng['ticket']['reopen']}" title="{$lng['ticket']['reopen']}" />
			</a>
		</if>
	</td>
</tr>
