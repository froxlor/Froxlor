$header
<div class="messagewrapper">
	<div class="successcontainer bradius">
		<div class="successtitle">{\Froxlor\I18N\Lang::getAll()['update']['update']}</div>
		<div class="success">$success_message
			<if $redirect_url != ''>
				<br /><br /><a href="{$redirect_url}">{\Froxlor\I18N\Lang::getAll()['success']['clickheretocontinue']}
			</if>
		</div>
	</div>
</div>
$footer
