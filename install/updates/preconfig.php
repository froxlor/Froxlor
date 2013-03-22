<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Function getPreConfig
 *
 * outputs various content before the update process
 * can be continued (askes for agreement whatever is being asked)
 *
 * @param string version
 *
 * @return string
 */
function getPreConfig($current_version)
{
	$has_preconfig = false;
	$return = '<div class="preconfig"><h3 style="color:#ff0000;">PLEASE NOTE - Important update notifications</h3>';

	include_once makeCorrectFile(dirname(__FILE__).'/preconfig/0.9/preconfig_0.9.inc.php');
	parseAndOutputPreconfig($has_preconfig, $return, $current_version);

	$return .= '<br /><br />'.makecheckbox('update_changesagreed', '<strong>I have read the update notifications above and I am aware of the changes made to my system.</strong>', '1', true, '0', true);
	$return .= '</div>';
	$return .= '<input type="hidden" name="update_preconfig" value="1" />';

	if($has_preconfig) {
		return $return;
	} else {
		return '';
	}
}

function versionInUpdate($current_version, $version_to_check)
{
	if (!isFroxlor()) {
		return true;
	}

	return (version_compare2($current_version, $version_to_check) == -1 ? true : false);
}

/**
 * compare of froxlor versions
 *
 * @param string $a
 * @param string $b
 *
 * @return integer 0 if equal, 1 if a>b and -1 if b>a
 */
function version_compare2($a, $b) {

	// split version into pieces and remove trailing .0
	$a = explode(".", rtrim($a, ".0"));
	$b = explode(".", rtrim($b, ".0"));

	// -svn or -dev or -rc ?
	if (stripos($a[count($a)-1], '-') !== false) {
		$x = explode("-", $a[count($a)-1]);
		$a[count($a)-1] = $x[0];
		if (stripos($x[1], 'rc') !== false) {
			$a[] = '2'; // rc > dev > svn
			// number of rc
			$a[] = substr($x[1], 2);
		}
		else if (stripos($x[1], 'dev') !== false) {
			$a[] = '1'; // svn < dev < rc
			// number of dev
			$a[] = substr($x[1], 3);
		}
		// -svn version are deprecated
		else if (stripos($x[1], 'svn') !== false) {
			$a[] = '0'; // svn < dev < rc
			// number of svn
			$a[] = substr($x[1], 3);
		}
		else {
			// unknown version string
			return 0;
		}
	}
	// same with $b
	if (stripos($b[count($b)-1], '-') !== false) {
		$x = explode("-", $b[count($b)-1]);
		$b[count($b)-1] = $x[0];
		if (stripos($x[1], 'rc') !== false) {
			$b[] = '2'; // rc > dev > svn
			// number of rc
			$b[] = substr($x[1], 2);
		}
		else if (stripos($x[1], 'dev') !== false) {
			$b[] = '1'; // svn < dev < rc
			// number of dev
			$b[] = substr($x[1], 3);
		}
		// -svn version are deprecated
		else if (stripos($x[1], 'svn') !== false) {
			$b[] = '0'; // svn < dev < rc
			// number of svn
			$b[] = substr($x[1], 3);
		}
		else {
			// unknown version string
			return 0;
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
