$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/tickets_big.png" alt="" />&nbsp;
				{$lng['menue']['ticket']['ticket']}
			</h2>
		</header>

		<section>
			
			<form action="{$linker->getLink(array('section' => 'tickets'))}" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if ($userinfo['tickets_used'] < $userinfo['tickets'] || $userinfo['tickets'] == '-1') && 15 < $tickets_count >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/ticket_add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'new'))}">{$lng['ticket']['ticket_new']}</a>
			</div>
			</if>

			<table class="bradius" <if 0 < $tickets_count>id="sortable"</if>>
			<thead>
				<tr>
					<th>{$lng['ticket']['lastchange']}</th>
					<th>{$lng['ticket']['ticket_answers']}</th>
					<th>{$lng['ticket']['subject']}</th>
					<th>{$lng['ticket']['status']}</th>
					<th>{$lng['ticket']['lastreplier']}</th>
					<th>{$lng['ticket']['priority']}</th>
					<th class="nosort">{$lng['panel']['options']}</th>
				</tr>
			</thead>
			<if $pagingcode != ''>
				<tfoot>
					<tr>
						<td colspan="7">{$pagingcode}</td>
					</tr>
				</tfoot>
			</if>
			<tbody>
				{$tickets}
			</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<input type="hidden" name="send" value="send" />
			</p>

			</form>

			<if ($userinfo['tickets_used'] < $userinfo['tickets'] || $userinfo['tickets'] == '-1') && $countcustomers !=0 >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/ticket_add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'new'))}">{$lng['ticket']['ticket_new']}</a>
			</div>
			</if>

			<if $countcustomers == 0 >
				<div class="warningcontainer bradius">
					<div class="warningtitle">{$lng['admin']['warning']}</div>
					<div class="warning">
						<a href="{$linker->getLink(array('section' => 'customers', 'page' => 'customers', 'action' => 'add'))}">{$lng['admin']['ticket_nocustomeraddingavailable']}</a>
					</div>
				</div>
			</if>

		</section>

	</article>
$footer

