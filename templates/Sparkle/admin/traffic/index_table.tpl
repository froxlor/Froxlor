	<h3>{$lng['traffic']['trafficoverview']}&nbsp;{$overview['type']}&nbsp;{$overview['year']}</h3>
	<section>
	<table class="full" id="stats{$overview['year']}" data-toggle="table">
		<thead>
			<tr>
				<th>{$overview['type']}</th>
				<th>{$lng['traffic']['months']['jan']}</td>
				<th>{$lng['traffic']['months']['feb']}</td>
				<th>{$lng['traffic']['months']['mar']}</td>
				<th>{$lng['traffic']['months']['apr']}</td>
				<th>{$lng['traffic']['months']['may']}</td>
				<th>{$lng['traffic']['months']['jun']}</td>
				<th>{$lng['traffic']['months']['jul']}</td>
				<th>{$lng['traffic']['months']['aug']}</td>
				<th>{$lng['traffic']['months']['sep']}</td>
				<th>{$lng['traffic']['months']['oct']}</td>
				<th>{$lng['traffic']['months']['nov']}</td>
				<th>{$lng['traffic']['months']['dec']}</td>
			</tr>
		</thead>
		<tbody>
			{$domain_list}
		</tbody>
		<tfoot>
			{$total_list}
		</tfoot>
	</table>
	</section>
	<br />
	<br />
