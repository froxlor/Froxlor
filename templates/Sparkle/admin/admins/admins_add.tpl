$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/user_add_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section class="fullform bradius">

			<form action="{$linker->getLink(array('section' => 'admins'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />

				<table class="formtable">
					{$admin_add_form}
				</table>
			</form>

		</section>

	</article>
	<br />
	<article>
		<section class="fullform bradius">
			<p>
				<span class="red">*</span>: {$lng['admin']['valuemandatory']}<br />
				<span class="red">**</span>: {$lng['admin']['valuemandatorycompany']}
			</p>
		</section>
	</article>
$footer
