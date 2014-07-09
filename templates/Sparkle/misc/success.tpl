$header
<div class="messagewrapper">
	<div class="successcontainer bradius">
		<div class="successtitle">{$lng['success']['success']}</div>
		<div class="success">
			$success_message
			<if $redirect_url != ''>
				<br /><br /><a href="{$redirect_url}">{$lng['success']['clickheretocontinue']}</a>
			</if>
		</div>
	</div>
</div>
$footer
