<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/aps.png" alt=""{$lng['aps']['search']} />&nbsp;
			{$lng['aps']['search']}
		</h2>
	</header>
	
	<section class="fullform bradiusodd">

			<form action="$filename" method="get" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['aps']['search']}</legend>

					<table class="formtable">
						<tr>
							<td>{$lng['aps']['search_description']}</td>
							<td><input type="text" name="keyword" class="text" value="$Keyword"/></td>
						</tr>
						<tr>
							<td style="text-align: right;" colspan="2"><input  type="submit" value="{$lng['aps']['search']}" /></td>
						</tr>
					</table>

					<p style="display: none;">
						<input type="hidden" name="s" value="$s" />
						<input type="hidden" name="page" value="$page" />
						<input type="hidden" name="action" value="$action" />
						<input type="hidden" name="send" value="send" />
					</p>
				</fieldset>
			</form>
	</section>
</article>
