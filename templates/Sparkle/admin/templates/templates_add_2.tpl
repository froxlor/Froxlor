$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/templates_add_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'templates'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />

				<table class="full">
					{$template_add_form}
				</table>
			</form>

		</section>
	</article>
	<br />
	<article>
		<header>
			<h3>
				{\Froxlor\I18N\Lang::getAll()['admin']['templates']['template_replace_vars']}
			</h3>
		</header>
		
		<section>
			
			<table class="full">
			<thead>
				<tr>
					<th>{\Froxlor\I18N\Lang::getAll()['panel']['variable']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['panel']['description']}</th>
				</tr>
			</thead>
			<tbody>
				<if ($template == 'createcustomer')>
					<tr>
						<td><em>{SALUTATION}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['SALUTATION']}</td>
					</tr>
					<tr>
						<td><em>{FIRSTNAME}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['FIRSTNAME']}</td>
					</tr>
					<tr>
						<td><em>{NAME}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['NAME']}</td>
					</tr>
					<tr>
						<td><em>{COMPANY}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['COMPANY']}</td>
					</tr>
					<tr>
						<td><em>{USERNAME}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['USERNAME']}</td>
					</tr>
					<tr>
						<td><em>{PASSWORD}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['PASSWORD']}</td>
					</tr>
				</if>
				<if ($template == 'pop_success')>
					<tr>
						<td><em>{EMAIL}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['EMAIL']}</td>
					</tr>
					<if \Froxlor\Settings::Get('panel.sendalternativemail') == 1>
					<tr>
						<td colspan="2">
							<strong>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['pop_success_alternative']}</strong>
						</td>
					</tr>
					<tr>
						<td><em>{EMAIL}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['EMAIL']}</td>
					</tr>
					<tr>
						<td><em>{PASSWORD}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['EMAIL_PASSWORD']}</td>
					</tr>
					</if>
				</if>
				<if ($template == 'password_reset')>
					<tr>
						<td><em>{SALUTATION}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['SALUTATION']}</td>
					</tr>
					<tr>
						<td><em>{USERNAME}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['USERNAME']}</td>
					</tr>
					<tr>
						<td><em>{LINK}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['LINK']}</td>
					</tr>
				</if>
				<if ($template == 'trafficmaxpercent')>
					<tr>
						<td><em>{TRAFFIC}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['TRAFFIC']}</td>
					</tr>
					<tr>
						<td><em>{TRAFFICUSED}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['TRAFFICUSED']}</td>
					</tr>
					<tr>
						<td><em>{MAX_PERCENT}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['MAX_PERCENT']}</td>
					</tr>
					<tr>
						<td><em>{USAGE_PERCENT}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['USAGE_PERCENT']}</td>
					</tr>
				</if>
				<if ($template == 'diskmaxpercent')>
					<tr>
						<td><em>{DISKAVAILABLE}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['DISKAVAILABLE']}</td>
					</tr>
					<tr>
						<td><em>{DISKUSED}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['DISKUSED']}</td>
					</tr>
					<tr>
						<td><em>{MAX_PERCENT}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['MAX_PERCENT']}</td>
					</tr>
					<tr>
						<td><em>{USAGE_PERCENT}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['USAGE_PERCENT']}</td>
					</tr>
				</if>
				<if ($template == 'new_database_by_customer')>
					<tr>
						<td><em>{SALUTATION}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['SALUTATION']}</td>
					</tr>
					<tr>
						<td><em>{DB_NAME}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['DB_NAME']}</td>
					</tr>
					<tr>
						<td><em>{DB_PASS}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['DB_PASS']}</td>
					</tr>
					<tr>
						<td><em>{DB_DESC}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['DB_DESC']}</td>
					</tr>
					<tr>
						<td><em>{DB_SRV}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['DB_SRV']}</td>
					</tr>
					<tr>
						<td><em>{PMA_URI}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['PMA_URI']}</td>
					</tr>
				</if>
				<if ($template == 'new_ftpaccount_by_customer')>
					<tr>
						<td><em>{SALUTATION}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['SALUTATION']}</td>
					</tr>
					<tr>
						<td><em>{USR_NAME}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['USR_NAME']}</td>
					</tr>
					<tr>
						<td><em>{USR_PASS}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['USR_PASS']}</td>
					</tr>
					<tr>
						<td><em>{USR_PATH}</em></td>
						<td>{\Froxlor\I18N\Lang::getAll()['admin']['templates']['USR_PATH']}</td>
					</tr>
				</if>
			</tbody>
			</table>

		</section>

	</article>
$footer
