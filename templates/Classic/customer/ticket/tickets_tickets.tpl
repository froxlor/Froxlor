<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$row['lastchange']}</td>
	<td class="field_name">{$row['ticket_answers']}</td>
	<td class="field_name">{$row['subject']}</td>
	<td class="field_name">{$row['status']}</td>
	<td class="field_name">{$row['lastreplier']}</td>
	<td class="field_name">{$row['priority']}</td>
	<td class="field_name">
    <a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'answer', 'id' => $row['id']))}">
    <if $cananswer < 1 >{$lng['ticket']['show']}</if>
    <if 0 < $cananswer >{$lng['ticket']['answer']}</if>
    </a>
  </td>
	<td class="field_name">    
    <if $reopen < 1 >
      <a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'close', 'id' => $row['id']))}">{$lng['ticket']['close']}</a>
    </if>
    <if 0 < $reopen >
      <a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets', 'action' => 'reopen', 'id' => $row['id']))}">{$lng['ticket']['reopen']}</a>
    </if>
  </td> 
</tr>
