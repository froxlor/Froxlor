		<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
			<td class="field_name_border_left">{$language}</td>
			<td class="field_name">{$template}</td>
			<td class="field_name"><a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'delete', 'subjectid' => $subjectid, 'mailbodyid' => $mailbodyid))}">{$lng['panel']['delete']}</a></td>
			<td class="field_name"><a href="{$linker->getLink(array('section' => 'templates', 'page' => $page, 'action' => 'edit', 'subjectid' => $subjectid, 'mailbodyid' => $mailbodyid))}">{$lng['panel']['edit']}</a></td>
		</tr>
