$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/phpsettings_add_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'phpsettings'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />

				<table class="full">
					{$phpconfig_add_form}
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
				<tr>
					<td colspan="2">
						<strong>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['template_replace_vars']}</strong>
					</td>
				</tr>
				<tr>
					<td><em>{PEAR_DIR}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['pear_dir']}</td>
				</tr>
				<tr>
					<td><em>{OPEN_BASEDIR_C}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['open_basedir_c']}</td>
				</tr>
				<tr>
					<td><em>{OPEN_BASEDIR}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['open_basedir']}</td>
				</tr>
				<tr>
					<td><em>{OPEN_BASEDIR_GLOBAL}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['open_basedir_global']}</td>
				</tr>
				<tr>
					<td><em>{TMP_DIR}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['tmp_dir']}</td>
				</tr>
				<tr>
					<td><em>{CUSTOMER_EMAIL}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['customer_email']}</td>
				</tr>
				<tr>
					<td><em>{ADMIN_EMAIL}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['admin_email']}</td>
				</tr>
				<tr>
					<td><em>{DOMAIN}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['domain']}</td>
				</tr>
				<tr>
					<td><em>{CUSTOMER}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['customer']}</td>
				</tr>
				<tr>
					<td><em>{ADMIN}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['admin']}</td>
				</tr>
				<tr>
					<td><em>{DOCUMENT_ROOT}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['docroot']}</td>
				</tr>
				<tr>
					<td><em>{CUSTOMER_HOMEDIR}</em></td>
					<td>{\Froxlor\I18N\Lang::getAll()['admin']['phpconfig']['homedir']}</td>
				</tr>
			</tbody>
			</table>

		</section>

	</article>
$footer
