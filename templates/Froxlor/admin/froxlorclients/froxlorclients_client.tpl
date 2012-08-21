<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">
		<a href="$filename?s=$s&amp;page=$page&amp;action=view&amp;id={$row['id']}">
			<img src="templates/{$theme}/assets/img/multiserver/server.png" alt="Client #{$row['id']}" style="border:0;" />
		</a>
	</td>
	<td class="field_name">
		<a href="$filename?s=$s&amp;page=$page&amp;action=view&amp;id={$row['id']}">
			{$row['name']}
		</a><br /><span style="font-size:80%">{$row['desc']}</span>
	</td>
	<td class="field_name">
		<if $row['enabled'] == 1>
			<a href="$filename?s=$s&amp;page=$page&amp;action=disableclient&amp;id={$row['id']}" title="Quick disable">
				<img src="templates/{$theme}/assets/img/multiserver/tick.png" alt="{$lng['panel']['yes']}" style="border:0;" />
			</a>
		<else>
			<a href="$filename?s=$s&amp;page=$page&amp;action=enableclient&amp;id={$row['id']}" title="Quick enable">
				<img src="templates/{$theme}/assets/img/multiserver/no.png" alt="{$lng['panel']['no']}" style="border:0;" />
			</a>
		</if>
	</td>
	<td class="field_name">
		<a href="$filename?s=$s&amp;page=$page&amp;action=view&amp;id={$row['id']}">
			<img src="templates/{$theme}/assets/img/multiserver/view.png" alt="{$lng['admin']['froxlorclients']['view']}" style="border:0;" />
		</a>
	</td>
</tr>
