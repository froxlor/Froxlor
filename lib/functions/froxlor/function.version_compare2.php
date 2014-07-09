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
 * @author     Michael Kaufmann <d00p@froxlor.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

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
	$a = explode(".", $a);
	$b = explode(".", $b);

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
