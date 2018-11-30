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
	<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="js/plugins/jquery.tablesorter.sizeparser.min.js"></script>
	<!--[if lt IE 9]><script type="text/javascript" src="js/html5shiv.min.js"></script><![endif]-->
	<if isset($intrafficpage)>
	<!--[if lt IE 9]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
	<script type="text/javascript" src="js/jquery.flot.min.js"></script>
	<script type="text/javascript" src="js/plugins/jquery.flot.resize.min.js"></script>
	<script type="text/javascript" src="templates/{$theme}/assets/js/traffic.js"></script>
	</if>
	<script type="text/javascript" src="templates/{$theme}/assets/js/tipper.min.js"></script>
	<script type="text/javascript" src="templates/{$theme}/assets/js/jcanvas.min.js"></script>
	<script type="text/javascript" src="templates/{$theme}/assets/js/circular.js"></script>
	<script type="text/javascript" src="templates/{$theme}/assets/js/autosize.min.js"></script>
	{$css}
	<!--[if IE]><link rel="stylesheet" href="templates/{$theme}/assets/css/main_ie.css" type="text/css" /><![endif]-->
	<link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
	{$js}
	<link href="templates/{$theme}/assets/img/favicon.ico" rel="icon" type="image/x-icon" />
	<link href="templates/{$theme}/assets/img/touchicon.png" rel="shortcut" />
	<link href="templates/{$theme}/assets/img/touchicon.png" rel="apple-touch-icon" />
	<title><if isset($userinfo['loginname']) && $userinfo['loginname'] != ''>{$userinfo['loginname']} - </if>Froxlor Server Management Panel</title>
</head>
<body>

<if isset($userinfo['loginname'])>
<header class="topheader">
	<hgroup>
		<h1>Froxlor Server Management Panel</h1>
	</hgroup>
	<a href="{$linker->getLink(array('section' => 'index'))}">
		<img src="{$header_logo}" alt="Froxlor Server Management Panel" class="small" />
	</a>
	<div class="topheader_navigation">
		<ul class="topheadernav">
			<if Settings::Get('ticket.enabled') == 1>
				<li>
					<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'tickets'))}">
						<if 0 < $awaitingtickets>
							<img src="templates/{$theme}/assets/img/icons/menubar_tickets.png" alt="{$lng['menue']['ticket']['ticket']}" />
							<span class="countbubble">{$awaitingtickets}</span>
						<else>
							<img src="templates/{$theme}/assets/img/icons/menubar_tickets_null.png" alt="{$lng['menue']['ticket']['ticket']}" />
						</if>
					</a>
				</li>
			</if>
			<li>{$userinfo['loginname']}</li>
			<li><a href="{$linker->getLink(array('section' => 'index'))}">{$lng['panel']['dashboard']}</a></li>
			<li><a href="#">{$lng['panel']['options']}&nbsp;&#x25BE;</a>
				<ul>
					<li><a href="{$linker->getLink(array('section' => 'index', 'page' => 'change_password'))}">{$lng['login']['password']}</a></li>
					<li><a href="{$linker->getLink(array('section' => 'index', 'page' => 'change_language'))}">{$lng['login']['language']}</a></li>
					<if Settings::Get('2fa.enabled') == 1>
						<li><a href="{$linker->getLink(array('section' => 'index', 'page' => '2fa'))}">{$lng['2fa']['2fa']}</a></li>
					</if>
					<if Settings::Get('panel.allow_theme_change_admin') == '1' && $userinfo['adminsession'] == 1>
						<li><a href="{$linker->getLink(array('section' => 'index', 'page' => 'change_theme'))}">{$lng['panel']['theme']}</a></li>
					</if>
					<if Settings::Get('panel.allow_theme_change_customer') == '1' && $userinfo['adminsession'] == 0>
						<li><a href="{$linker->getLink(array('section' => 'index', 'page' => 'change_theme'))}">{$lng['panel']['theme']}</a></li>
					</if>
					<if Settings::Get('api.enabled') == 1>
						<li><a href="{$linker->getLink(array('section' => 'index', 'page' => 'apikeys'))}">{$lng['menue']['main']['apikeys']}</a></li>
						<li><a href="https://api.froxlor.org/doc/" rel="external">{$lng['menue']['main']['apihelp']}</a></li>
					</if>
				</ul>
			</li>
			<li><a href="{$linker->getLink(array('section' => 'index', 'action' => 'logout'))}" class="logoutlink">{$lng['login']['logout']}</a></li>
		</ul>
	</div>
</header>
<div class="content">
	<nav id="sidenavigation">$navigation</nav>
	<div class="main" id="maincontent">
</if>
