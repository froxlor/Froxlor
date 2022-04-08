$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/lock_big.png" alt="" />&nbsp;
				{$lng['dkim']['title']}
			</h2>
		</header>
		
		<if !empty($success_message)>
			<div class="successcontainer bradius">
				<div class="successtitle">{$lng['success']['success']}</div>
				<div class="success">
					$success_message
				</div>
			</div>
		</if>

		<section>

			<form action="{$linker->getLink(array('section' => 'domains', 'page' => 'dkim'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />

				<div class="overviewsearch">
					{$searchcode}
				</div>
	
				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['domains']['domainname']}&nbsp;{$arrowcode['d.domain']}</th>
							<th>Selector</th>
							<th>Record Name</th>
							<th>Record Data</th>
							<th>Public Key</th>
							<th>{$lng['panel']['options']}</th>
						</tr>
					</thead>

					<if $pagingcode != ''>
					<tfoot>
						<tr>
							<td colspan="6">{$pagingcode}</td>
						</tr>
					</tfoot>
					</if>

					<tbody>
						{$domains_selectors}
					</tbody>
				</table>
			</form>

		</section>
	</article>
$footer
