<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
	<tr>
		<td class="maintitle" colspan="3"><b><img src="images/title.gif" alt="" />&nbsp;{$Xml->name}</b></td>
	</tr>
	<tr>
		<td class="field_name_border_left" colspan="2" valign="top" width="99%"><strong>$Summary</strong></td>
		<td class="field_name" style="text-align: center; padding: 10px; background-color:#FFFFFF;" valign="middle"><img src="{$Icon}" alt="{$Xml->name} Icon"/></td>
	</tr>
	<tr>
		<td class="title" colspan="3"><strong>{$lng['aps']['data']}</strong></td>
	</tr>
	$Data
	<tr>
		<td class="field_name_border_left" colspan="3">
		<if $action == 'overview' || $action == 'search'>
			<form method="get" action="$filename" style="float:left;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="details" />
				<input type="hidden" name="id" value="{$Row['ID']}" />
				<input class="bottom" type="submit" value="{$lng['aps']['detail']}" />
			</form>
		</if>
		<if $action != 'overview' && $action !='search' && $action != 'customerstatus'>
			<form method="get" action="$filename" style="float:left;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="overview" />
				<input class="bottom" type="submit" value="{$lng['aps']['back']}" />
			</form>
		</if>
		<if $action != 'customerstatus' && ( $userinfo['aps_packages'] != $userinfo['aps_packages_used'] )>
			<form method="get" action="$filename" style="float:left; padding-left: 5px;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="install" />
				<input type="hidden" name="id" value="{$Row['ID']}" />
				<input class="bottom" type="submit" value="{$lng['aps']['install']}" />
			</form>
		</if>
		<if ($action == 'customerstatus') && ($Row['Status'] == 2 || $Row['Status'] == 3)>
			<form method="get" action="$filename" style="float:left;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="remove" />
				<input type="hidden" name="id" value="{$Row['ID']}" />
				<input class="bottom" type="submit" value="{$lng['aps']['uninstall']}" />
			</form>
		</if>
		</td>
	</tr>
</table>
<br/>
