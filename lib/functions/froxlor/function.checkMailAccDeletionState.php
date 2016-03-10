<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * check whether an email account is to be deleted
 * reference: #1519
 *
 * @return bool true if the domain is to be deleted, false otherwise
 *        
 */
function checkMailAccDeletionState($email_addr = null)
{
	// example data of task 7: a:2:{s:9:"loginname";s:4:"webX";s:5:"email";s:20:"deleteme@example.tld";}
	
	// check for task
	$result_tasks_stmt = Database::prepare("
		SELECT * FROM `" . TABLE_PANEL_TASKS . "` WHERE `type` = '7' AND `data` LIKE :emailaddr
	");
	Database::pexecute($result_tasks_stmt, array(
		'emailaddr' => "%" . $email_addr . "%"
	));
	$num_results = Database::num_rows();
	
	// is there a task for deleting this email account?
	if ($num_results > 0) {
		return true;
	}
	return false;
}
