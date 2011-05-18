$header
	<form method="post" action="$filename">
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_60">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/Classic/title.gif" alt="$title" />&nbsp;{$title}</b></td>
			</tr>
			{$email_edit_form}
			<tr>
				<td class="maintitle" colspan="2"><a href="$filename?page=emails&amp;s=$s">{$lng['emails']['back_to_overview']}</a></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
