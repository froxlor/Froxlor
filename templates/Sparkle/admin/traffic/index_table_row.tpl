		<tr>
			<td>{$virtual_host['name']}<if $customerview == 1>&nbsp;<a href="{$linker->getLink(array('section' => 'traffic', 'page' => $page, 'action' => 'su', 'id' => $virtual_host['customerid']))}" rel="external">[{$lng['traffic']['details']}]</a></if></td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['jan']}</td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['feb']}</td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['mar']}</td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['apr']}</td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['may']}</td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['jun']}</td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['jul']}</td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['aug']}</td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['sep']}</td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['oct']}</td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['nov']}</td>
			<td style="text-align:right; font-size:10px;">{$virtual_host['dec']}</td>
		</tr>
