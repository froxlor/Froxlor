 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/emails_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['menue']['email']['emails']}&nbsp;({$emailscount})
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'email'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<div class="overviewsearch">
					{$searchcode}
				</div>

			
				<if (\Froxlor\User::getAll()['emails_used'] < \Froxlor\User::getAll()['emails'] || \Froxlor\User::getAll()['emails'] == '-1') && $emaildomains_count !=0 >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'email', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['emails']['emails_add']}</a>
				</div>
				</if>

				<table class="full hl">
					<thead>
						<tr>
							<th>{\Froxlor\I18N\Lang::getAll()['emails']['emailaddress']}&nbsp;{$arrowcode['m.email_full']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['emails']['forwarders']}&nbsp;{$arrowcode['m.destination']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['emails']['account']}</th>
							<if \Froxlor\Settings::Get('catchall.catchall_enabled') == '1'><th>{\Froxlor\I18N\Lang::getAll()['emails']['catchall']}</th></if>
							<if \Froxlor\Settings::Get('system.mail_quota_enabled') == '1'>
							<th>{\Froxlor\I18N\Lang::getAll()['emails']['quota']}</th>
							</if>
							<th>{\Froxlor\I18N\Lang::getAll()['panel']['options']}</th>
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

			<if (\Froxlor\User::getAll()['emails_used'] < \Froxlor\User::getAll()['emails'] || \Froxlor\User::getAll()['emails'] == '-1') && 15 < $emails_count && $emaildomains_count !=0 >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'email', 'page' => $page, 'action' => 'add'))}">{\Froxlor\I18N\Lang::getAll()['emails']['emails_add']}</a>
			</div>
			</if>

		</section>
	</article>
$footer

