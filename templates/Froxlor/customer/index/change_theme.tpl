$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/display.png" alt="" />&nbsp;
				{$lng['menue']['main']['changetheme']}
			</h2>
		</header>

		<section class="tinyform bradiusodd">
			<form method="post" action="{$linker->getLink(array('section' => 'index'))}" enctype="application/x-www-form-urlencoded">
				<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;{$lng['menue']['main']['changetheme']}</legend>
				<p>
					<label for="theme">{$lng['panel']['theme']}:</label>&nbsp;
					<select id="theme" name="theme">$theme_options</select>
				</p>
				<p class="submit">
					<input type="hidden" name="s" value="$s" />
					<input type="hidden" name="page" value="$page" />
					<input type="hidden" name="send" value="send" />
					<input class="bottom" type="submit" value="{$lng['menue']['main']['changetheme']}" />
				</p>
				</fieldset>
			</form>
		</section>
	</article>
$footer

