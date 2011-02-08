<if $Type == 0>
<div class="warningcontainer bradius">
	<div class="warningtitle">{$lng['success']['success']}</div>
	<div class="warning">
		$Message
	</div>
</div>
</if>
<if $Type == 1>
<div class="errorcontainer bradius">
	<div class="errortitle">{$lng['error']['error']}</div>
	<div class="error">
		$Message
	</div>
</div>
</if>
<if $Type == 2>
<div class="successcontainer bradius">
	<div class="successtitle">{$lng['success']['success']}</div>
	<div class="success">
		$Message
	</div>
</div>
</if>
