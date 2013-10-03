$header
	<header>
		<h3><img src="templates/{$theme}/assets/img/icons/ticket_archive.png" alt="" />&nbsp;{$lng['ticket']['archivesearch']}</h3>
	</header>
	<form action="{$linker->getLink(array('section' => 'tickets'))}" method="post">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="fullform bradius">
      		<if 0 < $tickets_count >
				<tr>
					<th class="field_display_border_left">{$lng['ticket']['archivedtime']}</th>
					<th class="field_display">{$lng['ticket']['ticket_answers']}</th>
					<th class="field_display">{$lng['ticket']['subject']}</th>
					<th class="field_display">{$lng['ticket']['lastreplier']}</th>
					<th class="field_display">{$lng['ticket']['priority']}</th>
	        		<th class="field_display_search">&nbsp;</th>
				</tr>
				$tickets
      		</if>
      		<if $tickets_count < 1 >
        		<tr>
				<td class="field_display_border_left" colspan="6">{$lng['ticket']['noresults']}</td>
				</tr>
			</if>
		</table>
	</form>
$footer
