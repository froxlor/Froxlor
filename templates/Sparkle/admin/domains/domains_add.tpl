$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/domain_add_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>
		<script type="text/javascript" src="templates/{$theme}/assets/js/domains.js"></script>

		<section>

			<form action="{$linker->getLink(array('section' => 'domains'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />

				<table class="full">
					{$domain_add_form}
				</table>
			</form>

		</section>
		<br />
		<section>
			<p>
				<span class="red">*</span>: {\Froxlor\I18N\Lang::getAll()['admin']['valuemandatory']}
			</p>
		</section>
	</article>
$footer
