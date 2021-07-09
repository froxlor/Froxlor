<tr>
	<td>{$label}</td>
	<td>
		<if $value>
			<img src="/{$value}" alt="Current Image" class="field-image-preview"><br>
			<input type="checkbox" value="1" name="{$fieldname}_delete" /> {$lng['panel']['image_field_delete']}
			<br><br>
		</if>
		<input <if $do_show == 0>disabled="disabled"</if> type="file" class="file" name="{$fieldname}" accept="image/jpeg, image/jpg, image/png, image/gif" />
	</td>
</tr>
