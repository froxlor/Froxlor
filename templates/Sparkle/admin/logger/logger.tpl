$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/syslog_big.png" alt="" />&nbsp;
				{$lng['menue']['logger']['logger']}
			</h2>
		</header>

		<section>
			
			<form action="{$linker->getLink(array('section' => 'logger'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<input type="hidden" name="send" value="send" />

				<div class="overviewsearch">
					{$searchcode}
				</div>	

				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/delete.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'logger', 'page' => 'log', 'action' => 'truncate'))}">{$lng['logger']['truncate']}</a>
				</div>
	
				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['logger']['date']}&nbsp;{$arrowcode['date']}</th>
							<th>{$lng['logger']['type']}&nbsp;{$arrowcode['type']}</th>
							<th>{$lng['logger']['user']}&nbsp;{$arrowcode['user']}</th>
							<th>{$lng['logger']['action']}</th>
						</tr>
					</thead>
					<tbody>
						$log
					</tbody>
				</table>
			</form>

			<if 15 < $log_count >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/delete.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'logger', 'page' => 'log', 'action' => 'truncate'))}">{$lng['logger']['truncate']}</a>
			</div>
			</if>

		</section>

	</article>
$footer
