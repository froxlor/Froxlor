<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="Default-Style" content="text/css" />
	{if $settings.panel.no_robots == 0}
	<meta name="robots" content="noindex, nofollow, noarchive" />
	<meta name="GOOGLEBOT" content="nosnippet" />
	{/if}
	<link href="templates/{$theme}/assets/img/favicon.ico" rel="icon" type="image/x-icon" />
	<link rel="stylesheet" href="templates/{$theme}/assets/css/main.css" />
	<!--[if IE]><link rel="stylesheet" href="templates/{$theme}/assets/css/main_ie.css"  /><![endif]-->
	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="templates/{$theme}/assets/js/main.js"></script>
	<title>{$title}Froxlor Server Management Panel</title>
</head>
<body>

{if $loggedin == 1}
<header class="topheader">
	<hgroup>
		<h1>Froxlor Server Management Panel</h1>
	</hgroup>
	<img src="{$header_logo}" alt="Froxlor Server Management Panel" />
</header>

<nav>{$navigation}</nav>
{/if}

{if $loggedin}
	<div class="main bradiusodd">
{else}
	<div class="loginpage">
{/if}
{$body}
</div>
<footer>
	<span>Froxlor
		{if ($settings.admin.show_version_login == '1' && $loggedin == 0) || ($settings.admin.show_version_footer == '1' && $loggedin == 1)}
			{$version}{$branding}
		{/if}
		&copy; 2009-{$current_year} by <a href="http://www.froxlor.org/" rel="external">{t}the Froxlor Team{/t}</a>
	</span>
</footer>
</body>
</html>
