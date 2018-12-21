$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/flag.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['menue']['main']['changelanguage']}
			</h2>
		</header>

		<section>
			<form method="post" action="{$linker->getLink(array('section' => 'index'))}" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<input type="hidden" name="s" value="$s" />
					<input type="hidden" name="page" value="$page" />
					<input type="hidden" name="send" value="send" />
					<table class="tiny center">
						<tr>
							<td><label for="def_language">{\Froxlor\I18N\Lang::getAll()['login']['language']}:</label></td>
							<td><select id="def_language" name="def_language">$language_options</select></td>
						</tr>
						<tfoot>
							<tr>
								<td colspan="2" align="center">
									<input type="submit" value="{\Froxlor\I18N\Lang::getAll()['menue']['main']['changelanguage']}" />
								</td>
							</tr>
						</tfoot>
					</table>
				</fieldset>
			</form>
		</section>
	</article>
$footer
