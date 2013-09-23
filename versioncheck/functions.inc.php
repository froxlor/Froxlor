<?php

function checkGetVar($name = null, $bool = false) {
	$return = '';
	if ($name !== null && $name != '') {
		$return = (isset($_GET[$name]) && $_GET[$name] != '') ? $_GET[$name] : ($bool == true ? false : '');
	}
	return $return;
}

function vdie($message, $pretty)
{
	if($pretty) {
		dienice($message);
	} else {
		die($message);
	}
}

function showSuccess($message = null)
{
	if($message == null || $message == '')
	{
		$message = 'unknown success-message';
	}

	$succ = '
<div class="alert alert-success">
	<h4>Up-to-date</h4>
  <p>'.$message.'</p>
</div>
';

	echo $succ;
}

function showWarning($message = null)
{
	if($message == null || $message == '')
	{
		$message = 'unknown warning';
	}

	$warn = '<div class="alert alert-block">
	<h4>Attention</h4>
<p>&nbsp;</p>
  <p>'.$message.'</p>
</div>
';

	echo $warn;
}

function dienice($message = null)
{
	if($message == null || $message == '')
	{
		$message = 'unknown error in version-check';
	}

	$err = '
<div class="alert alert-error">
	<h4>Error</h4>
<p>&nbsp;</p>
  <p>'.$message.'</p>
</div>
';

	$err = $err.htmlFooter();

	die($err);
}

function getVersionInfoFromFile($version_file)
{
	if(file_exists($version_file))
	{
		if(is_readable($version_file))
		{
			$vf = file_get_contents($version_file);

			if($vf !== false && $vf != '')
			{
				$vf_data = explode('|', $vf);
				return $vf_data;
			}
		}
		return array('error' => true, 'message' => 'Cannot read version-file. Please contact the Froxlor-Team to fix this.');
	}
	return array('error' => true, 'message' => 'Unknown vendor/module combination');
}

function getLatestFroxlorTestingVersion($vendor = 'froxlor', $module = 'legacy')
{
	$version_file = dirname(__FILE__).'/vfiles/'.strtolower($vendor).'_'.strtolower($module).'_testing.version';
	$vf_data = getVersionInfoFromFile($version_file);
	return $vf_data;
}

function getLatestFroxlorVersion($vendor, $module, $version) {

	$version_file = dirname(__FILE__).'/vfiles/'.strtolower($vendor).'_'.strtolower($module).'.version';
	$vf_data = getVersionInfoFromFile($version_file);

	$return = array();

	if(!isset($vf_data['error']))
	{
		$v = $vf_data[0];
		$u = isset($vf_data[1]) ? $vf_data[1] : '';
		$m = isset($vf_data[2]) ? $vf_data[2] : '';

		$vc = version_compare3($v, $version);

		if($vc == 0) {
			$return['has_latest'] = true;
			$return['version'] = $v;
		}
		elseif($vc == 1) {
			$return['has_latest'] = false;
			$return['version'] = $v;
			$return['uri'] = $u;
			$return['message'] = $m;
		}
		else
		{
			/*
			 * maybe testing version?
			 */
			$vf_data = getLatestFroxlorTestingVersion($vendor, $module);
			if(!isset($vf_data['error']))
			{
				$v = $vf_data[0];
				$u = isset($vf_data[1]) ? $vf_data[1] : '';
				$m = isset($vf_data[2]) ? $vf_data[2] : '';
				$vc = version_compare3($v, $version);

				if($vc == 0) {
					$return['has_latest'] = true;
					$return['is_testing'] = true;
					$return['version'] = $v;
				}
				elseif($vc == 1) {
					$return['has_latest'] = false;
					$return['is_testing'] = true;
					$return['version'] = $v;
					$return['uri'] = $u;
					$return['message'] = $m;
				}
				else
				{
					return array('error' => true, 'message' => 'It looks like your Froxlor installation has been customized, no support sorry.');
				}
			}
			else
			{
				/*
				 * return error
				 */
				$return = $vf_data;
			}
		}
	}
	else
	{
		$return = $vf_data;
	}
	return $return;
}

/**
 * compare of froxlor versions
 *
 * @param string $a
 * @param string $b
 *
 * @return integer 0 if equal, 1 if a>b and -1 if b>a
 */
function version_compare3($a, $b) {

	// split version into pieces and remove trailing .0
	$a = explode(".", rtrim($a, ".0"));
	$b = explode(".", rtrim($b, ".0"));

	_parseVersionArray($a);
	_parseVersionArray($b);

	while (count($a) != count($b)) {
		if (count($a) < count($b)) {
			$a[] = '0';
		}
		elseif (count($b) < count($a)) {
			$b[] = '0';
		}
	}

	foreach ($a as $depth => $aVal) {
		// iterate over each piece of A
		if (isset($b[$depth])) {
			// if B matches A to this depth, compare the values
			if ($aVal > $b[$depth]) {
				return 1; // A > B
			}
			else if ($aVal < $b[$depth]) {
				return -1; // B > A
			}
			// an equal result is inconclusive at this point
		} else {
			// if B does not match A to this depth, then A comes after B in sort order
			return 1; // so A > B
		}
	}
	// at this point, we know that to the depth that A and B extend to, they are equivalent.
	// either the loop ended because A is shorter than B, or both are equal.
	return (count($a) < count($b)) ? -1 : 0;
}

