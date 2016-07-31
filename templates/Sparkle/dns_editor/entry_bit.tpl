<tr>
	<td>{$entry['record']}</td>
	<td>{$entry['type']}</td>
	<td><if ($entry['prio'] <= 0 && $entry['type'] != 'MX' && $entry['type'] != 'SRV')>&nbsp;<else>{$entry['prio']}</if></td>
	<td>{$entry['content']}</td>
	<td>{$entry['ttl']}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'delete', 'domain_id' => $domain_id, 'id' => $entry['id']))}"><img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" /></a>
	</td>
</tr>
