$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/user_edit_big.png" alt="{$title}" />&nbsp;{$title}
			</h2>
		</header>

		<if $result['adminid'] == $userinfo['userid']>
			<div class="warningcontainer bradius">
				<div class="warning">{$lng['error']['youcanteditallfieldsofyourself']}</div>
			</div>
		</if>

		<section class="fullform bradius">

			<form action="{$linker->getLink(array('section' => 'admins'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="id" value="$id" />
				<input type="hidden" name="send" value="send" />

				<table class="formtable">
					{$admin_edit_form}
				</table>
			</form>

		</section>

	</article>
	<br />
	<article>
		<section class="fullform bradius">
			<p>
				<span class="red">*</span>: {$lng['admin']['valuemandatory']}
			</p>
		</section>
	</article>
$footer

