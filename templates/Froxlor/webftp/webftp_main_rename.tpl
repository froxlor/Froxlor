<table border="0" cellspacing="2" cellpadding="2">
	<form name="rename" method="post" action="webftp.php">
		<tr>
			<td>
				<input type="hidden" name="op" value="do" />
				<input type="hidden" name="action" value="rename" />
				<input type="hidden" name="file" value="{$file}" />
				<input type="hidden" name="currentDir" value="{$currentDir}" />
				{$rename_text}
			</td>
			<td>
				<input type="text" name="file2" value="{$file}" />
			</td>
			<td>
				<input type="submit" name="submit" value="{t}Rename / Move{/t}">
			</td>
		</tr>
	</form>
</table>
<hr />
