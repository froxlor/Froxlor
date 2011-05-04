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

$updateto = '0.9-r0';
$frontend = 'froxlor';

showUpdateStep("Upgrading SysCP ".$settings['panel']['version']." to Froxlor ". $updateto, false);
updateToVersion($updateto);

// add field frontend
$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('panel','frontend','".$frontend."')");
$settings['panel']['frontend'] = $frontend;

?>
