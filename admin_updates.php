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
 * @package    Panel
 * @version    $Id: $
 */

define('AREA', 'admin');
require ("./lib/init.php");

if($page == 'overview')
{
	$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_updates");
	
	if(hasUpdates($version))
	{
		if(isset($_POST['send'])
		&& $_POST['send'] == 'send')
		{
	
			eval("echo \"" . getTemplate("update/update_start") . "\";");
			
			include_once('./install/updatesql.php');
			
			eval("echo \"" . getTemplate("update/update_end") . "\";");
	
			updateCounters();
			inserttask('1');
			@chmod('./lib/userdata.inc.php', 0440);
		}
		else
		{
			$current_version = $settings['panel']['version'];
			$new_version = $version;
			
			$ui_text = $lng['update']['update_information'];
			$ui_text = str_replace('%curversion', $current_version, $ui_text);
			$ui_text = str_replace('%newversion', $new_version, $ui_text);
			$update_information = $ui_text;
			
			eval("echo \"" . getTemplate("update/index") . "\";");
		}
	}
	else
	{
		/*
		 * @TODO version-webcheck check here 
		 */

		$success_message = $lng['update']['noupdatesavail'];
		$redirect_url = 'admin_index.php';
		eval("echo \"" . getTemplate("update/noupdatesavail") . "\";");
	}
}
	
?>
