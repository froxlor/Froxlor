<thead>
	<tr>
		<th>{$lng['panel']['path']}</th>
		<th>{$lng['extras']['backup_web']}</th>
		<th>{$lng['extras']['backup_mail']}</th>
		<th>{$lng['extras']['backup_dbs']}</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>{$row['path']}</td>
		<td>{$row['backup_web']}</td>
		<td>{$row['backup_mail']}</td>
		<td>{$row['backup_dbs']}</td>
	</tr>
</tbody>
<tfoot>
	<tr>
		<td colspan="4">
			<p>
				<input type="hidden" name="backup_job_entry" value="{$existing_backupJob['id']}" />
				<input type="submit" value="{$lng['panel']['abort']}" class="nobutton" />
			</p>
		</td>
	</tr>
</tfoot>
