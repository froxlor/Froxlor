 $header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/lock_big.png" alt="" />&nbsp;
				{$lng['menue']['main']['apikeys']}
			</h2>
		</header>
		
		<if !empty($success_message)>
			<div class="successcontainer bradius">
				<div class="successtitle">{$lng['success']['success']}</div>
				<div class="success">
					$success_message
				</div>
			</div>
		</if>

		<if (int)$userinfo['api_allowed'] != 1>
		<div class="messagewrapperfull">
			<div class="warningcontainer bradius">
				<div class="warningtitle">{$lng['admin']['warning']}</div>
				<div class="warning">{$lng['usersettings']['api_allowed']['notice']}</div>
			</div>
		</div>
		</if>

		<section>

			<form action="{$linker->getLink(array('section' => 'index', 'page' => $page))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />

				<div class="overviewsearch">
					{$searchcode}
				</div>

				<if (int)$userinfo['api_allowed'] == 1>
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />
					<a href="{$linker->getLink(array('section' => 'index', 'page' => $page, 'action' => 'add'))}">{$lng['apikeys']['key_add']}</a>
				</div>
				</if>

				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['login']['username']}</th>
							<th>API-key</th>
							<th>Secret</th>
							<th>{$lng['apikeys']['allowed_from']}</th>
							<th>{$lng['apikeys']['valid_until']}</th>
							<th>{$lng['panel']['options']}</th>
						</tr>
					</thead>

					<if $pagingcode != ''>
					<tfoot>
						<tr>
							<td colspan="6">{$pagingcode}</td>
						</tr>
					</tfoot>
					</if>

					<tbody>
						{$apikeys}
					</tbody>
				</table>
			</form>

			<if 15 < $count >
			<if (int)$userinfo['api_allowed'] == 1>
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />
				<a href="{$linker->getLink(array('section' => 'index', 'page' => $page, 'action' => 'add'))}">{$lng['apikeys']['key_add']}</a>
			</div>
			</if>
			</if>
		</section>
	</article>
$footer
