<tr>
	<td>{$row['plan_name']}</td>
	<td>{$row['plan_type']}</td>
	<td>
		<if $row['diskspace'] != '-1'>
			{$row['diskspace']}
		<else>
			{$lng['customer']['unlimited']}
		</if>
	</td>
	<td>
		<if $row['traffic'] != '-1'>
			{$row['traffic']}
		<else>
			{$lng['customer']['unlimited']}
		</if>
	</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'plans', 'page' => $page, 'action' => 'edit', 'id' => $row['planid']))}" style="text-decoration:none;">
			<img src="/templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'plans', 'page' => $page, 'action' => 'delete', 'id' => $row['planid']))}" style="text-decoration:none;">
			<img src="/templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
