$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/display_big.png" alt="" />&nbsp;
				Send error report
			</h2>
		</header>

		<section>
			<form method="post" action="{$linker->getLink(array('section' => 'index', 'errorid' => $errid))}" enctype="application/x-www-form-urlencoded">
				<fieldset>
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="send" value="send" />
				<table class="bradius">
					<thead>
					<tr>
						<th>
							<p>Thank you for reporting this error and helping us to make froxlor better.</p>
							<p>This is the e-mail that will be sent to the froxlor developer team:</p>
						</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>
							<code>{$mail_html}</code>
						</td>
					</tr>
					</tbody>
					<tfoot>
						<tr>
							<td align="center">					
								<input class="bottom" type="submit" value="Send report" />
							</td>
						</tr>
					</tfoot>
				</table>
				</fieldset>
			</form>
		</section>
	</article>
$footer
