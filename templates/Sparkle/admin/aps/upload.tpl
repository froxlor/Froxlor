<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/aps_upload.png" alt="" />&nbsp;
			{$lng['aps']['upload']}
		</h2>
	</header>

	<section class="midform midformaps_1 bradiusodd">
	
		<form action="$filename" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;{$lng['aps']['upload']}</legend>
				<p>
					<strong>{$lng['aps']['upload_description']}</strong><br />
					<a href="http://www.apsstandard.org/" rel="external">http://www.apsstandard.org/</a>
				</p>
				{$Output}

				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="submit" value="{$lng['aps']['upload']}" />
			</fieldset>
		</form>
	</section>

</article>

