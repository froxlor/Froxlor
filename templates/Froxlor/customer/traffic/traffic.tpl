$header
<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/traffic.png" alt="{$lng['menue']['traffic']['traffic']}" />&nbsp;
			{$lng['menue']['traffic']['traffic']}
		</h2>
	</header>
	
	<section class="fullform bradiusodd">

			<form action="{$linker->getLink(array('section' => 'traffic'))}" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['menue']['traffic']['traffic']}</legend>

					<table class="formtable">
						<tr>
							<td>{$lng['traffic']['sumftp']} GB</td>
							<td>{$lng['traffic']['sumhttp']} GB</td>
							<td>{$lng['traffic']['summail']} GB</td>
						</tr>
						<tr>
							<td><div style="color:#019522;text-align:center">{$traffic_complete['ftp']}</div></td>
							<td><div style="color:#0000FF;text-align:center">{$traffic_complete['http']}</div></td>
							<td><div style="color:#800000;text-align:center">{$traffic_complete['mail']}</div></td>
						</tr>
					</table>
					<table class="formtable" id="datatable">
						<tr id="datalegend">
							<td>{$lng['traffic']['month']}</td>
							<td>{$lng['traffic']['ftp']}</td>
							<td>{$lng['traffic']['http']}</td>
							<td>{$lng['traffic']['mail']}</td>
							<td class="text-align:right;">{$lng['customer']['traffic']}</td>
							<td></td>
						</tr>
						$traffic
					</table>

				</fieldset>
			</form>
	</section>
	<div id="chartdiv"></div>
</article>
$footer
