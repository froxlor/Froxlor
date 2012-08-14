$header
<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/{$image}" alt="{$title}" />&nbsp;
			{$title}
		</h2>
	</header>

	<section class="fullform bradiusodd">

		<form action="{$linker->getLink(array('section' => 'email'))}" method="post" enctype="application/x-www-form-urlencoded">
			<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;{$title}</legend>

				<table class="formtable">
					{$email_edit_form}
					<tr>
						<td class="maintitle" colspan="2"><a href="{$linker->getLink(array('section' => 'email', 'page' => 'emails'))}">{$lng['emails']['back_to_overview']}</a></td>
					</tr>
				</table>
			</fieldset>
		</form>

	</section>
</article>
$footer
