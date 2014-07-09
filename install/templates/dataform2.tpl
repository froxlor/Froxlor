		<p style="margin: 20px 20px 0 !important">{$this->_lng['install']['welcometext']}</p>
		<form action="{$formaction}" method="post">
			<hr class="line">
			<fieldset>
				{$formdata}
			</fieldset>
			<aside>
			<input type="hidden" name="check" value="1" />
			<input type="hidden" name="language" value="{$language}" />
			<input type="hidden" name="installstep" value="1" />
			<input class="bottom" type="submit" name="submitbutton" value="{$this->_lng['click_here_to_continue']}" />
			</aside>
		</form>