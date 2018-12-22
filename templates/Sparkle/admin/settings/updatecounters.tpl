$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/res_recalculate_big.png" alt="" />&nbsp;
				{$lng['admin']['updatecounters']}
			</h2>
		</header>

		<section>
			<table class="full">
				<thead>
				<tr>
					<th colspan="3">{$lng['admin']['customers']}</th>
				</tr>
				</thead>
					{$customers}
				<thead>
				<tr>
					<th colspan="3">{$lng['admin']['admins']}</th>
				</tr>
				</thead>
					{$admins}
			</table>
		</section>
</article>
$footer
