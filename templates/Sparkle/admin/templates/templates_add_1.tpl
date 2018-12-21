$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/templates_add_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['admin']['templates']['template_add']}
			</h2>
		</header>

		<section>
			<form method="post" action="{$linker->getLink(array('section' => 'templates'))}" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<input type="hidden" name="s" value="$s" />
					<input type="hidden" name="page" value="$page" />
					<input type="hidden" name="action" value="$action" />
					<input type="hidden" name="prepare" value="prepare" />
						
					<table class="tiny center">
						<tr>
							<td><label for="mailLanguage">{\Froxlor\I18N\Lang::getAll()['login']['language']}:</label></td>
							<td><select id="mailLanguage" name="language">$language_options</select></td>
						</tr>
						<tr>
							<td><label for="mailTemplate">{\Froxlor\I18N\Lang::getAll()['admin']['templates']['action']}:</label></td>
							<td><select id="mailTemplate" name="template">$template_options</select></td>
						</tr>
						<tfoot>
							<tr>
								<td align="left"><input type="reset" value="{\Froxlor\I18N\Lang::getAll()['panel']['cancel']}" class="historyback" /></td>
								<td align="right"><input type="submit" value="{\Froxlor\I18N\Lang::getAll()['panel']['next']}" /></td>
							</tr>
						</tfoot>
					</table>
				</fieldset>
			</form>
		</section>
	</article>

$footer
