$header
	<header>
		<h2>{$lng['update']['update']}</h2>
	</header>
	<article>
		<form action="{$linker->getLink(array('section' => 'updates'))}" method="post">
			{$update_information}
			<p class="submit">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<input type="hidden" name="send" value="send" />
				<input type="submit" value="{$lng['update']['proceed']}" />
			</p>
		</form>
	</article>
$footer
