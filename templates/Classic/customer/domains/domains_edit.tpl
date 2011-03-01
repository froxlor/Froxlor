$header
	<form method="post" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="id" value="$id" />
		<input type="hidden" name="action" value="$action" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/Classic/title.gif" alt="$title" />&nbsp;{$title}</b></td>
			</tr>
			{$subdomain_edit_form}
		</table>
	</form>
	<br />
	<br />
$footer

