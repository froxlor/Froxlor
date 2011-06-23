			<table cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="10" align="left">{t}Selected file(s){/t}:</td>
				</tr>
				<tr>
					<td colspan="10" align="left">
						<input type="radio" name="op" value="delete" />{t}Delete{/t}
					</td>
				</tr>
				<tr>
					<td colspan="10" align="left">
						<input name="op" type="radio" value="chmod" />
						<input type="text" name="chmod" value="755" maxlength="3" size="5" />{t}Change permission to{/t}
					</td>
				</tr>
				<tr>
					<td colspan="10" align="left">
						<input name="op" type="radio" value="move" checked="checked" />
						<input name="move_to" type="text" id="move_to" value="{$currentDir}" size="30" />{t}Move to{/t}
					</td>
				</tr>
				<tr>
					<td colspan="10" align="left">
						<input type="submit" name="submit" value="{t}Do it{/t}" />
					</td>
				</tr>
			</table>
		</form>
	</section>
</article>