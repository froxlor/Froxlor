	<h3>{\Froxlor\I18N\Lang::getAll()['traffic']['trafficoverview']}&nbsp;{$overview['type']}&nbsp;{$overview['year']}</h3>
	<section>
	<table class="full" id="stats{$overview['year']}" data-toggle="table">
		<thead>
			<tr>
				<th>{$overview['type']}</th>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['jan']}</td>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['feb']}</td>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['mar']}</td>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['apr']}</td>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['may']}</td>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['jun']}</td>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['jul']}</td>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['aug']}</td>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['sep']}</td>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['oct']}</td>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['nov']}</td>
				<th>{\Froxlor\I18N\Lang::getAll()['traffic']['months']['dec']}</td>
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
