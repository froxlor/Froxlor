$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/phpsettings_add_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'vhostsettings'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />

				<table class="full">
					{$vhostconfig_add_form}
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
					<td><em>{CUSTOMER}</em></td>
					<td>{$lng['admin']['phpconfig']['customer']}</td>
				</tr>
				<tr>
					<td><em>{DOCROOT}</em></td>
					<td>{$lng['admin']['vhostconfig']['docroot']}</td>
				</tr>
				<tr>
					<td><em>{DOMAIN}</em></td>
					<td>{$lng['admin']['phpconfig']['domain']}</td>
				</tr>
				<tr>
					<td><em>{IP}</em></td>
					<td>{$lng['admin']['vhostconfig']['ip']}</td>
				</tr>
				<tr>
					<td><em>{PORT}</em></td>
					<td>{$lng['admin']['vhostconfig']['port']}</td>
				</tr>
				<tr>
					<td><em>{SCHEME}</em></td>
					<td>{$lng['admin']['vhostconfig']['scheme']}</td>
				</tr>
				<tr>
					<td><em>{SOCKET}</em></td>
					<td>{$lng['admin']['vhostconfig']['socket_dir']}</td>
				</tr>
			</tbody>
			</table>

		</section>

	</article>
$footer
