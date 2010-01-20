<tr  class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$ticket['lastchange']}</td>
	<td class="field_name">{$ticket['ticket_answers']}</td>
	<td class="field_name">{$ticket['subject']}</td>
	<td class="field_name">{$ticket['lastreplier']}</td>
	<td class="field_name">{$ticket['priority']}</td>
	<td class="field_name">
    <a href="$filename?page=archive&amp;action=view&amp;id={$ticket['id']}&amp;s=$s">{$lng['ticket']['show']}</a>
  </td>  
</tr>
