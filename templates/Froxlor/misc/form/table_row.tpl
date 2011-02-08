<tr>
	<td{$style} class="formlabeltd">
		<label for="{$fieldname}">{$label}{$mandatory}:
		<if $desc != ''>
			<br /><span style="font-size:85%;">{$desc}</span>
		</if>
		</label>
	</td>
	<td>
		{$data_field}
	</td>
</tr>
