<thead>
	<tr>
		<th>{\Froxlor\I18N\Lang::getAll()['panel']['path']}</th>
		<th>{\Froxlor\I18N\Lang::getAll()['extras']['backup_web']}</th>
		<th>{\Froxlor\I18N\Lang::getAll()['extras']['backup_mail']}</th>
		<th>{\Froxlor\I18N\Lang::getAll()['extras']['backup_dbs']}</th>
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
				<input type="submit" value="{\Froxlor\I18N\Lang::getAll()['panel']['abort']}" class="nobutton" />
			</p>
		</td>
	</tr>
</tfoot>
