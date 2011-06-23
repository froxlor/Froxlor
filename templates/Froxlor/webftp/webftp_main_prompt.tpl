<style type="text/css">
<!--
.Stil1 {
color: #FF0000;
font-weight: bold;
}
-->
</style>
<table cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="10" align="left"><span class="Stil1">{$action_text}</span></td>
	</tr>
	<tr>
		<td colspan="10" align="left">
			&nbsp;<input type="hidden" name="chmod" value="{$chmod}" />
			<input type="hidden" name="move_to" value="{$move_to}" />
			<input type="hidden" name="action" value="multiple">
			<input type="hidden" name="op" value="{$op}" />
		</td>
	</tr>
	<tr>
	<td colspan="10" align="left"><input type="submit" NAME="yes" VALUE="$language[temp_prompt_yes]"><input type="submit" NAME="no" VALUE="$language[temp_prompt_no]">
	</td>
	</tr>
	</tr>
</table>
</form>