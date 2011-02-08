$header
<article>
	<header>
		<h2>
			<img src="images/Froxlor/icons/add_user.png" alt="{$lng['ftp']['account_add']}" />&nbsp;
			{$lng['ftp']['account_add']}
		</h2>
	</header>
	
	<section class="fullform bradiusodd">

			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['ftp']['account_add']}</legend>

					<table class="formtable">
						<if $settings['customer']['ftpatdomain'] == '1'>
						<tr>
							<td>{$lng['login']['username']}:</td>
							<td><input type="text" name="ftp_username" size="30" /></td>
						</tr>
						<tr>
							<td>{$lng['domains']['domainname']}:</td>
							<td><select name="ftp_domain">$domains</select></td>
						</tr>
						</if>
						<tr>
							<td>{$lng['panel']['path']}:<if $settings['panel']['pathedit'] != 'Dropdown'><br /><font size="1">{$lng['panel']['pathDescription']}</font></if></td>
							<td>{$pathSelect}</td>
						</tr>
						<tr>
							<td>{$lng['login']['password']}:</td>
							<td><input type="password" name="ftp_password" size="30" /></td>
						</tr>
						<tr>
							<td>{$lng['customer']['sendinfomail']}:</td>
							<td>{$sendinfomail}</td>
						</tr>
						<tr>
							<td colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" value="{$lng['ftp']['account_add']}" /></td>
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
