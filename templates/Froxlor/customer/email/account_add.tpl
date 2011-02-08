$header
<article>
	<header>
		<h2>
			<img src="images/Froxlor/icons/email_add.png" alt="{$lng['emails']['account_add']}" />&nbsp;
			{$lng['emails']['account_add']}
		</h2>
	</header>
	
	<section class="fullform bradiusodd">

			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['emails']['emails_add']}</legend>

					<table class="formtable">
						<tr>
							<td>{$lng['emails']['emailaddress']}:</td>
							<td>{$result['email_full']}</td>
						</tr>
						<tr>
							<td>{$lng['login']['password']}:</td>
							<td><input type="password" name="email_password" /></td>
						</tr>
						<if $settings['system']['mail_quota_enabled'] == 1>
						<tr>
							<td>{$lng['emails']['quota']} ({$lng['panel']['megabyte']}):</td>
							<td><input type="text" name="email_quota" value="{$quota}" /></td>
						</tr>
						</if>
						<if $settings['panel']['sendalternativemail'] == 1>
						<tr>
							<td>{$lng['emails']['alternative_emailaddress']}:</td>
							<td><input type="text" class="text" name="alternative_email" maxlength="255" /></td>
						</tr>
						</if>
						<tr>
							<td colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['emails']['account_add']}" /></td>
						</tr>
					</table>

					<p style="display: none;">
						<input type="hidden" name="s" value="$s" />
						<input type="hidden" name="page" value="$page" />
						<input type="hidden" name="action" value="$action" />
						<input type="hidden" name="send" value="send" />
					</p>
				</fieldset>
			</form>
	</section>
</article>
$footer
