			<tr>
				<td class="maintitle_apply_left">
					<b><img src="templates/${theme}/assets/img/title.gif" alt="" />&nbsp;{$title}</b>
				</td>
				<td class="main_field_display_small" nowrap="nowrap">{$option}</td>
				<td class="main_field_display_small" nowrap="nowrap">
					<if $activated == 1>
						<a href="$filename?page=clients&amp;action=settings&amp;part=$part&amp;s=$s&amp;id={$server_id}">{$lng['admin']['configfiles']['serverconfiguration']}</a>
					</if>
				</td>
			</tr>

