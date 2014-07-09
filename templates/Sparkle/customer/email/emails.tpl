 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/emails_big.png" alt="" />&nbsp;
				{$lng['menue']['email']['emails']}&nbsp;({$emailscount})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'email'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<div class="overviewsearch">
					{$searchcode}
				</div>

			
				<if ($userinfo['emails_used'] < $userinfo['emails'] || $userinfo['emails'] == '-1') && $emaildomains_count !=0 >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'email', 'page' => $page, 'action' => 'add'))}">{$lng['emails']['emails_add']}</a>
				</div>
				</if>

				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['emails']['emailaddress']}&nbsp;{$arrowcode['m.email_full']}</th>
							<th>{$lng['emails']['forwarders']}&nbsp;{$arrowcode['m.destination']}</th>
							<th>{$lng['emails']['account']}</th>
							<if Settings::Get('catchall.catchall_enabled') == '1'><th>{$lng['emails']['catchall']}</th></if>
							<if Settings::Get('system.mail_quota_enabled') == '1'>
							<th>{$lng['emails']['quota']}</th>
							</if>
							<th>{$lng['panel']['options']}</th>
						</tr>
					</thead>

					<if $pagingcode != ''>
					<tfoot>
						<tr>
							<td colspan="6">{$pagingcode}</td>
						</tr>
					</tfoot>
					</if>

					<tbody>
						{$accounts}
					</tbody>
				</table>
			</form>

			<if ($userinfo['emails_used'] < $userinfo['emails'] || $userinfo['emails'] == '-1') && 15 < $emails_count && $emaildomains_count !=0 >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'email', 'page' => $page, 'action' => 'add'))}">{$lng['emails']['emails_add']}</a>
			</div>
			</if>

		</section>
	</article>
$footer

