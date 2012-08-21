$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/res_recalculate_big.png" alt="" />&nbsp;
				{$lng['admin']['updatecounters']}
			</h2>
		</header>

		<section class="fullform bradiusodd">
        	<table class="formtable">
				<tr>
					<td colspan="2" style="font-weight: bold;"><img src="templates/{$theme}/assets/img/icons/res_recalculate.png" alt="" />&nbsp;{$lng['admin']['customers']}</td>
				</tr>
{$customers}
			</table>
			<br /><br />
		</section>
		<br /><br />
		<section class="fullform bradiusodd">
        	<table class="formtable">
				<tr>
					<td colspan="2" style="font-weight: bold;"><img src="templates/{$theme}/assets/img/icons/res_recalculate.png" alt="" />&nbsp;{$lng['admin']['admins']}</td>
				</tr>
{$admins}
			</table>
			<br /><br />
		</section>
</article>
$footer
