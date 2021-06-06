<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="Default-Style" content="text/css" />
	<link rel="stylesheet" href="templates/Sparkle/assets/css/main.css" />
	<!--[if IE]><link rel="stylesheet" href="templates/Sparkle/assets/css/main_ie.css" /><![endif]-->
	<!--[if lt IE 9]><script src="js/html5shiv.min.js"></script><![endif]-->
	<link href="templates/Sparkle/assets/img/favicon.ico" rel="icon" type="image/x-icon" />
	<title>Froxlor Server Management Panel - Installation</title>
</head>
<body>
<div class="loginpage">
	
	<article class="errorbox bradius">
		<header class="dark">
			<img src="templates/Sparkle/assets/img/logo.png" alt="Froxlor Server Management Panel" />
		</header>

		<section class="errorsec">
			<div class="errorcontainer bradius">
				<div class="errortitle">Whoops!</div>
				<div class="error">
					<p>It seems you are missing some required files.</p>
					<p>&nbsp;</p>
					<p>Froxlor uses composer for its external requirements.<br />Try the following command to install them:</p>
					<p>&nbsp;</p>
					<p><pre>cd <FROXLOR_INSTALL_DIR> && composer install --no-dev</pre></p>
				</div>
			</div>
			<aside class="right">
				<a href="index.php" title="Click to refresh">Refresh</a>
			</aside>
		</section>

	</article>

</div>
<footer>
	<span>
		Froxlor &copy; 2009-<CURRENT_YEAR> by <a href="https://www.froxlor.org/" rel="external">the Froxlor Team</a>
	</span>
</footer>
</body>
</html>
