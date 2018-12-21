$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/lock_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['menue']['main']['changepassword']}
			</h2>
		</header>

		<section>
			<form method="post" action="{$linker->getLink(array('section' => 'index'))}" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<input type="hidden" name="s" value="$s" />
					<input type="hidden" name="page" value="$page" />
					<input type="hidden" name="send" value="send" />
					<table class="middle center">
						<tr>
							<td><label for="old_password">{\Froxlor\I18N\Lang::getAll()['changepassword']['old_password']}:</label></td>
							<td><input type="password" id="old_password" name="old_password" /></td>
						</tr>
						<tr>
							<td><label for="new_password">{\Froxlor\I18N\Lang::getAll()['changepassword']['new_password']}:</label></td>
							<td><input type="password" id="new_password" name="new_password" /></td>
						</tr>
						<tr>
							<td><label for="new_password_confirm">{\Froxlor\I18N\Lang::getAll()['changepassword']['new_password_confirm']}:</label></td>
							<td><input type="password" id="new_password_confirm" name="new_password_confirm" /></td>
						</tr>
						<tfoot>
							<tr>
								<td colspan="2" align="center">
									<input type="submit" value="{\Froxlor\I18N\Lang::getAll()['menue']['main']['changepassword']}" />
								</td>
							</tr>
						</tfoot>
					</table>
				</fieldset>
			</form>
		</section>
	</article>
$footer
