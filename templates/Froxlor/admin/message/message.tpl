$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/messages.png" alt="" />&nbsp;
				{$lng['admin']['message']}
			</h2>
		</header>

		<section class="midform bradiusodd">

			<if 0 < $success >
				<div class="successcontainer bradius">
					<div class="successtitle">{$lng['success']['success']}</div>
					<div class="success">{$successmessage}</div>
				</div>
			</if>

			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;{$lng['admin']['message']}</legend>
				<p>
					<label for="receipient">{$lng['admin']['receipient']}</label>&nbsp;
					<select name="receipient" id="receipient">$receipients</select>
				</p>
				<p>
					<label for="subject">{$lng['admin']['subject']}</label>&nbsp;
					<input type="text" name="subject" id="subject" value="{$lng['admin']['nosubject']}"/>
				</p>
				<p>
					<label for="message">{$lng['admin']['text']}</label>&nbsp;
					<textarea rows="12" name="message" id="message"></textarea>
				</p>
				<p class="submit">
					<input type="hidden" name="s" value="$s"/>
					<input type="hidden" name="page" value="$page"/>
					<input type="hidden" name="action" value="$action"/>
					<input type="hidden" name="send" value="send"/>
					<input type="submit" value="{$lng['panel']['send']}" />
				</p>
				</fieldset>
			</form>

		</section>

	</article>
$footer
