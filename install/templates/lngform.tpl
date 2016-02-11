		<form action="{$formaction}" method="get">
			<fieldset>
				<legend>{$this->_lng['install']['lngtitle']}</legend>
				<table class="noborder">
					<tr>
						<td>
							<label for="language">{$this->_lng['install']['language']}:</label>
						</td>
						<td align="right">
							<select name="language" id="language" class="dropdown">
								{$language_options}
							</select>
							<input type="hidden" name="check" value="1" />
							<input type="submit" name="chooselang" value="{$this->_lng['install']['lngbtn_go']}" />
						</td>
					</tr>
				</table>
			</fieldset>
		</form>
		<hr class="line">