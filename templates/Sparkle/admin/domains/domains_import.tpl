$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/domain_add_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<div class="messagewrapperfull">
		<div class="warningcontainer bradius">
			<div class="warningtitle">{$lng['admin']['note']}</div>
			<div class="warning">{$lng['domains']['import_description']}</div>
		</div>
		</div>

		<section>

			<form action="{$linker->getLink(array('section' => 'domains'))}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />

				<table class="full">
					{$domain_import_form}
				</table>
			</form>

		</section>
		<br />
		<section>
			<p>
				<span class="red">*</span>: {$lng['admin']['valuemandatory']}
			</p>
		</section>
	</article>
$footer
