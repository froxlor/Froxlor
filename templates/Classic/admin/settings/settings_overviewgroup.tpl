			<tr>
				<td class="maintitle_apply_left">
					<b><img src="images/Classic/title.gif" alt="" />&nbsp;{$title}</b>
				</td>
				<td class="main_field_display_small" nowrap="nowrap">{$option}</td>
				<td class="main_field_display_small" nowrap="nowrap">
					<if $activated == 1>
						<a href="$filename?page=overview&amp;part=$part&amp;s=$s">{$lng['admin']['configfiles']['serverconfiguration']}</a>
					</if>
				</td>
			</tr>
