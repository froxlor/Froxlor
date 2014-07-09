		<section class="dboarditemfull bradiusodd">
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th colspan="10" align="left">{t}Selected file(s){/t}:</th>
				</tr>
				</thead>
				<tr>
					<td colspan="10" align="left">
						<input type="radio" name="op" value="delete" />{t}Delete{/t}
					</td>
				</tr>
				<tr>
					<td colspan="10" align="left">
						<input name="op" type="radio" value="chmod" />
						{t}Change permission to{/t}<input type="text" name="chmod" value="755" maxlength="3" size="5" />
					</td>
				</tr>
				<tr>
					<td colspan="10" align="left">
						<input name="op" type="radio" value="move" checked="checked" />
						{t}Move to{/t}<input name="move_to" type="text" id="move_to" value="{$currentDir}" size="30" />
					</td>
				</tr>
				<tfoot>
				<tr>
					<td colspan="10" align="left">
						<input type="submit" name="submit" value="{t}Do it{/t}" />
					</td>
				</tr>
				</tfoot>
			</table>
		</form>
	</section>
</article>