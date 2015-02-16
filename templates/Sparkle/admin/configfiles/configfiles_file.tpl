<div class="pushbot">
	<fieldset class="file">
		<legend>{$realname}</legend>
        <textarea class="shell" rows="1" readonly>&dollar;EDITOR {$realname}</textarea>
        <textarea class="filecontent" rows="<if $numbrows <=20 >{$numbrows}<else>21</if>" readonly>{$file_content}</textarea>
	</fieldset>
</div>
