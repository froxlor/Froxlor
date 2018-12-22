		<tr>
			<td>{$virtual_host['name']}<if $customerview == 1>&nbsp;<a href="{$linker->getLink(array('section' => 'customers', 'target' => 'traffic', 'page' => $page, 'action' => 'su', 'id' => $virtual_host['customerid']))}" rel="external">[{$lng['traffic']['details']}]</a></if></td>
			<td><small>{$virtual_host['jan']}</small></td>
			<td><small>{$virtual_host['feb']}</small></td>
			<td><small>{$virtual_host['mar']}</small></td>
			<td><small>{$virtual_host['apr']}</small></td>
			<td><small>{$virtual_host['may']}</small></td>
			<td><small>{$virtual_host['jun']}</small></td>
			<td><small>{$virtual_host['jul']}</small></td>
			<td><small>{$virtual_host['aug']}</small></td>
			<td><small>{$virtual_host['sep']}</small></td>
			<td><small>{$virtual_host['oct']}</small></td>
			<td><small>{$virtual_host['nov']}</small></td>
			<td><small>{$virtual_host['dec']}</small></td>
		</tr>
