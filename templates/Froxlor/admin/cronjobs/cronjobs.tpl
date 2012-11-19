$header
        <article>
                <header>
			<h2><img src="templates/{$theme}/assets/img/icons/clock.png" alt="" />
                        {$lng['admin']['cron']['cronsettings']}</h2>
                </header>

		<section>
			<table class="bradiusodd">
			<thead>
				<tr>
					<th>{$lng['cron']['description']}</th>
					<th>{$lng['cron']['lastrun']}</th>
					<th>{$lng['cron']['interval']}</th>
					<th>{$lng['cron']['isactive']}</th>
					<th>{$lng['panel']['options']}</th>
				</tr>
			</thead>
			<tbody>
				$crons
			</tbody>
			</table>
		</section>

		<div class="messagewrapperfull">
		<div class="warningcontainer bradius">
			<div class="warningtitle">{$lng['admin']['warning']}</div>
			<div class="warning">{$lng['cron']['changewarning']}</div>
		</div>
		</div>

	</article>
$footer
