<tr <if $isMyKey>class="primary-entry"</if>>
	<td>
		{$adminCustomerLink}
	</td>
	<td>
		{$row['apikey']}
	</td>
	<td>
		{$row['secret']}
	</td>
	<td>
		{$row['allowed_from']}
	</td>
	<td>
		<if !$isValid><strong><span class="red"></if>
		{$row['valid_until']}
		<if !$isValid></span></strong></if>
	</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'index', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" title="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'index', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
