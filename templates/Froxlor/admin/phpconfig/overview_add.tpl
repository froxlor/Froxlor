$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/{$image}" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section class="fullform bradiusodd">

			<form action="{$linker->getLink(array('section' => 'phpsettings'))}" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$title}</legend>

					<table class="formtable">
						{$phpconfig_add_form}
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
						<strong>{$lng['admin']['phpconfig']['template_replace_vars']}</strong>
					</td>
				</tr>
				<tr>
					<td><em>{SAFE_MODE}</em></td>
					<td>{$lng['admin']['phpconfig']['safe_mode']}</td>
				</tr>
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
			</tbody>
			</table>

		</section>

	</article>
$footer
