		<section class="dboarditemfull bradiusodd">
		<form name="putmForm" method="POST" action="webftp.php">
			<input type="hidden" name="op" value="delete"/>
			<input type="hidden" name="action" value="multiple" />
			<input type="hidden" name="currentDir" value="{$currentDir}" />
			<input type="hidden" name="mode" value="{$mode}" />
			<table class="bradiusodd">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>{t}Filename{/t}</th>
						<th>{t}Size{/t}</th>
						<th>{t}Date{/t}</th>
						<th>{t}Permissions{/t}</th>
						<th>{t}User{/t}</th>
						<th>{t}Group{/t}</th>
						<th>{t}Options{/t}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>&nbsp;</td>
						<td>
							<a href="webftp.php?action=cd&amp;file=..&amp;currentDir={$currentDir}"><img src="templates/{$theme}/assets/img/icons/parent_20.png" height="20" width="20" align="top" border="0"></a>
						</td>
						<td align="left" colspan="10">
							<a href="webftp.php?action=cd&amp;file=..&amp;currentDir={$currentDir}">..</a>
						</td>
					</tr>
					{$output_dir}
					{$output_link}
					{$output_file}
				</tbody>
				<tfoot>
					<tr>
						<td colspan="10">
							{t}Files{/t}: <strong>{$countArray.file}</strong>; {t}Complete filesize{/t}: <strong>{$countArray.filesize}</strong>; {t}Symlinks{/t}: <strong>{$countArray.link}</strong>; {t}Directories{/t}: <strong>{$countArray.dir}</strong>; {t}Complete directorysize{/t}: <strong>{$countArray.dirsize}</strong>
						</td>
					</tr>
				</tfoot>
			</table>
		</section>
