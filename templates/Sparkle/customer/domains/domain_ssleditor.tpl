$header
<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/ssl_big.png" alt="{$title}" />&nbsp;
			{$title}
		</h2>
	</header>

	<section class="fullform bradiusodd">

			<form action="{$linker->getLink(array('section' => 'domains'))}" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$title}</legend>

					<table class="formtable">
						  {$ssleditor_form}
					</table>

					<p style="display: none;">
						<if $do_insert == 1>
							<input type="hidden" name="do_insert" value="1" />
						</if>
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
