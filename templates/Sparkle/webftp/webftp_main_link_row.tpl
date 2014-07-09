<tr {$checked_color}>
	<td><input type="checkbox" name="file[]" value="{$myDir.name}" {$checked} /></td>
	<td><a href="webftp.php?action=cd&amp;file={$myDir.name}&amp;currentDir={$currentDir}"><img src="templates/{$theme}/assets/img/icons/link_20.png" align="top" border="0" /></a></td>
	<td><a href="webftp.php?action=cd&amp;file={$myDir.name}&amp;currentDir={$currentDir}">{$myDir.name}</a></td>
	<td align=right>{$myDir.size}</td>
	<td>{$myDir.date}</td>
	<td>{$myDir.perms}</td>
	<td>{$myDir.user}</td>
	<td>{$myDir.group}</td>
	<td>
		<a href="webftp.php?action=deldir&amp;file={$myDir.name}&amp;currentDir={$currentDir}">
			<img src="templates/{$theme}/assets/img/icons/delete_20.png" border="0" alt="{t}Delete{/t}">
		</a>&nbsp;
		<a href="webftp.php?action=rename&amp;op=show&amp;file={$myDir.name}&currentDir={$currentDir}">
			<img src="templates/{$theme}/assets/img/icons/rename_20.png" border="0" alt="{t}Rename{/t}">
		</a><br />
		<small>{t}Symbolic link to{/t}: {$myDir.target}</small>
	</td>
</tr>