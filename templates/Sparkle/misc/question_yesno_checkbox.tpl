$header
<div class="messagewrapper">
	<form action="$yesfile" method="post">
		<div class="warningcontainer bradius">
			<div class="warningtitle">{$lng['question']['question']}</div>
			<div class="warning">
				$text
				<div class="messagecheckbox">$checkbox</div>
				<div>
					<input type="hidden" name="s" value="$s" />
					<input type="hidden" name="send" value="send" />
					{$hiddenparams}
					<input type="submit" name="submitbutton" value="{$lng['panel']['yes']}" />&nbsp;
					<input type="button" class="nobutton" value="{$lng['panel']['no']}" id="historyback" />
				</div>
			</div>
		</div>
	</form>
</div>
$footer
