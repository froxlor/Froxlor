$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/user_add_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>
		<script type="text/javascript" src="templates/{$theme}/assets/js/customers.js"></script>

		<section>

			<form action="{$linker->getLink(array('section' => 'customers'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />
				
				<table class="full">
					{$customer_add_form}
				</table>
			</form>

		</section>

	</article>
	<br />
	<article>
		<section>
			<p>
				<span class="red">*</span>: {\Froxlor\I18N\Lang::getAll()['admin']['valuemandatory']}<br />
				<span class="red">**</span>: {\Froxlor\I18N\Lang::getAll()['admin']['valuemandatorycompany']}
			</p>
		</section>
	</article>
$footer
