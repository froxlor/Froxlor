$header
	<article class="login bradius">
		<header class="dark">
			<img src="{$header_logo}" alt="Froxlor Server Management Panel" />
		</header>
			<section class="loginsec">
				<form method="post" action="{$filename}" enctype="application/x-www-form-urlencoded">
					<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{\Froxlor\I18N\Lang::getAll()['login']['2fa']}</legend>
					<p>
						<label for="2fa_code">{\Froxlor\I18N\Lang::getAll()['login']['2facode']}:</label>&nbsp;
						<input type="text" name="2fa_code" id="2fa_code" value="" required/>
					</p>
					<p class="submit">
						<input type="hidden" name="action" value="2fa_verify" />
						<input type="hidden" name="send" value="send" />
						<input type="submit" value="{\Froxlor\I18N\Lang::getAll()['2fa']['2fa_verify']}" />
					</p>
					</fieldset>
				</form>
				<aside>
					<a href="index.php">{\Froxlor\I18N\Lang::getAll()['login']['backtologin']}</a>
				</aside>
			</section>
	</article>
$footer
