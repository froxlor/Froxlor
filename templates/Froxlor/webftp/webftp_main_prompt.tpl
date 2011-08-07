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
		<td colspan="10" align="left"><span class="Stil1">{$action_text|escape:'htmlall'|nl2br}</span></td>
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
	<td colspan="10" align="left"><input type="submit" name="yes" value="{t}Yes{/t}"><input type="submit" name="no" value="{t}No{/t}"></td>
	</tr>
	</tr>
</table>
</form>
