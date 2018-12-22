$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/phpsettings_edit_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'phpsettings'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<input type="hidden" name="action" value="edit"/>
				<input type="hidden" name="id" value="$id"/>
				<input type="hidden" name="send" value="send" />

				<table class="full">
					{$phpconfig_edit_form}
				</table>
			</form>
		</section>
	</article>
	<br />
	<article>
		<header>
			<h3>
				{$lng['admin']['templates']['template_replace_vars']}
			</h3>
		</header>
		
		<section>
			
			<table class="full">
			<thead>
				<tr>
					<th>{$lng['panel']['variable']}</th>
					<th>{$lng['panel']['description']}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><em>{PEAR_DIR}</em></td>
					<td>{$lng['admin']['phpconfig']['pear_dir']}</td>
				</tr>
				<tr>
					<td><em>{OPEN_BASEDIR_C}</em></td>
					<td>{$lng['admin']['phpconfig']['open_basedir_c']}</td>
				</tr>
				<tr>
					<td><em>{OPEN_BASEDIR}</em></td>
					<td>{$lng['admin']['phpconfig']['open_basedir']}</td>
				</tr>
				<tr>
					<td><em>{OPEN_BASEDIR_GLOBAL}</em></td>
					<td>{$lng['admin']['phpconfig']['open_basedir_global']}</td>
				</tr>
				<tr>
					<td><em>{TMP_DIR}</em></td>
					<td>{$lng['admin']['phpconfig']['tmp_dir']}</td>
				</tr>
				<tr>
					<td><em>{CUSTOMER_EMAIL}</em></td>
					<td>{$lng['admin']['phpconfig']['customer_email']}</td>
				</tr>
				<tr>
					<td><em>{ADMIN_EMAIL}</em></td>
					<td>{$lng['admin']['phpconfig']['admin_email']}</td>
				</tr>
				<tr>
					<td><em>{DOMAIN}</em></td>
					<td>{$lng['admin']['phpconfig']['domain']}</td>
				</tr>
				<tr>
					<td><em>{CUSTOMER}</em></td>
					<td>{$lng['admin']['phpconfig']['customer']}</td>
				</tr>
				<tr>
					<td><em>{ADMIN}</em></td>
					<td>{$lng['admin']['phpconfig']['admin']}</td>
				</tr>
				<tr>
					<td><em>{DOCUMENT_ROOT}</em></td>
					<td>{$lng['admin']['phpconfig']['docroot']}</td>
				</tr>
				<tr>
					<td><em>{CUSTOMER_HOMEDIR}</em></td>
					<td>{$lng['admin']['phpconfig']['homedir']}</td>
				</tr>
			</tbody>
			</table>

		</section>

	</article>
$footer
