<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable" style="border: solid 1px #B7B7B7;">
	<tr>
		<td width="30" valign="top" style="padding: 15px; background-color: #EBECF5;"><img src="templates/{$theme}/assets/img/info.png" alt="" /></td>
		<td>
		$Message
		<form name="continue" action="$filename" method="post">
			<input type="submit" name="answer" value="{$lng['panel']['yes']}" />
			<input type="hidden" name="save" value="1"/>
			<input type="hidden" name="s" value="$s"/>
			<input type="hidden" name="action" value="$action"/>
			$Ids
		</form>
		<br/>
		<form name="back" action="$filename" method="post">
			<input type="submit" name="submit" value="{$lng['panel']['no']}" />
			<input type="hidden" name="action" value="$action"/>
			<input type="hidden" name="s" value="$s"/>
		</form>
		<br/>
		</td>
	</tr>
</table>
<br/>
