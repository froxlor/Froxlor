		<form action="{$formaction}" method="post">
			<fieldset>
				<legend>{$this->_lng['install']['welcometext']}</legend>
				{$formdata}
				<p class="submit">
					<input type="hidden" name="check" value="1" />
					<input type="hidden" name="language" value="{$language}" />
					<input type="hidden" name="installstep" value="1" />
					<input class="bottom" type="submit" name="submitbutton" value="{$this->_lng['click_here_to_continue']}" />
				</p>
			</fieldset>
		</form>
		<aside>&nbsp;</aside>
