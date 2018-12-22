$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/display_big.png" alt="" />&nbsp;
				{$lng['menue']['main']['changetheme']}
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
						<td width="50%"><label for="theme">{$lng['panel']['theme']}:</label></td>
						<td><select id="theme" name="theme">$theme_options</select></td>
					</tr>
					<tfoot>
						<tr>
							<td colspan="2" align="center">					
								<input class="bottom" type="submit" value="{$lng['menue']['main']['changetheme']}" />
							</td>
						</tr>
					</tfoot>
				</table>
				</fieldset>
			</form>
		</section>
	</article>
$footer

