$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/categories.png" alt="" />&nbsp;
				{$lng['menue']['ticket']['categories']}
			</h2>
		</header>

		<section>
			
			<form action="{$linker->getLink(array('section' => 'tickets'))}" method="post" enctype="application/x-www-form-urlencoded">

			<div class="overviewsearch">
				{$searchcode}
			</div>

			<if 15 < $categories_count >
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/category_add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'categories', 'action' => 'addcategory'))}">{$lng['ticket']['ticket_newcateory']}</a>
			</div>
			</if>

			<table class="bradiusodd">
			<thead>
				<tr>
					<th>{$lng['ticket']['category']}&nbsp;{$arrowcode['name']}</th>
					<th>{$lng['ticket']['logicalorder']}&nbsp;{$arrowcode['logicalorder']}</th>
					<th>{$lng['ticket']['ticketcount']}&nbsp;<if $categories_count < 0 >{$arrowcode['ticketcount']}</if></th>
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
				$ticketcategories
			</tbody>
			</table>

			<p style="display:none;">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<input type="hidden" name="send" value="send" />
			</p>

			</form>

			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/category_add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'categories', 'action' => 'addcategory'))}">{$lng['ticket']['ticket_newcateory']}</a>
			</div>

		</section>

	</article>
$footer

