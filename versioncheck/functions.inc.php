<?php

function checkGetVar($name = null)
{
	$return = '';
	if($name !== null && $name != '')
	{
		$return = (isset($_GET[$name]) && $_GET[$name] != '') ? $_GET[$name] : '';
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
<div class="NoticeContainer">
  <div class="NoticeTitle">Success</div>
  <div class="Notice">'.$message.'</div>
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

	$warn = '
<div class="WarningContainer">
  <div class="WarningTitle">Attention</div>
  <div class="Warning">'.$message.'</div>
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
<div class="ErrorContainer">
  <div class="ErrorTitle">Error</div>
  <div class="Error">'.$message.'</div>
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

function getLatestFroxlorTestingVersion()
{
	$version_file = dirname(__FILE__).'/vfiles/froxlor_legacy_testing.version';
	$vf_data = getVersionInfoFromFile($version_file);
	return $vf_data;
}

function getLatestFroxlorVersion($vendor, $module, $version)
{
	$version_file = dirname(__FILE__).'/vfiles/'.strtolower($vendor).'_'.strtolower($module).'.version';
	$vf_data = getVersionInfoFromFile($version_file);

	$return = array();

	if(!isset($vf_data['error']))
	{
		$v = $vf_data[0];
		$u = isset($vf_data[1]) ? $vf_data[1] : '';
		$m = isset($vf_data[2]) ? $vf_data[2] : '';

		$vc = version_compare2($v, $version);

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
			$vf_data = getLatestFroxlorTestingVersion();
			if(!isset($vf_data['error']))
			{
				$v = $vf_data[0];
				$u = isset($vf_data[1]) ? $vf_data[1] : '';
				$m = isset($vf_data[2]) ? $vf_data[2] : '';

				$vc = version_compare2($v, $version);

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

//Compare two sets of versions, where major/minor/etc. releases are separated by dots.
//Returns 0 if both are equal, 1 if A > B, and -1 if B < A.
function version_compare2($a, $b)
{
	$a = explode(".", rtrim($a, ".0")); //Split version into pieces and remove trailing .0
	$b = explode(".", rtrim($b, ".0")); //Split version into pieces and remove trailing .0
	foreach ($a as $depth => $aVal)
	{ //Iterate over each piece of A
		if (isset($b[$depth]))
		{ //If B matches A to this depth, compare the values
			if ($aVal > $b[$depth]) return 1; //Return A > B
			else if ($aVal < $b[$depth]) return -1; //Return B > A
			//An equal result is inconclusive at this point
		}
		else
		{ //If B does not match A to this depth, then A comes after B in sort order
			return 1; //so return A > B
		}
	}
	//At this point, we know that to the depth that A and B extend to, they are equivalent.
	//Either the loop ended because A is shorter than B, or both are equal.
	return (count($a) < count($b)) ? -1 : 0;
}

function htmlFooter()
{
	$out = '</div>
	<div class="footer">
		<ul>
			<li>Froxlor Versioncheck &copy; 2010 by <a href="http://www.froxlor.org/" rel="external">the Froxlor Team</a></li>
		</ul>
	</div>
	</body>
</html>';

	return $out;
}

function htmlHeader($title)
{
	$out = '<?xml version="1.0" encoding="utf-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" >
  <head>
    <meta name="Publisher" content="Froxlor Staff" />
    <meta name="Copyright" content="froxlor.org" /> 
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <title>Froxlor - Versioncheck ['.$title.']</title>
    <style type="text/css">
    <!--
      body { 
        margin: auto; 
        margin-top: 0; 
        margin-left: 0; 
        width: auto; 
        text-align: center; 
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
      }
      
      a,a:visited,a:active {
      	color				: #000000;
      	text-decoration		: underline;
        border: 0;
      }
      
      a:hover {
      	color				: #F89826;
      	text-decoration		: none;
        border: 0;
      }

      ul {
      	margin				: 0;
      	padding				: 0;
      	list-style			: none;
      }
      
      .content {
		padding				: 10px 10px 50px 10px !important;
		margin				: 1.75em 200px .75em 200px !important;
      }      
     
      .header {
		text-align			: center;
      }
      
      .footer {
      	margin-top			: 25px;
      	text-align			: center;
      }
      
	.ErrorContainer {
		background: url(images/bad.png) 10px center no-repeat #FFEDEF;
		border: 1px solid #FFC2CA;
		padding: 10px !important;
		margin: 1.75em 5% .75em 5% !important;
		overflow: hidden;
		text-align: left;
	}
	
	.ErrorTitle {
		font-weight: bold;
		color: #c00 !important;
		margin-bottom: .5em;
		margin-left: 100px;		
	}
	
	.Error {
		color: #c00 !important;
		margin-left: 100px;		
	}
	
	.Error span a {
		color: #c00 !important;
	}
	
	.Error span a:hover {
		color: #c00 !important;
		text-decoration: underline;
	}
	
	.WarningContainer {
		background: url(images/warning.png) 10px center no-repeat #FFFECC;
		border: 1px solid #FAEBB1;
		padding: 10px !important;
		margin: 1.75em 5% .75em 5% !important;
		overflow: hidden;
		text-align: left;		
	}
	
	.WarningTitle {
		font-weight: bold;
		color: #D57D00;
		margin-bottom: .5em;
		margin-left: 100px;		
	}
	
	.Warning {
		color: #D57D00 !important;
		margin-left: 100px;		
	}
	
	.Warning span a {
		color: #D57D00 !important;
	}
	
	.Warning span a:hover {
		color: #D57D00 !important;
		text-decoration: underline;
	}
	
	.NoticeContainer {
		background: url(images/ok.png) 10px center no-repeat #E2F9E3;
		border: 1px solid #9C9;
		padding: 10px !important;
		margin: 1.75em 5% .75em 5% !important;
		overflow: hidden;
		text-align: left;		
	}
	
	.NoticeTitle {
		font-weight: bold;
		color: #060 !important;
		margin-bottom: .5em;
		margin-left: 100px;		
	}
	
	.Notice {
		color: #060 !important;
		margin-left: 100px;		
	}
	
	.Notice span a {
		color: #060 !important;
	}
	
	.Notice span a:hover {
		color: #060 !important;
		text-decoration: underline;
	}	
      -->
    </style> 
  </head>
  <body>
  	<div class="content">
		<div class="header">
  			<img src="images/header.png" alt="Froxlor" />
		</div>';

	return $out;
}

function updateStats($vendor, $module, $version)
{
	return;
	/*
	 $query = 'INSERT INTO
	 `stats`
		(
		`vendor` ,
		`module` ,
		`version` ,
		`ip`,
		`time`
		)
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

?>
