$header
	<article>
		<header>
			<h2>
				<img src="images/Froxlor/icons/edit_group.png" alt="" />&nbsp;
				{$lng['admin']['admins']}&nbsp;({$admincount})
			</h2>
		</header>

		<section>

			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if 15 < $count >
				<div class="overviewadd">
					<img src="images/Froxlor/icons/add_user.png" alt="" />&nbsp;
					<a href="$filename?page=$page&amp;action=add&amp;s=$s">{$lng['admin']['admin_add']}</a>
				</div>
			</if>

			<table class="bradiusodd">
			<thead>
				<tr>
					<th>
						{$lng['customer']['name']}&nbsp;&nbsp;{$arrowcode['name']}&nbsp;
						{$lng['login']['username']}&nbsp;{$arrowcode['loginname']}
					</th>
					<th>{$lng['panel']['options']}</th>
				</tr>
			</thead>
			<if $pagingcode != ''>			
				<tfoot>
					<tr>
						<td>{$pagingcode}</td>
					</tr>
				</tfoot>
			</if>
			<tbody>
				$admins
			</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
			</p>

			</form>

			<div class="overviewadd">
				<img src="images/Froxlor/icons/add_user.png" alt="" />&nbsp;
				<a href="$filename?page=$page&amp;action=add&amp;s=$s">{$lng['admin']['admin_add']}</a>
			</div>

		</section>

	</article>
$footer

