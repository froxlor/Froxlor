$header
<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/lock_big.png"
				alt="" />&nbsp; {$lng['login']['2fa']}
		</h2>
	</header>

	<section>
		<if $userinfo['type_2fa'] == '0'>
		<form method="post"
			action="{$linker->getLink(array('section' => 'index', 'page' => $page, 'action' => 'add'))}">
			<p>{$lng['2fa']['2fa_overview_desc']}</p><br>
			<select id="type_2fa" name="type_2fa" class="small">{$type_select}
			</select>&nbsp;<input type="submit" class="submit" value="{$lng['2fa']['2fa_add']}" name="add" />
		</form>
		</if>

		<if $userinfo['type_2fa'] == '1'>
		<form method="post"
			action="{$linker->getLink(array('section' => 'index', 'page' => $page, 'action' => 'delete'))}">
			<p>{$lng['2fa']['2fa_email_desc']}</p><br>
			<input type="submit" class="cancel" value="{$lng['2fa']['2fa_delete']}" name="delete" />
		</form>
		</if>

		<if $userinfo['type_2fa'] == '2'>
		<form method="post"
			action="{$linker->getLink(array('section' => 'index', 'page' => $page, 'action' => 'delete'))}">
			<p>{$lng['2fa']['2fa_ga_desc']}</p><br>
			<img src="{$ga_qrcode}" alt="QRCode" /><br><br>
			<input type="submit" class="cancel" value="{$lng['2fa']['2fa_delete']}" name="delete" />
		</form>
		</if>
				
	</section>

</article>
$footer
