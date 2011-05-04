<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 *
 */

// Required code

define('AREA', 'admin');
require ("./lib/init.php");
$Id = 0;

if(isset($_GET['id']))$Id = (int)$_GET['id'];

if(isset($_POST['id']))$Id = (int)$_POST['id'];
eval("echo \"" . getTemplate("aps/header") . "\";");
$Aps = new ApsParser($userinfo, $settings, $db);
$Aps->MainHandler($action);
eval("echo \"" . getTemplate("aps/footer") . "\";");

?>