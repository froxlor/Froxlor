$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings.png" alt="{$lng['admin']['configfiles']['serverconfiguration']}" />&nbsp;
				{$lng['admin']['configfiles']['serverconfiguration']} &nbsp;
				[<a href="{$linker->getLink(array('section' => 'configfiles', 'page' => 'configfiles'))}">{$lng['admin']['configfiles']['wizard']}</a>]
			</h2>
		</header>

		<section class="fullform bradiusodd">
			<form action="{$linker->getLink(array('section' => 'configfiles'))}" method="get" enctype="application/x-www-form-urlencoded">
			<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['admin']['configfiles']['serverconfiguration']}</legend>
						<input type="hidden" name="s" value="$s" />
						<input type="hidden" name="page" value="$page" />

						<table class="formtable">
							$distributions
						</table>
			</fieldset>
			</form>
		</section>
	</article>
$footer
