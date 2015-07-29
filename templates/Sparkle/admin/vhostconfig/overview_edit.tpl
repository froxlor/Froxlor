$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/vhostsettings_edit_big.png" alt="{$title}" />&nbsp;
				{$title}
			</h2>
		</header>

		<section>

			<form action="{$linker->getLink(array('section' => 'vhostsettings'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<input type="hidden" name="action" value="edit"/>
				<input type="hidden" name="id" value="$id"/>
				<input type="hidden" name="send" value="send" />

				<table class="full">
					{$vhostconfig_edit_form}
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
						<strong>{$lng['admin']['vhostconfig']['template_replace_vars']}</strong>
					</td>
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
