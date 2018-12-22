$header
<div class="messagewrapper">
	<div class="successcontainer bradius">
		<div class="successtitle">{$lng['update']['update']}</div>
		<div class="success">$success_message
			<if $redirect_url != ''>
				<br /><br /><a href="{$redirect_url}">{$lng['success']['clickheretocontinue']}
			</if>
		</div>
	</div>
</div>
$footer
