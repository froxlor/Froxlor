$header
	<form action="{$linker->getLink(array('section' => 'customers'))}" method="post">
                <input type="hidden" name="s" value="$s"/>
                <input type="hidden" name="page" value="$page"/>
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left" colspan="3" ><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['admin']['customers']}</b>&nbsp;({$customercount})</td>
				<td class="maintitle_search_right" colspan="<if ($settings['ticket']['enabled'] == 1 || $settings['autoresponder']['autoresponder_active'] == 1) >8<else>7</if>">{$searchcode}</td>
			</tr>
			<if ($userinfo['customers_used'] < $userinfo['customers'] || $userinfo['customers'] == '-1') && 15 < $userinfo['customers_used']>
			<tr>
				<td colspan="11" class="field_display_border_left"><a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['customer_add']}</a></td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left">{$lng['login']['username']}<br />{$arrowcode['c.loginname']}</td>
				<td class="field_display">{$lng['admin']['admin']}<br />{$arrowcode['a.loginname']}</td>
				<td class="field_display">{$lng['customer']['name']}&nbsp;&nbsp;{$arrowcode['c.name']}<br />{$lng['customer']['firstname']}&nbsp;&nbsp;{$arrowcode['c.firstname']}</td>
				<td class="field_display">{$lng['customer']['domains']}</td>
				<if ($settings['ticket']['enabled'] == 1 || $settings['autoresponder']['autoresponder_active'] == 1) >
					<if ($settings['ticket']['enabled'] == 1 && $settings['autoresponder']['autoresponder_active'] == 0) >
						<td class="field_display">{$lng['customer']['tickets']}</td>
					</if>
					<if ($settings['ticket']['enabled'] == 0 && $settings['autoresponder']['autoresponder_active'] == 1) >
						<td class="field_display">{$lng['customer']['autoresponder']}</td>
					</if>
					<if ($settings['ticket']['enabled'] == 1 && $settings['autoresponder']['autoresponder_active'] == 1) >
						<td class="field_display">{$lng['customer']['tickets']}<br />{$lng['customer']['autoresponder']}</td>
					</if>
				</if>
				<td class="field_display">{$lng['customer']['diskspace']}<br />{$lng['customer']['traffic']}</td>
				<td class="field_display">{$lng['customer']['mysqls']}<br />{$lng['customer']['ftps']}</td>
				<td class="field_display">{$lng['customer']['emails']}<br />{$lng['customer']['subdomains']}</td>
				<td class="field_display">{$lng['customer']['accounts']}<br />{$lng['customer']['forwarders']}</td>
				<td class="field_display">{$lng['admin']['deactivated']}<br />{$lng['admin']['lastlogin_succ']}</td>
				<td class="field_display_search">{$sortcode}</td>
			</tr>
			$customers
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="11" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<if $userinfo['customers_used'] < $userinfo['customers'] || $userinfo['customers'] == '-1'>
			<tr>
				<td colspan="<if ($settings['ticket']['enabled'] == 1 || $settings['autoresponder']['autoresponder_active'] == 1) >11<else>10</if>" class="field_display_border_left"><a href="{$linker->getLink(array('section' => 'customers', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['customer_add']}</a></td>
			</tr>
			</if>
		</table>
	</form>
	<br />
	<br />
$footer
