$header
	<article class="login bradius">
		<header class="dark">
			<img src="{$header_logo}" alt="Froxlor Server Management Panel" />
		</header>
			<if $message != ''>
				<div class="errorcontainer bradius">
					<div class="errortitle">{$lng['error']['error']}</div>
					<div class="error">$message</div>
				</div>
			</if>
			<section class="loginsec">
				<h3>{$lng['pwdreminder']['choosenew']}</h3>
				<form method="post" action="{$filename}?action=resetpwd&resetcode={$activationcode}" enctype="application/x-www-form-urlencoded">
					<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['login']['presend']}</legend>
					<p>
						<label for="new_password">{$lng['changepassword']['new_password']}:</label>&nbsp;
						<input type="password" name="new_password" id="new_password" required/>
					</p>
					<p>
						<label for="new_password_confirm">{$lng['changepassword']['new_password_confirm']}:</label>&nbsp;
						<input type="password" name="new_password_confirm" id="new_password_confirm" required/>
					</p>
					<p class="submit">
						<input type="hidden" name="action" value="$action" />
						<input type="hidden" name="send" value="send" />
						<input type="submit" value="{$lng['login']['remind']}" />
					</p>
					</fieldset>
				</form>
				<aside>
					<a href="index.php">{$lng['login']['backtologin']}</a>
				</aside>
			</section>
	</article>
$footer
