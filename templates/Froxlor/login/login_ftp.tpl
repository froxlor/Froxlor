	<article class="login bradius">
		<header class="dark">
			<img src="{$header_logo}" alt="{t}Froxlor Server Management Panel{/t}" />
		</header>

		{if isset($successmessage)}
			<div class="successcontainer bradius">
				<div class="successtitle">{t}Success{/t}</div>
				<div class="success">{$successmessage}</div>
			</div>
		{/if}

		{if isset($errormessage)}
			<div class="errorcontainer bradius">
				<div class="errortitle">{t}Error{/t}</div>
				<div class="error">{$errormessage}</div>
			</div>
		{/if}

		<section class="loginsec">
			<form method="post" action="webftp.php" enctype="application/x-www-form-urlencoded">
				<fieldset>
				<legend>{t}Froxlor - WebFTP - Login{/t}</legend>
				<p>
					<label for="loginname">{t}Username{/t}:</label>&nbsp;
					<input type="text" name="loginname" id="loginname" value="" required/>
				</p>
				<p>
					<label for="password">{t}Password{/t}:</label>&nbsp;
					<input type="password" name="password" id="password" required/>
				</p>
				<p class="submit">
					<input type="hidden" name="send" value="send" />
					<input type="submit" value="{t}Login{/t}" />
				</p>
				</fieldset>
			</form>
			<aside>&nbsp;</aside>
		</section>

	</article>
