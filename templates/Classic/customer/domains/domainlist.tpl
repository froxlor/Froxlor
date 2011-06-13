$header
	<form action="{$linker->getLink(array('section' => 'domains'))}" method="post">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['domains']['domainsettings']}</b>&nbsp;({$domains_count})</td>
				<td class="maintitle_search_right" colspan="3">{$searchcode}</td>
			</tr>
			<if ($userinfo['subdomains_used'] < $userinfo['subdomains'] || $userinfo['subdomains'] == '-1') && 15 < $domains_count && $parentdomains_count != 0 >
			<tr>
				<td class="field_display_border_left" colspan="4"><a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'add'))}">{$lng['domains']['subdomain_add']}</a></td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left">{$lng['domains']['domainname']}&nbsp;&nbsp;{$arrowcode['d.domain']}</td>
				<td class="field_display">{$lng['panel']['path']}&nbsp;&nbsp;{$arrowcode['d.documentroot']}</td>
				<td class="field_display_search" colspan="2">{$sortcode}</td>
			</tr>
			$domains
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="4" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<if ($userinfo['subdomains_used'] < $userinfo['subdomains'] || $userinfo['subdomains'] == '-1') && $parentdomains_count != 0 >
			<tr>
				<td class="field_display_border_left" colspan="4"><a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'add'))}">{$lng['domains']['subdomain_add']}</a></td>
			</tr>
			</if>
		</table>
	</form>
	<br />
	<br />
$footer