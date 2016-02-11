$header
        <article>
                <header>
			<h2><img src="templates/{$theme}/assets/img/icons/clock_big.png" alt="" />&nbsp;
			{$lng['admin']['cron']['cronsettings']}</h2>
                </header>
                
		<div class="messagewrapperfull">
		<div class="warningcontainer bradius">
			<div class="warningtitle">{$lng['admin']['warning']}</div>
			<div class="warning">{$lng['cron']['changewarning']}</div>
		</div>
		</div>
		
		<section>
			<table class="full">
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

	</article>
$footer
