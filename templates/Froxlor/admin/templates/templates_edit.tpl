$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/{$image}" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section class="fullform bradiusodd">

			<form action="{$linker->getLink(array('section' => 'templates'))}" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$title}</legend>

					<table class="formtable">
						{$template_edit_form}
					</table>

					<p style="display: none;">
						<input type="hidden" name="s" value="$s" />
						<input type="hidden" name="page" value="$page" />
						<input type="hidden" name="action" value="$action" />
						<input type="hidden" name="subjectid" value="$subjectid" />
						<input type="hidden" name="mailbodyid" value="$mailbodyid" />
						<input type="hidden" name="send" value="send" />
					</p>
				</fieldset>
			</form>

		</section>
	</article>
	<br />
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/replace_vars.png" alt="" />&nbsp;
				{$lng['admin']['templates']['template_replace_vars']}
			</h2>
		</header>
		
		<section>
			
			<table class="bradiusodd">
			<thead>
				<tr>
					<th>{$lng['panel']['variable']}</th>
					<th>{$lng['panel']['description']}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">
						<strong>{$lng['admin']['templates']['createcustomer']}</strong>
					</td>
				</tr>
				<tr>
					<td><i>{SALUTATION}</em>:</td>
					<td>{$lng['admin']['templates']['SALUTATION']}</td>
				</tr>
				<tr>
					<td><i>{FIRSTNAME}</em>:</td>
					<td>{$lng['admin']['templates']['FIRSTNAME']}</td>
				</tr>
				<tr>
					<td><em>{NAME}</em>:</td>
					<td>{$lng['admin']['templates']['NAME']}</td>
				</tr>
				<tr>
					<td><em>{COMPANY}</em>:</td>
					<td>{$lng['admin']['templates']['COMPANY']}</td>
				</tr>
				<tr>
					<td><em>{USERNAME}</em>:</td>
					<td>{$lng['admin']['templates']['USERNAME']}</td>
				</tr>
				<tr>
					<td><em>{PASSWORD}</em>:</td>
					<td>{$lng['admin']['templates']['PASSWORD']}</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>{$lng['admin']['templates']['pop_success']}</strong>
					</td>
				</tr>
				<tr>
					<td><em>{EMAIL}</em>:</td>
					<td>{$lng['admin']['templates']['EMAIL']}</td>
				</tr>
				<if $settings['panel']['sendalternativemail'] == 1>
				<tr>
					<td colspan="2">
						<strong>{$lng['admin']['templates']['pop_success_alternative']}</strong>
					</td>
				</tr>
				<tr>
					<td><em>{EMAIL}</em>:</td>
					<td>{$lng['admin']['templates']['EMAIL']}</td>
				</tr>
				<tr>
					<td><em>{PASSWORD}</em>:</td>
					<td>{$lng['admin']['templates']['EMAIL_PASSWORD']}</td>
				</tr>
				</if>
				<tr>
					<td colspan="2">
						<strong>{$lng['admin']['templates']['forgotpwd']}</strong>
					</td>
				</tr>
				<tr>
					<td><em>{SALUTATION}</em>:</td>
					<td>{$lng['admin']['templates']['SALUTATION']}</td>
				</tr>
				<tr>
					<td><em>{USERNAME}</em>:</td>
					<td>{$lng['admin']['templates']['USERNAME']}</td>
				</tr>
				<tr>
					<td><em>{PASSWORD}</em>:</td>
					<td>{$lng['admin']['templates']['PASSWORD']}</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>{$lng['admin']['templates']['trafficmaxpercent']}</strong>
					</td>
				</tr>
				<tr>
					<td><em>{TRAFFIC}</em>:</td>
					<td>{$lng['admin']['templates']['TRAFFIC']}</td>
				</tr>
				<tr>
					<td><em>{TRAFFICUSED}</em>:</td>
					<td>{$lng['admin']['templates']['TRAFFICUSED']}</td>
				</tr>
				<tr>
					<td><em>{MAX_PERCENT}</em>:</td>
					<td>{$lng['admin']['templates']['MAX_PERCENT']}</td>
				</tr>
				<tr>
					<td><em>{USAGE_PERCENT}</em>:</td>
					<td>{$lng['admin']['templates']['USAGE_PERCENT']}</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>{$lng['admin']['templates']['diskmaxpercent']}</strong>
					</td>
				</tr>
				<tr>
					<td><em>{DISKAVAILABLE}</em>:</td>
					<td>{$lng['admin']['templates']['DISKAVAILABLE']}</td>
				</tr>
				<tr>
					<td><em>{DISKUSED}</em>:</td>
					<td>{$lng['admin']['templates']['DISKUSED']}</td>
				</tr>
				<tr>
					<td><em>{MAX_PERCENT}</em>:</td>
					<td>{$lng['admin']['templates']['MAX_PERCENT']}</td>
				</tr>
				<tr>
					<td><em>{USAGE_PERCENT}</em>:</td>
					<td>{$lng['admin']['templates']['USAGE_PERCENT']}</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>{$lng['admin']['templates']['ticket']}</strong>
					</td>
				</tr>
				<tr>
					<td><em>{SUBJECT}</em>:</td>
					<td>{$lng['admin']['templates']['SUBJECT']}</td>
				</tr>
				<tr>
					<td><em>{SALUTATION}</em>:</td>
					<td>{$lng['admin']['templates']['SALUTATION']}</td>
				</tr>
				<tr>
					<td><em>{FIRSTNAME}</em>:</td>
					<td>{$lng['admin']['templates']['FIRSTNAME']}</td>
				</tr>
				<tr>
					<td><em>{NAME}</em>:</td>
					<td>{$lng['admin']['templates']['NAME']}</td>
				</tr>
				<tr>
					<td><em>{COMPANY}</em>:</td>
					<td>{$lng['admin']['templates']['COMPANY']}</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>{$lng['admin']['templates']['newdatabase']}</strong>
					</td>
				</tr>
				<tr>
					<td><em>{CUST_NAME}</em>:</td>
					<td>{$lng['admin']['templates']['CUST_NAME']}</td>
				</tr>
				<tr>
					<td><em>{DB_NAME}</em>:</td>
					<td>{$lng['admin']['templates']['DB_NAME']}</td>
				</tr>
				<tr>
					<td><em>{DB_PASS}</em>:</td>
					<td>{$lng['admin']['templates']['DB_PASS']}</td>
				</tr>
				<tr>
					<td><em>{DB_DESC}</em>:</td>
					<td>{$lng['admin']['templates']['DB_DESC']}</td>
				</tr>
				<tr>
					<td><em>{DB_SRV}</em>:</td>
					<td>{$lng['admin']['templates']['DB_SRV']}</td>
				</tr>
				<tr>
					<td><em>{PMA_URI}</em>:</td>
					<td>{$lng['admin']['templates']['PMA_URI']}</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>{$lng['admin']['templates']['newftpuser']}</strong>
					</td>
				</tr>
				<tr>
					<td><em>{CUST_NAME}</em>:</td>
					<td>{$lng['admin']['templates']['CUST_NAME']}</td>
				</tr>
				<tr>
					<td><em>{USR_NAME}</em>:</td>
					<td>{$lng['admin']['templates']['USR_NAME']}</td>
				</tr>
				<tr>
					<td><em>{USR_PASS}</em>:</td>
					<td>{$lng['admin']['templates']['USR_PASS']}</td>
				</tr>
				<tr>
					<td><em>{USR_PATH}</em>:</td>
					<td>{$lng['admin']['templates']['USR_PATH']}</td>
				</tr>
			</tbody>
			</table>

		</section>

	</article>
$footer

