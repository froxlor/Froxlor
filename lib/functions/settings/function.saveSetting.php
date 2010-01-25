<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id$
 */

function saveSetting($settinggroup, $varname, $newvalue)
{
	global $db;
	$query = 'UPDATE `' . TABLE_PANEL_SETTINGS . '` SET `value` = \'' . $db->escape($newvalue) . '\' WHERE `settinggroup` = \'' . $db->escape($settinggroup) . '\' AND `varname`=\'' . $db->escape($varname) . '\'';
	return $db->query($query);
}

?>
