$header
<article>
	<header>
		<h2>
			<img src="images/Froxlor/{$image}" alt="{$title}" />&nbsp;
			{$title}
		</h2>
	</header>

	<section class="fullform bradiusodd">

		<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
			<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;{$title}</legend>

				<table class="formtable">
					{$email_edit_form}
					<tr>
						<td class="maintitle" colspan="2"><a href="$filename?page=emails&amp;s=$s">Back to overview (@TODO lng)</a></td>
					</tr>
				</table>
			</fieldset>
		</form>

	</section>
</article>
$footer
