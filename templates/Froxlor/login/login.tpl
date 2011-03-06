$header
	<article class="login bradius">
		<header class="dark">
			<img src="{$header_logo}" alt="Froxlor Server Management Panel" />
		</header>

		<if $update_in_progress !== ''>
			<div class="warningcontainer bradius">
				<div class="warning">{$update_in_progress}</div>
			</div>
		</if>

		<if $successmessage != ''>
			<div class="successcontainer bradius">
				<div class="successtitle">{$lng['success']['success']}</div>
				<div class="success">$successmessage</div>
			</div>
		</if>

		<if $message != ''>
			<div class="errorcontainer bradius">
				<div class="errortitle">{$lng['error']['error']}</div>
				<div class="error">$message</div>
			</div>
		</if>

		<section class="loginsec">
			<form method="post" action="$filename" enctype="application/x-www-form-urlencoded">
				<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;Login</legend>
				<p>
					<label for="loginname">{$lng['login']['username']}:</label>&nbsp;
					<input type="text" name="loginname" id="loginname" value="" required/>
				</p>
				<p>
					<label for="password">{$lng['login']['password']}:</label>&nbsp;
					<input type="password" name="password" id="password" required/>
				</p>
				<p>
					<label for="language">{$lng['login']['language']}:</label>&nbsp;
					<select name="language" id="language">$language_options</select>
				</p>
				<p class="submit">
					<input type="hidden" name="send" value="send" />
					<input type="submit" value="{$lng['login']['login']}" />
				</p>
				</fieldset>
			</form>

			<aside>
				<if $settings['panel']['allow_preset'] == '1'>
					<a href="$filename?action=forgotpwd">{$lng['login']['forgotpwd']}</a>
				<else>
					&nbsp;
				</if>
			</aside>

		</section>

	</article>
$footer
