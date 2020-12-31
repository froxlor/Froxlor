$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/email_edit_big.png" alt="" />&nbsp;
				{$lng['admin']['testmail']}
			</h2>
		</header>
		
		<if !empty($_mailerror)>
		<div class="messagewrapperfull">
			<div class="warningcontainer bradius">
				<div class="warningtitle">{$lng['admin']['warning']}</div>
				<div class="warning">{$mailerr_msg}</div>
			</div>
		</div>
		</if>

		<section>
						<table class="full">
							<tr>
								<th>{$lng['serversettings']['mail_smtp_user']}</th>
								<th>Host</th>
								<th>Port</th>
								<th>SMTP Auth</th>
								<th>TLS</th>
							</tr>
							<tr>
								<td>{$mail_smtp_user}</td>
								<td>{$mail_smtp_host}</td>
								<td>{$mail_smtp_port}</td>
								<td><img src="templates/{$theme}/assets/img/icons/<if \Froxlor\Settings::Get('system.mail_use_smtp') == '1'>button_ok<else>cancel</if>.png" alt="" /></td>
								<td><img src="templates/{$theme}/assets/img/icons/<if \Froxlor\Settings::Get('system.mail_smtp_usetls') == '1'>button_ok<else>cancel</if>.png" alt="" /></td>
							</tr>
						</table>
			<br>
			<form action="{$linker->getLink(array('section' => 'settings'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />

				<input type="text" name="test_addr" id="test_addr" placeholder="test address" />
				<input type="submit" value="Test">
			</form>
		</section>
</article>
$footer
