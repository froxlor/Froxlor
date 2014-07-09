$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/error_report_big.png" alt="" />&nbsp;
				{$lng['error']['send_report_title']}
			</h2>
		</header>

		<section>
			<form method="post" action="{$linker->getLink(array('section' => 'index', 'errorid' => $errid))}" enctype="application/x-www-form-urlencoded">
				<fieldset>
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="send" value="send" />
				<table class="full">
					<thead>
					<tr>
						<th>
							<p>{$lng['error']['send_report_desc']}</p>
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
								<input class="bottom" type="submit" value="{$lng['error']['send_report']}" />
							</td>
						</tr>
					</tfoot>
				</table>
				</fieldset>
			</form>
		</section>
	</article>
$footer
