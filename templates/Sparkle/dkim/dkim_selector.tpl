<tr>
	<td>
		<a href="https://{$row['domain']}" target="_blank">{$row['domain']}</a>
		{$adminCustomerLink}
	</td>
	<td>
		{$row['selector']}
	</td>
	<td>
		{$row['dnsrecord_name']}
	</td>
	<td>
		<textarea rows="20" class="filecontent" readonly>{$row['dnsrecord_data']}</textarea>
	</td>
	<td>
		<textarea rows="20" class="filecontent" readonly>{$row['pubkey']}</textarea>
	</td>
	<td>
		&nbsp;
	</td>
</tr>
