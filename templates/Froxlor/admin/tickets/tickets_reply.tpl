$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/{$image}" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<if 0 < $isclosed >
			<div class="messagewrapperfull">
				<div class="warningcontainer bradius">
					<div class="warningtitle">{$lng['ticket']['ticket_reopen']}</div>
					<div class="warning"><br /><strong><a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'reopen', 'id' => $id))}">{$lng['ticket']['ticket_reopen']}</a></strong></div>
				</div>
			</div>
		</if>

		<if 0 < $ticket_replies_count >
			$ticket_replies
		</if>

		<section class="fullform bradiusodd">

			<form action="{$linker->getLink(array('section' => 'tickets'))}" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$title}</legend>

					<table class="formtable">
						{$ticket_reply_form}
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
$footer
