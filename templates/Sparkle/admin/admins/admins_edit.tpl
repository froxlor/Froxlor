$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/user_edit_big.png" alt="{$title}" />&nbsp;{$title}
			</h2>
		</header>

		<if $result['adminid'] == \Froxlor\User::getAll()['userid']>
			<div class="warningcontainer bradius">
				<div class="warning">{\Froxlor\I18N\Lang::getAll()['error']['youcanteditallfieldsofyourself']}</div>
			</div>
		</if>

		<section>

			<form action="{$linker->getLink(array('section' => 'admins'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="id" value="$id" />
				<input type="hidden" name="send" value="send" />

				<table class="full">
					{$admin_edit_form}
				</table>
			</form>

		</section>

	</article>
	<br />
	<article>
		<section>
			<p>
				<span class="red">*</span>: {\Froxlor\I18N\Lang::getAll()['admin']['valuemandatory']}
			</p>
		</section>
	</article>
$footer

