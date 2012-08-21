$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/syslog.png" alt="" />&nbsp;
				{$lng['menue']['logger']['logger']}
			</h2>
		</header>

		<section>
			
			<form action="{$linker->getLink(array('section' => 'logger'))}" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if 15 < $log_count >
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/syslog_truncate.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'logger', 'page' => 'log', 'action' => 'truncate'))}">{$lng['logger']['truncate']}</a>
				</div>
			</if>

			<table class="bradiusodd">
			<thead>
				<tr>
					<th>{$lng['logger']['date']}&nbsp;&nbsp;{$arrowcode['date']}</th>
					<th>{$lng['logger']['type']}&nbsp;&nbsp;{$arrowcode['type']}</th>
					<th>{$lng['logger']['user']}&nbsp;&nbsp;{$arrowcode['user']}</th>
					<th style="width: 60%;">{$lng['logger']['action']}</th>
				</tr>
			</thead>
			<tbody>
				$log
			</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<input type="hidden" name="send" value="send" />
			</p>

			</form>

			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/syslog_truncate.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'logger', 'page' => 'log', 'action' => 'truncate'))}">{$lng['logger']['truncate']}</a>
			</div>

		</section>

	</article>
$footer
