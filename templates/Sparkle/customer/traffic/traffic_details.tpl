$header
<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/traffic_big.png" alt="{$lng['menue']['traffic']['traffic']}" />&nbsp;
			{$lng['menue']['traffic']['traffic']} $show
		</h2>
	</header>
	
	<section class="fullform bradius">

			<form action="{$linker->getLink(array('section' => 'traffic'))}" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['menue']['traffic']['traffic']} $show</legend>

					<table class="formtable">
						<thead>
							<tr>
								<th>{$lng['traffic']['sumftp']}</th>
								<th>{$lng['traffic']['sumhttp']}</th>
								<th>{$lng['traffic']['summail']}</th>
							</tr>
						</thead>
						<tr>
							<td><div style="color:#019522;text-align:center">{$traffic_complete['ftp']}</div></td>
							<td><div style="color:#0000FF;text-align:center">{$traffic_complete['http']}</div></td>
							<td><div style="color:#800000;text-align:center">{$traffic_complete['mail']}</div></td>
						</tr>
					</table>
					<table class="formtable" id="datatable">
						<tr id="datalegend">
							<td>{$lng['traffic']['day']}</td>
							<td>{$lng['traffic']['ftp']}</td>
							<td>{$lng['traffic']['http']}</td>
							<td>{$lng['traffic']['mail']}</td>
							<td>{$lng['traffic']['mb']}</td>
						</tr>
						$traffic
					</table>
				</fieldset>
			</form>
	</section>
	<br />
	<div id="chartdiv" style="width:100%"></div>
</article>
$footer
