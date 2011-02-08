$header
	<br />
	<form method="post" action="$filename" name="loginform">
		<if $message != ''>
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="2"><b>&nbsp;<img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['error']['error']}/{$lng['error']['info']}</b></td>
			</tr>
			<tr>
				<td class="field_name_center_noborder" style="padding: 15px;"><img src="images/Classic/info.png" alt="" /></td>
				<td class="field_name" width="80%">$message</td>
			</tr>
		</table>
		<br />
		<br />
		</if>
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle" colspan="3"><b><img src="images/Classic/title.gif" alt="" />&nbsp;Froxlor&nbsp;-&nbsp;Login</b></td>
			</tr>
			<tr>
				<td rowspan="3" class="field_name_center"><img src="images/Classic/login.gif" alt="" /></td>
				<td class="field_name"><font size="-1">{$lng['login']['username']}:</font></td>
				<td class="field_display"><input type="text" class="text" name="loginname" value="" maxlength="50" /></td>
			</tr>
			<tr>
				<td class="field_name"><font size="-1">{$lng['login']['password']}:</font></td>
				<td class="field_display"><input type="password" class="text" name="password" maxlength="50" /></td>
			</tr>
			<tr>
				<td class="field_name"><font size="-1">{$lng['login']['language']}:</font></td>
				<td class="field_display"><select class="dropdown_noborder" name="language">$language_options</select></td>
			</tr>
			<tr>
				<td class="field_name_center" colspan="3"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['login']['login']}" /></td>
			</tr>
			<if $settings['panel']['allow_preset'] == '1'>
			<tr>
				<td class="field_name_center" colspan="3"><a href="$filename?action=forgotpwd">{$lng['login']['forgotpwd']}</a></td>
			</tr>
			</if>
			<if $update_in_progress !== ''>
			<tr>
				<td class="field_name_center" colspan="3">{$update_in_progress}</td>
			</tr>
			</if>			
		</table>
	</form>
	<br />
	<br />
	<br />
$footer
