<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="iso-8859-1" />
	<meta http-equiv="Default-Style" content="text/css" />
	<if $settings['panel']['no_robots'] == '0'>
	<meta name="robots" content="noindex, nofollow, noarchive" />
	<meta name="GOOGLEBOT" content="nosnippet" />
	</if>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<if isset($intrafficpage)>
        <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="js/excanvas.js"></script><![endif]-->
        <script language="javascript" type="text/javascript" src="js/jquery.jqplot.min.js"></script>
        <script language="javascript" type="text/javascript" src="js/plugins/jqplot.barRenderer.min.js"></script>
        <script language="javascript" type="text/javascript" src="js/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script language="javascript" type="text/javascript" src="js/plugins/jqplot.pointLabels.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css" />
	<script language="javascript" type="text/javascript" src="js/traffic.js"></script>
	</if>
	<link rel="stylesheet" href="templates/Froxlor/froxlor.css"  />
	<!--[if IE]><link rel="stylesheet" href="templates/Froxlor/froxlor_ie.css"  /><![endif]-->
	<script type="text/javascript" src="templates/Froxlor/js/froxlor.js"></script>
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
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
