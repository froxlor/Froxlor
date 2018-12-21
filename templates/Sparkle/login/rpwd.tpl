$header
	<article class="login bradius">
		<header class="dark">
			<img src="{$header_logo}" alt="Froxlor Server Management Panel" />
		</header>
			<if $message != ''>
				<div class="errorcontainer bradius">
					<div class="errortitle">{\Froxlor\I18N\Lang::getAll()['error']['error']}</div>
					<div class="error">$message</div>
				</div>
			</if>
			<section class="loginsec">
				<h3>{\Froxlor\I18N\Lang::getAll()['pwdreminder']['choosenew']}</h3>
				<form method="post" action="{$filename}?action=resetpwd&resetcode={$activationcode}" enctype="application/x-www-form-urlencoded">
					<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{\Froxlor\I18N\Lang::getAll()['login']['presend']}</legend>
					<p>
						<label for="new_password">{\Froxlor\I18N\Lang::getAll()['changepassword']['new_password']}:</label>&nbsp;
						<input type="password" name="new_password" id="new_password" required/>
					</p>
					<p>
						<label for="new_password_confirm">{\Froxlor\I18N\Lang::getAll()['changepassword']['new_password_confirm']}:</label>&nbsp;
						<input type="password" name="new_password_confirm" id="new_password_confirm" required/>
					</p>
					<p class="submit">
						<input type="hidden" name="action" value="$action" />
						<input type="hidden" name="send" value="send" />
						<input type="submit" value="{\Froxlor\I18N\Lang::getAll()['login']['remind']}" />
					</p>
					</fieldset>
				</form>
				<aside>
					<a href="index.php">{\Froxlor\I18N\Lang::getAll()['login']['backtologin']}</a>
				</aside>
			</section>
	</article>
$footer
