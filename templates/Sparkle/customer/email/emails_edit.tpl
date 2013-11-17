$header
<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/email_edit_big.png" alt="{$title}" />&nbsp;
			{$title}
		</h2>
	</header>

	<section class="fullform bradius">

		<form action="{$linker->getLink(array('section' => 'email'))}" method="post" enctype="application/x-www-form-urlencoded">
			<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;{$title}</legend>

				<table class="formtable">
					<thead>
						<tr><th colspan="2"></th></tr>
					</thead>
					{$email_edit_form}
					<tfoot>
					<tr>
						<td colspan="2"><a href="{$linker->getLink(array('section' => 'email', 'page' => 'emails'))}">{$lng['emails']['back_to_overview']}</a></td>
					</tr>
					</tfoot>
				</table>
			</fieldset>
		</form>

	</section>
</article>
$footer
