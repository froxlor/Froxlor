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
 * @package    Install
 *
 */

if (!defined('AREA')
		|| (defined('AREA') && AREA != 'admin')
		|| !isset($userinfo['loginname'])
		|| (isset($userinfo['loginname']) && $userinfo['loginname'] == '')
) {
	header('Location: ../../../index.php');
	exit;
}

$updateto = '0.9-r0';
$frontend = 'froxlor';

showUpdateStep("Upgrading SysCP ".Settings::Get('panel.version')." to Froxlor ". $updateto, false);
updateToVersion($updateto);

// add field frontend
Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
	`settinggroup` = 'panel',
	`varname` = 'frontend',
	`value` = 'froxlor'"
);
Settings::Set('panel.frontend', $frontend);
