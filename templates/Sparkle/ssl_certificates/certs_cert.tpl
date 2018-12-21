<tr <if !$isValid>class="domain-expired"</if>>
	<td>
		<a href="https://{$row['domain']}" target="_blank">{$row['domain']}</a>
		{$adminCustomerLink}
	</td>
	<td>
		{$cert_data['subject']['CN']}
		<if !empty($san_list)><br>SAN: {$san_list}</if>
	</td>
	<td>
		<if isset($cert_data['issuer']['O']) && !empty($cert_data['issuer']['O'])>{$cert_data['issuer']['O']}</if>
	</td>
	<td>
		{$validFrom}
	</td>
	<td>
		<if !$isValid><strong><span class="red"></if>
		{$validTo}
		<if !$isValid></span></strong></if>
	</td>
	<td>
		<if $row['letsencrypt'] != 1 && AREA == 'customer'>
			<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domainssleditor', 'action' => 'view', 'id' => $row['domainid']))}">
				<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['edit']}" />
			</a>&nbsp;
		</if>
		<if $row['letsencrypt'] == '1'>
			<img src="templates/{$theme}/assets/img/icons/ssl_letsencrypt.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['letsencrypt']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['letsencrypt']}" />
		</if>
		<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'sslcertificates', 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" title="{\Froxlor\I18N\Lang::getAll()['panel']['delete']}" />
		</a>
	</td>
</tr>
