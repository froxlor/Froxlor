<form method="post" action="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'add_record', 'domain_id' => $domain_id))}">
<table class="full hl">
	<thead>
		<tr>
			<th class="size-20">Record</th>
			<th class="size-5">Type</th>
			<th class="size-5">Priority</th>
			<th class="size-50">Content</th>
			<th class="size-10">TTL</th>
			<th class="size-10">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><input id="dns_record" type="text" name="record[record]" class="small" placeholder="Record" value="{$record}" /></td>
			<td><select id="dns_type" name="record[type]" class="small">{$type_select}</select></td>
			<td><input id="dns_mxp" type="text" name="record[prio]" class="small" placeholder="MX or SRV priority" value="{$prio}" /></td>
			<td><input id="dns_content" type="text" name="record[content]" class="small" placeholder="Content" value="{$content}" /></td>
			<td><input id="dns_ttl" type="text" name="record[ttl]" class="small" placeholder="18000" value="{$ttl}" /></td>
			<td><input type="submit" class="submitsearch" value="add" name="add" /></td>
		</tr>
		{$existing_entries}
	</tbody>
</table>
</form>
