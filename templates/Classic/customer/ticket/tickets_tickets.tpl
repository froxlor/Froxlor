<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$row['lastchange']}</td>
	<td class="field_name">{$row['ticket_answers']}</td>
	<td class="field_name">{$row['subject']}</td>
	<td class="field_name">{$row['status']}</td>
	<td class="field_name">{$row['lastreplier']}</td>
	<td class="field_name">{$row['priority']}</td>
	<td class="field_name">
    <a href="$filename?page=tickets&amp;action=answer&amp;id={$row['id']}&amp;s=$s">
    <if $cananswer < 1 >{$lng['ticket']['show']}</if>
    <if 0 < $cananswer >{$lng['ticket']['answer']}</if>
    </a>
  </td>
	<td class="field_name">    
    <if $reopen < 1 >
      <a href="$filename?page=tickets&amp;action=close&amp;id={$row['id']}&amp;s=$s">{$lng['ticket']['close']}</a>
    </if>
    <if 0 < $reopen >
      <a href="$filename?page=tickets&amp;action=reopen&amp;id={$row['id']}&amp;s=$s">{$lng['ticket']['reopen']}</a>
    </if>
  </td> 
</tr>
