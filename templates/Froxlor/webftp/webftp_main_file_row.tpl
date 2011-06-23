<tr {$checked_color}>
	<td><input type="checkbox" name="file[]" value="{$myDir.name}" {$checked} /></td>
	<td><a href="webftp.php?action=get&amp;file={$myDir.name}&amp;currentDir={$currentDir}"><img src="{$image_folder}/icons/file.gif" align="top" border="0" /></a></td>
	<td><a href="webftp.php?action=get&amp;file={$myDir.name}&amp;currentDir={$currentDir}">{$myDir.name}</a></td>
	<td align=right>{$myDir.size}</td>
	<td>{$myDir.date}</td>
	<td>{$myDir.perms}</td>
	<td>{$myDir.user}</td>
	<td>{$myDir.group}</td>
	<td><a href="webftp.php?action=delfile&amp;file={$myDir.name}&amp;currentDir={$currentDir}"><img src="{$image_folder}/icons/delete.png" border="0" alt="{t}Delete{/t}"></a></td>
	<td><a href="webftp.php?action=rename&amp;op=show&amp;file={$myDir.name}&currentDir={$currentDir}"><img src="{$image_folder}/icons/rename.gif" border="0" alt="{t}Rename{/t}"></a></td>
	<td>{if $editable}<a href="webftp.php?action=edit&amp;op=open&amp;file={$myDir.name}&amp;currentDir={$currentDir}"><img src="{$image_folder}/icons/edit.png" border="0" alt="{t}Edit{/t}"></a>{/if}</td>
	<td>&nbsp;</td>
</tr>