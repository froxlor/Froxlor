$header
<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/traffic_big.png" alt="{$lng['menue']['traffic']['traffic']}" />&nbsp;
			{$lng['menue']['traffic']['traffic']}
		</h2>
	</header>

	<form action="{$linker->getLink(array('section' => 'traffic'))}" method="post" enctype="application/x-www-form-urlencoded">
			<table class="fullform bradius" id="datatable">
				<thead>
					<tr>
						<th>{$lng['traffic']['month']}</th>
						<th>{$lng['traffic']['ftp']}</th>
						<th>{$lng['traffic']['http']}</th>
						<th>{$lng['traffic']['mail']}</th>
						<th class="text-align:right;">{$lng['customer']['traffic']}</th>
					</tr>
				</thead>
				<tbody>
					$traffic
				</tbody>
				<tfoot>
					<tr>
						<td>{$lng['traffic']['months']['total']}</td>
						<td>{$traffic_complete['ftp']}</td>
						<td>{$traffic_complete['http']}</td>
						<td>{$traffic_complete['mail']}</td>
						<td></td>
					</tr>
				</tfoot>
			</table>
	</form>

	<div id="charts" style="display: none">
		<h3>HTTP {$lng['admin']['traffic']} ({$lng['traffic']['months']['total']} {$traffic_complete['http']})</h3>
		<div id="httpchart" class="trafficchart" style="width:100%"></div>
		<h3>FTP {$lng['admin']['traffic']} ({$lng['traffic']['months']['total']} {$traffic_complete['ftp']})</h3>
		<div id="ftpchart" class="trafficchart" style="width:100%"></div>
		<h3>Mail {$lng['admin']['traffic']} ({$lng['traffic']['months']['total']} {$traffic_complete['mail']})</h3>
		<div id="mailchart" class="trafficchart" style="width:100%"></div>
	</div>
</article>
$footer
