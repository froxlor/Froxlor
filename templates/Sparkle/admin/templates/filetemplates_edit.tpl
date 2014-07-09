$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/templates_edit_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'templates'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="id" value="$id" />
				<input type="hidden" name="filesend" value="filesend" />

				<table class="full">
					{$filetemplate_edit_form}
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
					<td colspan="2">
						<strong>{$lng['admin']['templates']['index_html']}</strong>
					</td>
				</tr>
				<tr>
					<td><em>{SERVERNAME}</em></td>
					<td>{$lng['admin']['templates']['SERVERNAME']}</td>
				</tr>
				<tr>
					<td><em>{CUSTOMER}</em></td>
					<td>{$lng['admin']['templates']['CUSTOMER']}</td>
				</tr>
				<tr>
					<td><em>{ADMIN}</em></td>
					<td>{$lng['admin']['templates']['ADMIN']}</td>
				</tr>
				<tr>
					<td><em>{CUSTOMER_EMAIL}</em></td>
					<td>{$lng['admin']['templates']['CUSTOMER_EMAIL']}</td>
				</tr>
				<tr>
					<td><em>{ADMIN_EMAIL}</em></td>
					<td>{$lng['admin']['templates']['ADMIN_EMAIL']}</td>
				</tr>
			</tbody>
			</table>

		</section>

	</article>
$footer
