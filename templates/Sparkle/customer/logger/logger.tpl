$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/syslog_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['menue']['logger']['logger']}
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
					{$pagingcode}
				</div>
	
				<table class="full hl">
					<thead>
						<tr>
							<th>{\Froxlor\I18N\Lang::getAll()['logger']['date']}&nbsp;{$arrowcode['date']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['logger']['type']}&nbsp;{$arrowcode['type']}</th>
							<th>{\Froxlor\I18N\Lang::getAll()['logger']['action']}</th>
						</tr>
					</thead>
					<tbody>
						$log
					</tbody>
				</table>
			</form>

			<if 15 < $log_count >
			<div class="overviewadd">
				{$pagingcode}
			</div>
			</if>

		</section>

	</article>
$footer
