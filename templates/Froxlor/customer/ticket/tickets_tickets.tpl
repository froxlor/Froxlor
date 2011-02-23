<tr>
	<td>{$row['lastchange']}</td>
	<td>{$row['ticket_answers']}</td>
	<td>{$row['subject']}</td>
	<td>{$row['status']}</td>
	<td>{$row['lastreplier']}</td>
	<td>{$row['priority']}</td>
	<td>
		<a href="$filename?page=tickets&amp;action=answer&amp;id={$row['id']}&amp;s=$s" style="text-decoration:none;">
			<if $cananswer < 1 >
				<img src="images/Froxlor/icons/ticket_show.png" alt="{$lng['ticket']['show']}"/>
			</if>
			<if 0 < $cananswer >
				<img src="images/Froxlor/icons/ticket_answer.png" alt="{$lng['ticket']['answer']}"/>
			</if>
		</a>
		<if $reopen < 1 >
			&nbsp;<a href="$filename?page=tickets&amp;action=close&amp;id={$row['id']}&amp;s=$s" style="text-decoration:none;">
				<img src="images/Froxlor/icons/ticket_close.png" alt="{$lng['ticket']['close']}"/>
			</a>
		</if>
		<if 0 < $reopen >
			&nbsp;<a href="$filename?page=tickets&amp;action=reopen&amp;id={$row['id']}&amp;s=$s" style="text-decoration:none;">
				<img src="images/Froxlor/icons/ticket_reopen.png" alt="{$lng['ticket']['reopen']}"/>
			</a>
		</if>
	</td>
</tr>

