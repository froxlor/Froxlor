<tr  class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$row['name']}</td>
  <td class="field_name">{$row['ticketcount']}&nbsp;({$row['ticketcountnotclosed']}&nbsp;{$lng['ticket']['open']}&nbsp;|&nbsp;{$closedtickets_count}&nbsp;{$lng['ticket']['closed']})</td>
	<td class="field_name">
    <a href="$filename?page=categories&amp;action=editcategory&amp;id={$row['id']}&amp;s=$s">{$lng['panel']['edit']}</a>
  </td>
  <td class="field_name">
    <a href="$filename?page=categories&amp;action=deletecategory&amp;id={$row['id']}&amp;s=$s">{$lng['panel']['delete']}</a>
  </td>
</tr>
