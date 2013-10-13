		<form action="{$formaction}" method="get">
			<fieldset>
				<legend>{$this->_lng['install']['lngtitle']}</legend>
				<p>
					<label for="language">{$this->_lng['install']['language']}:</label>&nbsp;
					<select name="language" id="language">
						{$language_options}
					</select>
				</p>
				<p class="submit">
					<input type="hidden" name="check" value="1" />
					<input type="submit" name="chooselang" value="{$this->_lng['install']['lngbtn_go']}" />
				</p>
			</fieldset>
		</form>
		<aside>&nbsp;</aside>
