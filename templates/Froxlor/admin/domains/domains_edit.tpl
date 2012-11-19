$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/{$image}" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section class="fullform bradiusodd">

			<form action="{$linker->getLink(array('section' => 'domains'))}" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$title}</legend>

					<div id="speciallogwarningpopup" name="speciallogwarningpopup" align="center">
						<div class="warningtitle">{$lng['admin']['delete_statistics']}</div>
						</p>{$lng['admin']['speciallogwarning']}</p>
						<input type="text" name="delete_stats" id="delete_stats"></p>
						<div style="margin-top:10px;">
							<input type="button" class="yesbutton" name="verifybutton" value="{$lng['panel']['delete']}" id="speciallogyesbutton" />&nbsp;
							<input type="button" class="nobutton" value="{$lng['panel']['cancel']}" id="speciallognobutton" />
						</div>
					</div>



					<table class="formtable">
						{$domain_edit_form}
					</table>

					<p style="display:none;">
						<input type="hidden" name="delete_statistics_str" id="delete_statistics_str" value="{$lng['admin']['delete_statistics']}">
						<input type="hidden" name="speciallogverified" id="speciallogverified" value="0" />
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
