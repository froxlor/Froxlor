		<tr>
			<th class="field_name_border_left">{$virtual_host['name']}<if $customerview == 1>&nbsp;<a href="{$linker->getLink(array('section' => 'traffic', 'page' => $page, 'action' => 'su', 'id' => $virtual_host['customerid']))}">[{$lng['traffic']['details']}]</a></if></th>
			<td class="field_name" style="text-align:right;background-color:white;">{$virtual_host['jan']}</td>
			<td class="field_name" style="text-align:right;">{$virtual_host['feb']}</td>
			<td class="field_name" style="text-align:right;background-color:white;">{$virtual_host['mar']}</td>
			<td class="field_name" style="text-align:right;">{$virtual_host['apr']}</td>
			<td class="field_name" style="text-align:right;background-color:white;">{$virtual_host['may']}</td>
			<td class="field_name" style="text-align:right;">{$virtual_host['jun']}</td>
			<td class="field_name" style="text-align:right;background-color:white;">{$virtual_host['jul']}</td>
			<td class="field_name" style="text-align:right;">{$virtual_host['aug']}</td>
			<td class="field_name" style="text-align:right;background-color:white;">{$virtual_host['sep']}</td>
			<td class="field_name" style="text-align:right;">{$virtual_host['oct']}</td>
			<td class="field_name" style="text-align:right;background-color:white;">{$virtual_host['nov']}</td>
			<td class="field_name" style="text-align:right;">{$virtual_host['dec']}</td>
		</tr>
