<if $row['termination_css'] != ''>
	<tr class="{$row['termination_css']}">
</if>
<if $row['termination_css'] == ''>
	<tr>
</if>
	<td>{$row['databasename']}</td>
	<td>{$row['description']}</td>
	<td>{$row['size']}</td>
        <if 1 < $count_mysqlservers><td>{$sql_root['caption']}</td></if>
	<td>{$row['customername']}&nbsp;
		<if !empty($row['loginname'])>(<a href="{$linker->getLink(array('section' => 'customers', 'page' => 'customers', 'action' => 'su', 'id' => $row['customerid']))}" rel="external">{$row['loginname']}</a>)</if>
	</td>
</tr>
