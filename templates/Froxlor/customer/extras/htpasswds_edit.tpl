$header
<article>
	<header>
		<h2>
			<img src="images/Froxlor/icons/edit_htpasswd.png" alt="{$lng['extras']['directoryprotection_edit']}" />&nbsp;
			{$lng['extras']['directoryprotection_edit']}
		</h2>
	</header>
	
	<section class="fullform bradiusodd">

			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['extras']['directoryprotection_edit']}</legend>

					<table class="formtable">
						<tr>
							<td>{$lng['panel']['path']}:</td>
							<td>{$result['path']}</td>
						</tr>
						<tr>
							<td>{$lng['login']['username']}:</td>
							<td>{$result['username']}</td>
						</tr>
						<tr>
							<td>{$lng['login']['password']}:</td>
							<td><input type="password" name="directory_password" /></td>
						</tr>
						<tr>
							<td>{$lng['extras']['htpasswdauthname']}:</td>
							<td><input type="text" name="directory_authname" value="{$result['authname']}" /></td>
						</tr>
						<tr>
							<td colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" value="{$lng['extras']['directoryprotection_edit']}" /></td>
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
