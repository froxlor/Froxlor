$header
<article>
	<header>
		<h2>
			<img src="images/Froxlor/icons/email_edit.png" alt="{$lng['emails']['emails_edit']}" />&nbsp;
			{$lng['emails']['emails_edit']}
		</h2>
	</header>
	
	<section class="fullform bradiusodd">

			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['emails']['emails_edit']}</legend>

					<table class="formtable">
						<tr>
							<td>{$lng['emails']['emailaddress']}:</td>
							<td>{$result['email_full']}</td>
						</tr>
						<tr>
							<td>{$lng['emails']['account']}:</td>
							<td>
							<if $result['popaccountid'] != 0>
							{$lng['panel']['yes']} [<a href="$filename?page=accounts&amp;action=changepw&amp;id={$result['id']}&amp;s=$s">{$lng['menue']['main']['changepassword']}</a>] [<a href="$filename?page=accounts&amp;action=delete&amp;id={$result['id']}&amp;s=$s">{$lng['emails']['account_delete']}</a>]
							</if>
							<if $result['popaccountid'] == 0>
							{$lng['panel']['no']} [<a href="$filename?page=accounts&amp;action=add&amp;id={$result['id']}&amp;s=$s">{$lng['emails']['account_add']}</a>]
							</if>
							</td>
						</tr>
						<if $result['popaccountid'] != 0 && $settings['system']['mail_quota_enabled']>
						<tr>
							<td>{$lng['customer']['email_quota']}:</td>
							<td>{$result['quota']} {$lng['panel']['megabyte']} [<a href="$filename?page=accounts&amp;action=changequota&amp;id={$result['id']}&amp;s=$s">{$lng['emails']['quota_edit']}</a>]</td>
						</tr>
						</if>
						<tr>
							<td>{$lng['emails']['catchall']}:</td>
							<td>
							<if $result['iscatchall'] != 0>
							{$lng['panel']['yes']}
							</if>
							<if $result['iscatchall'] == 0>
							{$lng['panel']['no']}
							</if>
							[<a href="$filename?page=$page&amp;action=togglecatchall&amp;id={$result['id']}&amp;s=$s">{$lng['panel']['toggle']}</a>]
							</td>
						</tr>
						<tr>
							<td>{$lng['emails']['forwarders']} ({$forwarders_count}):</td>
							<td class="field_name">$forwarders<a href="$filename?page=forwarders&amp;action=add&amp;id={$result['id']}&amp;s=$s">{$lng['emails']['forwarder_add']}</a></td>
						</tr>
					</table>

					<p style="display: none;">
						<input type="hidden" name="s" value="$s" />
						<input type="hidden" name="page" value="$page" />
						<input type="hidden" name="action" value="$action" />
						<input type="hidden" name="send" value="send" />
					</p>
				</fieldset>
			</form>
	</section>
</article>
$footer
