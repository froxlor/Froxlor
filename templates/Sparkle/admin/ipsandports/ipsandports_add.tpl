$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/ipsports_add_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'ipsandports'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />

				<table class="full">
					{$ipsandports_add_form}
				</table>
			</form>

		</section>

	</article>
$footer
