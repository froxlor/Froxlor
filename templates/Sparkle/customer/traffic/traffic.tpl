$header
<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/traffic_big.png" alt="{$lng['menue']['traffic']['traffic']}" />&nbsp;
			{$lng['menue']['traffic']['traffic']}
		</h2>
	</header>
	
	<section>

			<form action="{$linker->getLink(array('section' => 'traffic'))}" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<table class="fullform bradius">
						<tr>
							<th>{$lng['traffic']['sumftp']}</th>
							<th>{$lng['traffic']['sumhttp']}</th>
							<th>{$lng['traffic']['summail']}</th>
						</tr>
						<tr>
							<td><div style="color:#019522;">{$traffic_complete['ftp']}</div></td>
							<td><div style="color:#0000FF;">{$traffic_complete['http']}</div></td>
							<td><div style="color:#800000;">{$traffic_complete['mail']}</div></td>
						</tr>
					</table><br />
					<table class="fullform bradius" id="datatable">
						<tr id="datalegend">
							<th>{$lng['traffic']['month']}</td>
							<th>{$lng['traffic']['ftp']}</th>
							<th>{$lng['traffic']['http']}</th>
							<th>{$lng['traffic']['mail']}</th>
							<th class="text-align:right;">{$lng['customer']['traffic']}</th>
							<th></th>
						</tr>
						$traffic
					</table>

				</fieldset>
			</form>
	</section>
	<div id="chartdiv" style="height:300px;width:100%"></div>
</article>
$footer
