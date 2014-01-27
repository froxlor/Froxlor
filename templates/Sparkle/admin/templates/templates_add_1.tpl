$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/templates_add_big.png" alt="" />&nbsp;
				{$lng['admin']['templates']['template_add']}
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
							<td><label for="language">{$lng['login']['language']}:</label></td>
							<td><select id="language" name="language">$language_options</select></td>
						</tr>
						<tfoot>
							<tr>
								<td colspan="2" align="center"><input type="submit" value="{$lng['panel']['next']}" /></td>
							</tr>
						</tfoot>
					</table>
				</fieldset>
			</form>
		</section>
	</article>
$footer
