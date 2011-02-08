$header
<article>
	<header>
		<h2>
			<img src="images/Froxlor/icons/edit_htpasswd.png" alt="{$lng['extras']['pathoptions_edit']}" />&nbsp;
			{$lng['extras']['pathoptions_edit']}
		</h2>
	</header>
	
	<section class="fullform bradiusodd">

			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;</legend>

					<table class="formtable">
						<tr>
							<td><b>{$lng['panel']['path']}:</b></td>
							<td>{$result['path']}</td>
						</tr>
						<tr>
							<td><b>{$lng['extras']['directory_browsing']}:</b></td>
							<td>$options_indexes</td>
						</tr>
						<tr>
							<td><b>{$lng['extras']['errordocument404path']}:</b><br />{$lng['panel']['descriptionerrordocument']}</td>
							<td><input type="text" name="error404path" value="{$result['error404path']}" /></td>
						</tr>
						<tr>
							<td><b>{$lng['extras']['errordocument403path']}:</b><br />{$lng['panel']['descriptionerrordocument']}
							<if $settings['system']['webserver'] == 'lighttpd'><div style="color:red">{$lng['panel']['not_supported']}lighttpd</div></if>
							</td>
							<td><input type="text" name="error403path" value="{$result['error403path']}" /></td>
						</tr>
						<tr>
							<td><b>{$lng['extras']['errordocument500path']}:</b><br />{$lng['panel']['descriptionerrordocument']}
							<if $settings['system']['webserver'] == 'lighttpd'><div style="color:red">{$lng['panel']['not_supported']}lighttpd</div></if>
							</td>
							<td><input type="text" name="error500path" value="{$result['error500path']}" /></td>
						</tr>
						<if $cperlenabled == 1 >
							<tr>
								<td><b>{$lng['extras']['execute_perl']}:</b></td>
								<td>$options_cgi</td>
							</tr>
						</if>
						<tr>
							<td colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" value="{$lng['extras']['pathoptions_edit']}" /></td>
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
