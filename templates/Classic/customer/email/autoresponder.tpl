$header
	<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
		<tr>
			<td  class="maintitle" colspan="5"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['menue']['email']['autoresponder']}</b></td>
		</tr>
		<tr>
			<td class="field_display_border_left">{$lng['emails']['emailaddress']}</td>
			<td class="field_display">{$lng['autoresponder']['active']}</td>
			<td class="field_display">{$lng['autoresponder']['startenddate']}</td>
			<td class="field_display">&nbsp;</td>
			<td class="field_display">&nbsp;</td>
		</tr>
		$autoresponder
		<if ($userinfo['email_autoresponder_used'] < $userinfo['email_autoresponder'] || $userinfo['email_autoresponder'] == '-1') >
		<tr>
			<td class="field_display_border_left" colspan="5"><a href="{$linker->getLink(array('section' => 'autoresponder', 'action' => 'add'))}">{$lng['autoresponder']['autoresponder_add']}</a></td>
		</tr>
		</if>
	</table>
	<br />
	<br />
$footer
