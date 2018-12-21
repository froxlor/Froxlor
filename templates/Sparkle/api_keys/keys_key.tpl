<tr <if $isMyKey>class="primary-entry"</if> id="apikey-{$row['id']}" data-id="{$row['id']}" title="{\Froxlor\I18N\Lang::getAll()['apikeys']['clicktoview']}">
	<td>
		{$adminCustomerLink}
	</td>
	<td>
		<span>{$row['_apikey']}</span>
	</td>
	<td>
		<span>{$row['_secret']}</span>
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
		<a href="{$linker->getLink(array('section' => 'index', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
		</a>
		<div id="dialog-{$row['id']}" title="API-key / Secret" class="hidden api-dialog">
			<form action="{$linker->getLink(array('section' => 'apikeys'))}" method="post" enctype="application/x-www-form-urlencoded">
			<input type="hidden" name="id" value="{$row['id']}"/>
			<input type="hidden" name="area" value="{$area}"/>
			<table class="full hl">
				<tr>
					<th>API-key</th><td><input type="text" value="{$row['apikey']}" readonly/></td>
				</tr>
				<tr>
					<th>Secret</th><td><input type="text" value="{$row['secret']}" readonly/></td>
				</tr>
				<tr>
					<th>{\Froxlor\I18N\Lang::getAll()['apikeys']['allowed_from']}<br><small>{\Froxlor\I18N\Lang::getAll()['apikeys']['allowed_from_help']}</small></th><td><input type="text" name="allowed_from" value="{$row['allowed_from']}"/></td>
				</tr>
				<tr>
					<th>{\Froxlor\I18N\Lang::getAll()['apikeys']['valid_until']}<br><small>{\Froxlor\I18N\Lang::getAll()['apikeys']['valid_until_help']}</small></th><td><input type="text" name="valid_until" value="{$row['valid_until']}"/></td>
				</tr>
			</table>
			</form>
		</div>
	</td>
</tr>
