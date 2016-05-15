$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/domain_edit_big.png" alt="" />&nbsp;
				DNS Editor&nbsp;(<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'edit', 'id' => $domain_id))}">{$domain}</a>, {$entriescount} {$lng['dnseditor']['records']})
			</h2>
		</header>
		
		<div class="messagewrapperfull">
		<div class="warningcontainer bradius">
			<div class="warningtitle">{$lng['admin']['warning']}</div>
			<div class="warning">{$lng['dns']['howitworks']}</div>
		</div>
		</div>

		<if !empty($errors)>
		<div class="errorcontainer bradius">
			<div class="errortitle">{$lng['error']['error']}</div>
			<div class="error">{$errors}</div>
		</div>
		</if>
		<if !empty($success_message)>
		<div class="successcontainer bradius">
			<div class="successtitle">{$lng['success']['success']}</div>
			<div class="success">{$success_message}</div>
		</div>
		</if>

		<section>
			{$record_list}
		</section>

	</article>

	<br><br>
	<textarea rows="20" class="filecontent">{$zonefile}</textarea>

$footer
