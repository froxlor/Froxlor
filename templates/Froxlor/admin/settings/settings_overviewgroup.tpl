<tr>
	<td class="formlabeltd" style="line-height:33px;">
		<label for="name"><strong>{$title}&nbsp;</strong></label>
	</td>
	<td>{$option}</td>
	<td>
		<if $activated == 1>
			<a href="$filename?page=overview&amp;part=$part&amp;s=$s">{$lng['admin']['configfiles']['serverconfiguration']}</a>
		</if>
	</td>
</tr>
