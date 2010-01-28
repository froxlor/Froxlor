<?php
header("Vary: Accept");
header("Content-Type: text/html; charset=utf-8");

require_once(dirname(__FILE__).'/functions.inc.php');

$version = checkGetVar('version');
$vendor = checkGetVar('vendor');
$module = checkGetVar('module');
$pretty = checkGetVar('style');

if($pretty != '')
	$pretty = true;

if($vendor == '')
	$vendor = 'froxlor';

if($module == '')
	$module = 'legacy';

if($pretty)
	echo htmlHeader('checking '.$version);

/*
 * validate values
 */
if(!preg_match('/^[a-z0-9\-\.]+$/Di',$vendor))
{
	vdie('Unknown vendor', $pretty);
}
if(!preg_match('/^[a-z0-9\-\.]+$/Di',$module))
{
	vdie('Unknown module', $pretty);
}
if(!preg_match('/^[0-9\.(\-r|\-rc|\-svn|)]+$/Di',$version))
{
	vdie('Unknown version for '.$vendor.'/'.$module, $pretty);
}

$recent = array();
$recent = getLatestFroxlorVersion($vendor, $module, $version);

updateStats($vendor, $module, $version);

if(isset($recent['error']) && $recent['error'] == true)
{
	if(isset($recent['message'])) {
		vdie($recent['message'], $pretty);
	} else {
		vdie(null, $pretty);
	}
}
else
{
	$out = '';
	if($recent['has_latest'])
	{
		if($pretty) {
			$out .= '<ul>
				<li>Your version: <strong>'.$version.'</strong></li>
				<li>Latest version: <strong>'.$recent['version'].'</strong></li>
				<li>&nbsp;</li>';
				if($recent['is_testing']) {
					$out .= '<li><strong>You already have the latest testing version of Froxlor installed.</strong></li>';
				} else {
					$out .= '<li><strong>You already have the latest version of Froxlor installed.</strong></li>';
				}
			$out .= '</ul>';
				
			showSuccess($out);
		} else {
			if($recent['is_testing']) {
				echo $version.':You already have the latest testing version of Froxlor installed.';
			} else {
				echo $version.':You already have the latest version of Froxlor installed.';
			}
		}
	}
	else
	{
		if($pretty) {
			$out .= '<ul>
			<li>Your version: <strong>'.$version.'</strong></li>
			<li>Latest version: <strong>'.$recent['version'].'</strong></li>
			<li>&nbsp;</li>';
			if($recent['is_testing']) {
				$out .= '<li><strong>There is a newer testing version of Froxlor available, please update.</strong></li>';
			} else {
				$out .= '<li><strong>There is a newer version of Froxlor available, please update.</strong></li>';
			}
				
			if($recent['uri'] != '') {
				$out .= '<li>&nbsp;</li>
				<li><a href="'.$recent['uri'].'">'.$recent['uri'].'</a></li>';
			}
			if($recent['message'] != '') {
				$out .= '<li>&nbsp;</li>
				<li>Info: '.$recent['message'].'</li>';
			}
			$out .= '</ul>';
				
			showWarning($out);
		} else {
			echo $recent['version'].':'.$recent['uri'].':'.$recent['message'];
		}
	}
}

if($pretty)
echo htmlFooter();

?>
