$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/{$image}" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section class="fullform bradiusodd">

			<form action="{$linker->getLink(array('section' => 'extras'))}" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$title}</legend>

					<table class="formtable">
						{$htpasswd_edit_form}
					</table>

					<p style="display: none;">
						<input type="hidden" name="s" value="$s" />
						<input type="hidden" name="page" value="$page" />
						<input type="hidden" name="action" value="$action" />
						<input type="hidden" name="id" value="$id" />
						<input type="hidden" name="send" value="send" />
					</p>
				</fieldset>
			</form>

		</section>

	</article>
$footer
