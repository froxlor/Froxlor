<tr>
	<td>{$row['domain']}
		<if (isset($row['standardsubdomain']) && $row['standardsubdomain'] == $row['id'])>
			&nbsp;({$lng['admin']['stdsubdomain']})
		</if>
	</td>
	<td>{$row['ipandport']}</td>
	<td>{$row['customername']}&nbsp;
		(<a href="{$linker->getLink(array('section' => 'customers', 'page' => 'customers', 'action' => 'su', 'id' => $row['customerid']))}" rel="external">{$row['loginname']}</a>)
	</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" title="{$lng['panel']['edit']}" />
		</a>
		<if !(isset($row['domainaliasid']) && $row['domainaliasid'] != 0)>
			<if !(isset($row['standardsubdomain']) && $row['standardsubdomain'] == $row['id'])>
				&nbsp;<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}">
					<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" />
				</a>
			</if>
		</if>
		<if isset($row['domainaliasid']) && $row['domainaliasid'] != 0>
			&nbsp;<a href="{$linker->getLink(array('section' => 'domains', 'page' => $page, 'searchfield' => 'd.aliasdomain', 'searchtext' => $row['id']))}">{$lng['domains']['hasaliasdomains']}</a>
		</if>
	</td>
</tr>
