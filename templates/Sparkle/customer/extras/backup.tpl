$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/backup_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<if !empty($existing_backupJob)>
			<div class="messagewrapperfull">
			<div class="warningcontainer bradius">
				<div class="warningtitle">{\Froxlor\I18N\Lang::getAll()['admin']['warning']}</div>
				<div class="warning">{\Froxlor\I18N\Lang::getAll()['error']['customerhasongoingbackupjob']}</div>
			</div>
			</div>
		</if>

		<section>

			<form action="{$linker->getLink(array('section' => 'extras'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />

				<table class="full">
					{$backup_form}
				</table>
			</form>

		</section>

	</article>
$footer
