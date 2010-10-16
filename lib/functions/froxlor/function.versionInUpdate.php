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
 * @package    Functions
 * @version    $Id$
 */

/**
 * check whether the current version is
 * lower than the given version
 *  
 * @param string $current_version  current installed version of froxlor
 * @param string $version_to_check version to check for update
 * 
 * @return bool
 */
function versionInUpdate($current_version, $version_to_check)
{
	if (!isFroxlor()) {
		return true;
	}
	$pos_a = strpos($current_version, '-svn');
	$pos_b = strpos($version_to_check, '-svn');
	// if we compare svn-versions, we have to add -svn0 to the version
	// to compare it correctly	
	if($pos_a === false && $pos_b !== false)
	{
		$current_version.= '-svn9999';
	}
	
	return version_compare($current_version, $version_to_check, '<');
}

/**
 * check whether the current version is
 * lower than the given version
 * - without checking if this is Froxlor
 *   because we need this in our loadSettings
 *   functions and isFroxlor() needs settings
 *   already
 *  
 * @param string $current_version  current installed version of froxlor
 * @param string $version_to_check version to check for update
 * 
 * @return bool
 */
function compareFroxlorVersion($current_version, $version_to_check)
{
	$pos_a = strpos($current_version, '-svn');
	$pos_b = strpos($version_to_check, '-svn');
	// if we compare svn-versions, we have to add -svn0 to the version
	// to compare it correctly	
	if($pos_a === false && $pos_b !== false)
	{
		$current_version.= '-svn9999';
	}
	
	return version_compare($current_version, $version_to_check, '<');
}
