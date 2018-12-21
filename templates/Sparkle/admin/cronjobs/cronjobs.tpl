$header
        <article>
                <header>
			<h2><img src="templates/{$theme}/assets/img/icons/clock_big.png" alt="" />&nbsp;
			{\Froxlor\I18N\Lang::getAll()['admin']['cron']['cronsettings']}</h2>
                </header>
                
		<div class="messagewrapperfull">
		<div class="warningcontainer bradius">
			<div class="warningtitle">{\Froxlor\I18N\Lang::getAll()['admin']['warning']}</div>
			<div class="warning">{\Froxlor\I18N\Lang::getAll()['cron']['changewarning']}</div>
		</div>
		</div>
		
		<section>
			<table class="full">
			<thead>
				<tr>
					<th>{\Froxlor\I18N\Lang::getAll()['cron']['description']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['cron']['lastrun']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['cron']['interval']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['cron']['isactive']}</th>
					<th>{\Froxlor\I18N\Lang::getAll()['panel']['options']}</th>
				</tr>
			</thead>
			<tbody>
				$crons
			</tbody>
			</table>
		</section>

	</article>
$footer
