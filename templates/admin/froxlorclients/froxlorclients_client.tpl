<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">
		<img src="./images/multiserver/server.png" alt="Client #{$row['id']}" /></td>
	<td class="field_name">{$row['name']}<br /><span style="font-size:80%">{$row['desc']}</span></td>
	<td class="field_name">
		<if $row['enabled'] == 1 >
			<img src="./images/multiserver/tick.png" alt="{$lng['panel']['yes']}" />
		<else>
			<img src="./images/multiserver/no.png" alt="{$lng['panel']['no']}" />
		</if>
	</td>
	<td class="field_name">
		<a href="$filename?s=$s&amp;page=$page&amp;action=view&amp;id={$row['id']}">
			<img src="./images/multiserver/view.png" alt="{$lng['admin']['froxlorclients']['view']}" style="border:0;" />
		</a>
	</td>
</tr>
