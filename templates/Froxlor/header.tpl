<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="Default-Style" content="text/css" />
	<if Settings::Get('panel.no_robots') == '0'>
	<meta name="robots" content="noindex, nofollow, noarchive" />
	<meta name="GOOGLEBOT" content="nosnippet" />
	</if>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<!--[if lt IE 9]><script src="js/html5shiv.js"></script><![endif]-->
	<if isset($intrafficpage)>
	<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="js/jquery.flot.min.js"></script>
	<script language="javascript" type="text/javascript" src="templates/{$theme}/assets/js/traffic.js"></script>
	</if>
	<if Settings::Get('panel.use_webfonts') == '1'>
		<link href="//fonts.googleapis.com/css?family={Settings::Get('panel.webfont')}" rel="stylesheet">
	</if>
	<link href="templates/{$theme}/assets/css/main.css" rel="stylesheet" type="text/css" />
	<!--[if IE]><link rel="stylesheet" href="templates/{$theme}/css/main_ie.css" type="text/css" /><![endif]-->
	<link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="templates/{$theme}/assets/js/main.js"></script>
	<link href="templates/{$theme}/assets/img/favicon.ico" rel="icon" type="image/x-icon" />
	<title><if isset($userinfo['loginname']) && $userinfo['loginname'] != ''>{$userinfo['loginname']} - </if>Froxlor Server Management Panel</title>
	<style type="text/css">
	body {
        font-family: <if Settings::Get('panel.use_webfonts') == '1'>{$webfont},</if> Verdana, Geneva, sans-serif;
	}
	</style>
</head>
<body>

<if isset($userinfo['loginname'])>
<header class="topheader">
	<hgroup>
		<h1>Froxlor Server Management Panel</h1>
	</hgroup>
	<img src="{$header_logo}" alt="Froxlor Server Management Panel" />
</header>

<nav>$navigation</nav>
</if>

<if isset($userinfo['loginname'])>
	<div class="main bradiusodd">
<else>
	<div class="loginpage">
</if>
