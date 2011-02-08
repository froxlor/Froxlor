<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="iso-8859-1" />
	<meta http-equiv="Default-Style" content="text/css" />
	<if $settings['panel']['no_robots'] == '0'>
	<meta name="robots" content="noindex, nofollow, noarchive" />
	<meta name="GOOGLEBOT" content="nosnippet" />
	</if>
	<link rel="stylesheet" href="templates/Froxlor/froxlor.css"  />
	<!--[if IE]><link rel="stylesheet" href="templates/Froxlor/froxlor_ie.css"  /><![endif]-->
	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<script type="text/javascript" src="templates/Froxlor/js/jquery.min.js"></script>
	<script type="text/javascript" src="templates/Froxlor/js/froxlor.js"></script>
	<title><if isset($userinfo['loginname']) && $userinfo['loginname'] != ''>{$userinfo['loginname']} - </if>Froxlor Server Management Panel</title>
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
