$header
<article>

	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/email_add_big.png" alt="{$title}" />&nbsp;
			{$title}
		</h2>
	</header>

	<if $domains == ''>
		<div class="messagewrapperfull">
			<div class="warningcontainer bradius">
				<div class="warningtitle">{$lng['admin']['warning']}</div>
				<div class="warning"><br /><strong>{$lng['emails']['noemaildomainaddedyet']}</strong></div>
			</div>
		</div>
	<else>
		<section>

			<form action="{$linker->getLink(array('section' => 'email'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />

				<table class="full">
					{$email_add_form}
				</table>
			</form>
		</section>
	</if>
</article>
$footer
