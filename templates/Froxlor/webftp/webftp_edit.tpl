	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/group_edit.png" alt="" />&nbsp;
				{t}Editing{/t}: <a href="webftp.php?action=cd&amp;file={$currentDir}">{$currentDir}</a>/{$file} ({$mode})
			</h2>
		</header>
		{if isset($successmessage)}
			<div class="successcontainer bradius">
				<div class="successtitle">{t}Success{/t}</div>
				<div class="success">{$successmessage}</div>
			</div>
		{/if}
		{if isset($errormessage)}
			<div class="errorcontainer bradius">
				<div class="errortitle">{t}Error{/t}</div>
				<div class="error">{$errormessage}</div>
			</div>
		{/if}
		<section >
			<form name="editForm" method="POST" action="webftp.php">
				<input type="hidden" name="action" value="edit" />
				<input type="hidden" name="op" value="save" />
				<input type="hidden" name="currentDir" value="{$currentDir}" />
				<input type="hidden" name="file" value="{$file}" />
				<input type="hidden" name="mode" value="{$mode}" />
			    <textarea name="fileContent" cols="80" rows="40" wrap="OFF" id="fileContent">{$myFileContent|escape:'htmlall'}</textarea>
			    <br />
			    <input type="submit" name="Submit" value="{t}Save file{/t}" />
			    <input type="button" name="Submit2" value="{t}Cancel{/t}" onClick="javascript:document.location.href='webftp.php?action=cd&amp;file={$currentDir}'" />
			</form>
		</section>
	</article>
