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
				<form method="post" action="$filename" enctype="application/x-www-form-urlencoded">
					<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['login']['presend']}</legend>
					<p>
						<label for="loginname">{$lng['login']['username']}:</label>&nbsp;
						<input type="text" name="loginname" id="loginname" value="" required/>
					</p>
					<p>
						<label for="password">{$lng['login']['email']}:</label>&nbsp;
						<input type="text" name="loginemail" id="loginemail" required/>
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

