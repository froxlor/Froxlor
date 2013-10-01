<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="Default-Style" content="text/css" />
	<if $settings['panel']['no_robots'] == '0'>
	<meta name="robots" content="noindex, nofollow, noarchive" />
	<meta name="GOOGLEBOT" content="nosnippet" />
	</if>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<!--[if lt IE 9]><script src="js/html5shiv.js"></script><![endif]-->
	<if isset($intrafficpage)>
	<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="js/jquery.jqplot.min.js"></script>
	<script language="javascript" type="text/javascript" src="js/plugins/jqplot.barRenderer.min.js"></script>
	<script language="javascript" type="text/javascript" src="js/plugins/jqplot.categoryAxisRenderer.min.js"></script>
	<script language="javascript" type="text/javascript" src="js/plugins/jqplot.pointLabels.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.min.css" />
	<script language="javascript" type="text/javascript" src="templates/{$theme}/assets/js/traffic.js"></script>
	</if>
	<if $settings['panel']['use_webfonts'] == '1'>
		<link href="//fonts.googleapis.com/css?family={$settings['panel']['webfont']}" rel="stylesheet">
	</if>
	<link href="templates/{$theme}/assets/css/main.css" rel="stylesheet" type="text/css" />
	<!--[if IE]><link rel="stylesheet" href="templates/{$theme}/css/main_ie.css" type="text/css" /><![endif]-->
	<link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="templates/{$theme}/assets/js/main.js"></script>
	<link href="templates/{$theme}/assets/img/favicon.ico" rel="icon" type="image/x-icon" />
	<title><if isset($userinfo['loginname']) && $userinfo['loginname'] != ''>{$userinfo['loginname']} - </if>Froxlor Server Management Panel</title>
	<style type="text/css">
	body {
        font-family: <if $settings['panel']['use_webfonts'] == '1'>{$webfont},</if> Verdana, Geneva, sans-serif;
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
	<div class="topheaderinfo">
		<ul class="topheadernav">
		<if $userinfo['adminsession'] == 1 >
			<li><a href="admin_index.php?s={$userinfo['hash']}">{$lng['admin']['overview']}</a></li>
			<li><a href="#">{$lng['panel']['options']}</a>
				<ul>
					<li><a href="admin_index.php?page=change_password&s={$userinfo['hash']}">{$lng['login']['password']}</a></li>
					<li><a href="admin_index.php?page=change_language&s={$userinfo['hash']}">{$lng['login']['language']}</a></li>
					<if $settings['panel']['allow_theme_change_admin'] == '1'>
						<li><a href="admin_index.php?page=change_theme&s={$userinfo['hash']}">{$lng['panel']['theme']}</a></li>
					</if>
				</ul>
			</li>
			<li><a href="admin_index.php?action=logout&s={$userinfo['hash']}">{$lng['login']['logout']} {$userinfo['name']} ({$userinfo['loginname']})</a></li>
		<else>
			<li><a href="customer_index.php?s={$userinfo['hash']}">{$lng['admin']['overview']}</a></li>
			<li><a href="#">{$lng['panel']['options']}</a>
				<ul>
					<li><a href="customer_index.php?page=change_password&s={$userinfo['hash']}">{$lng['login']['password']}</a></li>
					<li><a href="customer_index.php?page=change_language&s={$userinfo['hash']}">{$lng['login']['language']}</a></li>
					<if $settings['panel']['allow_theme_change_customer'] == '1'>
						<li><a href="customer_index.php?page=change_theme&s={$userinfo['hash']}">{$lng['panel']['theme']}</a></li>
					</if>
				</ul>
			</li>
			<li><a href="customer_index.php?action=logout&s={$userinfo['hash']}">{$lng['login']['logout']} {$userinfo['firstname']} {$userinfo['name']} ({$userinfo['loginname']})</a></li>
		</if>
		</ul>
	</div>
</header>

	<nav>$navigation</nav>
	<div class="main bradiusodd">
<else>
	<div class="loginpage">
</if>
