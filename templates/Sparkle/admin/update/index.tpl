$header
	<header>
		<h2>{\Froxlor\I18N\Lang::getAll()['update']['update']}</h2>
	</header>
	<article>
		<form action="{$linker->getLink(array('section' => 'updates'))}" method="post">
			{$update_information}
			<p class="submit">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<input type="hidden" name="send" value="send" />
				<input type="submit" value="{\Froxlor\I18N\Lang::getAll()['update']['proceed']}" />
			</p>
		</form>
	</article>
$footer
