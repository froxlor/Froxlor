$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/templates_add.png" alt="" />&nbsp;
				{$lng['admin']['templates']['template_add']}
			</h2>
		</header>

		<section class="tinyform bradiusodd">
			<form method="post" action="{$linker->getLink(array('section' => 'templates'))}" enctype="application/x-www-form-urlencoded">
				<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;{$lng['menue']['main']['changelanguage']}</legend>
				<p>
					<label for="language">{$lng['login']['language']}:</label>&nbsp;
					<select id="language" name="language">$language_options</select>
				</p>
				<p class="submit">
					<input type="hidden" name="s" value="$s" />
					<input type="hidden" name="page" value="$page" />
					<input type="hidden" name="action" value="$action" />
					<input type="hidden" name="prepare" value="prepare" />
					<input type="submit" value="{$lng['panel']['next']}" />
				</p>
				</fieldset>
			</form>
		</section>
	</article>
$footer

