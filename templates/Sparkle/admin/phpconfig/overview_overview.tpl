<tr>
	<td style="vertical-align:top;"><strong>{$row['description']}</strong></td>
	<td style="vertical-align:top;">{$domains}</td>
	<td style="vertical-align:top;">{$row['binary']}</td>
	<td style="vertical-align:top;">{$row['file_extensions']}</td>
	<td style="vertical-align:top;">
		<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}" style="text-decoration:none;">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>
		<if $row['id'] != 1>
			&nbsp;<a href="{$linker->getLink(array('section' => 'phpsettings', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}" style="text-decoration:none;">
				<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" />
			</a>
		</if>
	</td>
</tr>
