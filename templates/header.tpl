<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<if $settings['panel']['no_robots'] == '0'>
	<meta name="robots" content="noindex, nofollow, noarchive" />
	<meta name="GOOGLEBOT" content="nosnippet" />
	</if>
	<link rel="stylesheet" href="templates/main.css" type="text/css" />
	<title><if isset($userinfo['loginname']) && $userinfo['loginname'] != ''>{$userinfo['loginname']} - </if>Froxlor</title>
</head>
<body style="margin: 0; padding: 0;"<if !isset($userinfo['loginname']) && !(isset($userinfo['loginname']) && $userinfo['loginname'] == '')> onload="document.loginform.loginname.focus()"</if>>
<!--
    We request you retain the full copyright notice below including the link to www.froxlor.org.
    This not only gives respect to the large amount of time given freely by the developers
    but also helps build interest, traffic and use of Froxlor. If you refuse
    to include even this then support on our forums may be affected.
    The Froxlor Team : 2009-2010
// -->
<!--
	Templates based on work by Luca Piona (info@havanastudio.ch) and Luca Longinotti (chtekk@gentoo.org)
// -->
<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td width="800"><img src="{$settings['admin']['froxlor_graphic']}" width="800" height="90" alt="" /></td>
		<td class="header">&nbsp;</td>
	</tr>
</table>
<table cellspacing="0" cellpadding="0" border="0" width="<if isset($userinfo['loginname'])>100%<else>40%</if>" align="center">
	<tr>
		<if isset($userinfo['loginname'])>
			<td width="240" valign="top" bgcolor="#EBECF5">$navigation<br /></td>
			<td width="15" class="line_shadow">&nbsp;</td>
			<td valign="top" bgcolor="#FFFFFF">
		<else>
			<td valign="top" bgcolor="#FFFFFF">
		</if>
		<br />
		<br />
