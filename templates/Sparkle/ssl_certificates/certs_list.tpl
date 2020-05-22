 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/lock_big.png" alt="" />&nbsp;
				{$lng['domains']['ssl_certificates']}
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

			<form action="{$linker->getLink(array('section' => 'domains', 'page' => 'sslcertificates'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />

				<div class="overviewsearch">
					{$searchcode}
				</div>
	
				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['domains']['domainname']}&nbsp;{$arrowcode['d.domain']}</th>
							<th>Certificate for</th>
							<th>Issuer</th>
							<th>Valid from</th>
							<th>Valid until</th>
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
						{$certificates}
					</tbody>
				</table>
			</form>

		</section>
	</article>
$footer
