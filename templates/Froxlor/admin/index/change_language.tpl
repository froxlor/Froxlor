$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/flag.png" alt="" />&nbsp;
				{$lng['menue']['main']['changelanguage']}
			</h2>
		</header>

		<section class="tinyform bradiusodd">
			<form method="post" action="{$linker->getLink(array('section' => 'index'))}" enctype="application/x-www-form-urlencoded">
				<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;{$lng['menue']['main']['changelanguage']}</legend>
				<p>
					<label for="def_language">{$lng['login']['language']}:</label>&nbsp;
					<select id="def_language" name="def_language">$language_options</select>
				</p>
				<p class="submit">
					<input type="hidden" name="s" value="$s" />
					<input type="hidden" name="page" value="$page" />
					<input type="hidden" name="send" value="send" />
					<input type="submit" value="{$lng['menue']['main']['changelanguage']}" />
				</p>
				</fieldset>
			</form>
		</section>
	</article>
$footer
