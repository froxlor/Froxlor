 $header
	<article>
		<header>
			<h2>
				<img src="images/Froxlor/icons/autoresponder.png" alt="" />&nbsp;
				{$lng['menue']['email']['autoresponder']}
			</h2>
		</header>

		<section>

			<if ($userinfo['email_autoresponder_used'] < $userinfo['email_autoresponder'] || $userinfo['email_autoresponder'] == '-1') && 15 < $count >
			<div class="overviewadd">
				<img src="images/Froxlor/icons/add_autoresponder.png" alt="" />&nbsp;
				<a href="$filename?&amp;action=add&amp;s=$s">{$lng['autoresponder']['autoresponder_add']}</a>
			</div>
			</if>

			<table class="bradiusodd">
				<thead>
					<tr>
						<th>{$lng['emails']['emailaddress']}</th>
						<th>{$lng['autoresponder']['active']}</th>
						<th>{$lng['autoresponder']['startenddate']}</th>
						<th>{$lng['panel']['options']}</th>
					</tr>
				</thead>

				<tbody>
					{$autoresponder}
				</tbody>
			</table>

			<if ($userinfo['email_autoresponder_used'] < $userinfo['email_autoresponder'] || $userinfo['email_autoresponder'] == '-1') >
			<div class="overviewadd">
				<img src="images/Froxlor/icons/add_autoresponder.png" alt="" />&nbsp;
				<a href="$filename?&amp;action=add&amp;s=$s">{$lng['autoresponder']['autoresponder_add']}</a>
			</div>
			</if>

		</section>
	</article>
$footer

