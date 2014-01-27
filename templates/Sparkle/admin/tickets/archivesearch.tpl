$header
	<section>
		<header>
			<h2><img src="templates/{$theme}/assets/img/icons/ticket_archive_big.png" alt="" />&nbsp;{$lng['ticket']['archivesearch']}</h2>
		</header>
		<form action="{$linker->getLink(array('section' => 'tickets'))}" method="post">
			<input type="hidden" name="s" value="$s"/>
			<input type="hidden" name="page" value="$page"/>
			<input type="hidden" name="send" value="send" />
			<table class="full">
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
	</section>
$footer
