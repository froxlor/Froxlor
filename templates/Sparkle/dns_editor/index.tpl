$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/domain_edit_big.png" alt="" />&nbsp;
				DNS Editor&nbsp;(<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'edit', 'id' => $domain_id))}">{$domain}</a>, {$entriescount} {\Froxlor\I18N\Lang::getAll()['dnseditor']['records']})
			</h2>
		</header>
		
		<div class="messagewrapperfull">
		<div class="warningcontainer bradius">
			<div class="warningtitle">{\Froxlor\I18N\Lang::getAll()['admin']['warning']}</div>
			<div class="warning">{\Froxlor\I18N\Lang::getAll()['dns']['howitworks']}</div>
		</div>
		</div>

		<if !empty($errors)>
		<div class="errorcontainer bradius">
			<div class="errortitle">{\Froxlor\I18N\Lang::getAll()['error']['error']}</div>
			<div class="error">{$errors}</div>
		</div>
		</if>
		<if !empty($success_message)>
		<div class="successcontainer bradius">
			<div class="successtitle">{\Froxlor\I18N\Lang::getAll()['success']['success']}</div>
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
