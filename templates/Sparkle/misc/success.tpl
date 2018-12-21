$header
<div class="messagewrapper">
	<div class="successcontainer bradius">
		<div class="successtitle">{\Froxlor\I18N\Lang::getAll()['success']['success']}</div>
		<div class="success">
			$success_message
			<if $redirect_url != ''>
				<br /><br /><a href="{$redirect_url}">{\Froxlor\I18N\Lang::getAll()['success']['clickheretocontinue']}</a>
			</if>
		</div>
	</div>
</div>
$footer
