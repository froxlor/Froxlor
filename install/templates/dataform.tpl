		<form action="{$formaction}" method="get">
			<fieldset>
				<legend>{$this->_lng['install']['title']}</legend>
				{$formdata}
				<p class="submit">
					<input type="hidden" name="check" value="1" />
					<input type="submit" name="chooselang" value="{$this->_lng['install']['btn_go']}" />
				</p>
			</fieldset>
		</form>
		<aside>&nbsp;</aside>
