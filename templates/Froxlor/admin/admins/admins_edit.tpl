$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/{$image}" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<if $result['adminid'] == $userinfo['userid']>
			<div class="warningcontainer bradius">
				<div class="warning">{$lng['error']['youcanteditallfieldsofyourself']}</div>
			</div>
		</if>

		<section class="fullform bradiusodd">

			<form action="{$linker->getLink(array('section' => 'admins'))}" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$title}</legend>

					<table class="formtable">
						{$admin_edit_form}
					</table>

					<p style="display: none;">
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
	<br />
	<article>
		<section class="fullform bradiusodd">
			<p style="margin-left:15px;">
				<span style="color:#ff0000;">*</span>: {$lng['admin']['valuemandatory']}
			</p>
		</section>
	</article>
$footer

