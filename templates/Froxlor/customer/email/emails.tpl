 $header
	<article>
		<header>
			<h2>
				<img src="images/Froxlor/icons/emails.png" alt="" />&nbsp;
				{$lng['menue']['email']['emails']}&nbsp;({$emailscount})
			</h2>
		</header>

		<section>

			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if ($userinfo['emails_used'] < $userinfo['emails'] || $userinfo['emails'] == '-1') && 15 < $emails_count && $emaildomains_count !=0 >
				<div class="overviewadd">
					<img src="images/Froxlor/icons/email_add.png" alt="" />&nbsp;
					<a href="$filename?page={$page}&amp;action=add&amp;s=$s">{$lng['emails']['emails_add']}</a>
				</div>
			</if>

			<table class="bradiusodd">
				<thead>
					<tr>
						<th>{$lng['emails']['emailaddress']}&nbsp;{$arrowcode['m.email_full']}</th>
						<th>{$lng['emails']['forwarders']}&nbsp;{$arrowcode['m.destination']}</th>
						<th>{$lng['emails']['account']}</th>
						<th>{$lng['emails']['catchall']}</th>
						<if $settings['system']['mail_quota_enabled'] == '1'>
						<th>{$lng['emails']['quota']}</th>
						</if>
						<th>{$lng['panel']['options']}</th>
					</tr>
				</thead>
				<if $pagingcode != ''>
					<tfoot>
						<tr>
							<td>{$pagingcode}</td>
						</tr>
					</tfoot>
				</if>
				<tbody>
					{$accounts}
				</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
			</p>

			</form>

			<if ($userinfo['emails_used'] < $userinfo['emails'] || $userinfo['emails'] == '-1') && $emaildomains_count !=0 >
				<div class="overviewadd">
					<img src="images/Froxlor/icons/email_add.png" alt="" />&nbsp;
					<a href="$filename?page={$page}&amp;action=add&amp;s=$s">{$lng['emails']['emails_add']}</a>
				</div>
			</if>

		</section>
	</article>
$footer

