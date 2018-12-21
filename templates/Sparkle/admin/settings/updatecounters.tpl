$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/res_recalculate_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['admin']['updatecounters']}
			</h2>
		</header>

		<section>
			<table class="full">
				<thead>
				<tr>
					<th colspan="3">{\Froxlor\I18N\Lang::getAll()['admin']['customers']}</th>
				</tr>
				</thead>
					{$customers}
				<thead>
				<tr>
					<th colspan="3">{\Froxlor\I18N\Lang::getAll()['admin']['admins']}</th>
				</tr>
				</thead>
					{$admins}
			</table>
		</section>
</article>
$footer
