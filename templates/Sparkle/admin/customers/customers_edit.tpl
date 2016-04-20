$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/user_edit_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'customers'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="id" value="$id" />
				<input type="hidden" name="send" value="send" />
				<input type="password" name="fakepwd" class="input-fake" />
			
				<table class="full">
					{$customer_edit_form}
				</table>
			</form>

		</section>

	</article>
	<br />
	<article>
		<section>
			<p>
				<span class="red">*</span>: {$lng['admin']['valuemandatory']}<br />
				<span class="red">**</span>: {$lng['admin']['valuemandatorycompany']}
			</p>
		</section>
	</article>
$footer