function _parseVersionArray(&$arr = null) {
	// -svn or -dev or -rc ?
	if (stripos($arr[count($arr)-1], '-') !== false) {
		$x = explode("-", $arr[count($arr)-1]);
		$arr[count($arr)-1] = $x[0];
		if (stripos($x[1], 'rc') !== false) {
			$arr[] = '-1';
			$arr[] = '2'; // rc > dev > svn
			// number of rc
			$arr[] = substr($x[1], 2);
		}
		else if (stripos($x[1], 'dev') !== false) {
			$arr[] = '-1';
			$arr[] = '1'; // svn < dev < rc
			// number of dev
			$arr[] = substr($x[1], 3);
		}
		// -svn version are deprecated
		else if (stripos($x[1], 'svn') !== false) {
			$arr[] = '-1';
			$arr[] = '0'; // svn < dev < rc
			// number of svn
			$arr[] = substr($x[1], 3);
		}
	}
}

function htmlFooter()
{

	$url = 'http://www.froxlor.org/';

	$out = '		</div>
	</div>
</div>
</div>

<div class="footer-row">
	<div class="container">
		<div>
			<p style="margin-top:20px;">
                           <a href="'.$url.'">froxlor website</a> | <a href="'.$url.'/legal.html">Legal note</a> | <a href="'.$url.'/disclaimer.html">Disclaimer</a>
			</p>
                </div>
		<p style="padding-top:14px;" class="muted credit">Froxlor &copy; 2009-'.date('Y', time()).' by <a href="'.$url.'">the Froxlor team</a></p>
	</div>
</div>
</body>
</html>';

	return $out;
}

function htmlHeader($title)
{
	$url = 'http://www.froxlor.org/';

	$out = '<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta charset="utf-8" />
	<link href="//fonts.googleapis.com/css?family=Open+Sans:400&amp;lang=de" rel="stylesheet">
	<link href="'.$url.'/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="'.$url.'/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
	<link href="'.$url.'/fontawesome/font-awesome.min.css" rel="stylesheet" media="screen">
	<!--[if IE 7]>
	<link rel="stylesheet" href="'.$url.'/fontawesome/font-awesome-ie7.min.css">
	<![endif]-->
	<link href="'.$url.'/assets/css/main.css" rel="stylesheet" type="text/css" />
	<link href="'.$url.'/assets/images/favicon.ico" rel="shortcut icon" type="image/ico" />
	<title>Froxlor Server Management Panel - Version check ['.$title.']</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
	<script type="text/javascript" src="'.$url.'/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="'.$url.'/assets/js/froxlor.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes" />

	<meta property="og:type" content="website">
	<meta property="og:url" content="'.$url.'">
	<meta property="og:image" content="'.$url.'/assets/images/logo.png">
	<meta property="og:title" content="Froxlor: The server administration software for your needs.">
	<meta property="og:site_name" content="Froxlor Website">
</head>

<body class="welcome" itemscope itemtype="http://schema.org/WebPage">
<noscript>

</noscript>
<div class="wrapper">
<!-- Header -->
<div class="header-row">
	<div class="container">
		<div class="navbar">
			<div class="container">
				<a class="brand" href="'.$_SERVER['REQUEST_URI'].'">
					<img src="'.$url.'/assets/images/logo.png" alt="Froxlor - Server Management Panel">
				</a>
				<div class="header-menu">
					<!-- later -->
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-main">
<div class="hero-row">
        <div class="container">
                <div class="row-fluid">
                        <div class="span8">
                                <h1>froxlor <small>version check</small></h1>
				<p>'.$title.'...</p>
			</div>
		</div>
	</div>
</div>
<div class="container" style="margin-top:15px;">
        <div class="row-fluid">
                <div class="span12">';
	return $out;
}

function updateStats($vendor, $module, $version)
{
	return;
	/*
	 $query = 'INSERT INTO
	 `stats`
		(`vendor`, `module`, `version`, `ip`, `time`)
	VALUES
		(
		\'' . $db->escape($vendor) . '\',
		\'' . $db->escape($module) . '\',
		\'' . $db->escape($version) . '\',
		\'' . $db->escape($HTTP_SERVER_VARS["REMOTE_ADDR"]) . '\',
		\'' . date('Y-m-d H:i:s') .'\'
	);';
	$db->query($query);
	$db->close();
	*/
}
