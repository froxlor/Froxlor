<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">
		<img src="templates/{$theme}/assets/img/multiserver/server.png" alt="Client #{$row['id']}" /></td>
	<td class="field_name">{$row['name']}<br /><span style="font-size:80%">{$row['desc']}</span></td>
	<td class="field_name">
		<if $row['enabled'] == 1 >
			<img src="templates/{$theme}/assets/img/multiserver/tick.png" alt="{$lng['panel']['yes']}" />
		<else>
			<img src="templates/{$theme}/assets/img/multiserver/no.png" alt="{$lng['panel']['no']}" />
		</if>
	</td>
	<td class="field_name">
		<a href="$filename?s=$s&amp;page=$page&amp;action=view&amp;id={$row['id']}">
			<img src="templates/{$theme}/assets/img/multiserver/view.png" alt="{$lng['admin']['froxlorclients']['view']}" style="border:0;" />
		</a>
	</td>
</tr>
