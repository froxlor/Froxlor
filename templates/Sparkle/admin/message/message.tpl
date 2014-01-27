$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/messages_big.png" alt="" />&nbsp;
				{$lng['admin']['message']}
			</h2>
		</header>

		<if 0 < $success >
			<div class="successcontainer bradius">
				<div class="successtitle">{$lng['success']['success']}</div>
				<div class="success">{$successmessage}</div>
			</div>
		</if>

		<section>
			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<input type="hidden" name="action" value="$action"/>
				<input type="hidden" name="send" value="send"/>
				
				<table class="full">
					<tr>
						<td><b><label for="receipient">{$lng['admin']['receipient']}</label></b></td>
						<td><select name="receipient" id="receipient">$receipients</select></td>
					</tr>
					<tr>
						<td><b><label for="subject">{$lng['admin']['subject']}</label></b></td>
						<td><input type="text" name="subject" id="subject" value="{$lng['admin']['nosubject']}"/></td>
					</tr>
					<tr>
						<td><b><label for="message">{$lng['admin']['text']}</label></b></td>
						<td><textarea rows="12" cols="80" name="message" id="message"></textarea></td>
					</tr>
					<tfoot>
						<tr>
							<td align="right" colspan="2">
								<input type="submit" value="{$lng['panel']['send']}" />
							</td>
						</tr>
					</tfoot>
				</table>
			</form>

		</section>

	</article>
$footer
