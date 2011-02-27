<div class="messagewrapper">
	<div class="warningcontainer bradius">
		<div class="warningtitle">{$lng['question']['question']}</div>
		<div class="warning">
			$Message
			<div style="text-align:right;">
				<form name="continue" action="$filename" method="post">
					<input type="submit" name="answer" value="{$lng['panel']['yes']}" />
					<input type="hidden" name="save" value="1"/>
					<input type="hidden" name="s" value="$s"/>
					<input type="hidden" name="action" value="$action"/>
					$Ids
				</form>
				&nbsp;
				<form name="back" action="$filename" method="post">
					<input type="submit" name="submit" value="{$lng['panel']['no']}" />
					<input type="hidden" name="action" value="<if isset($action_alt)>$action_alt<else>$action</if>"/>
					<input type="hidden" name="s" value="$s"/>
				</form>
			</div>
		</div>
		</div>
	</form>
</div>

