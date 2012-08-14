	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/group_edit.png" alt="" />&nbsp;
				{$connected_to} ({$mode})
			</h2>
		</header>
		{if isset($successmessage)}
			<div class="successcontainer bradius">
				<div class="successtitle">{t}Success{/t}</div>
				<div class="success">{$successmessage|escape:'htmlall'|nl2br}</div>
			</div>
		{/if}
		{if isset($errormessage)}
			<div class="errorcontainer bradius">
				<div class="errortitle">{t}Error{/t}</div>
				<div class="error">{$errormessage|escape:'htmlall'|nl2br}</div>
			</div>
		{/if}
