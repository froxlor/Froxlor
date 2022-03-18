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
 *
 */

/**
 * Function showUpdateStep
 *
 * stores and logs the current update progress
 *
 * @param string $task
 * @param bool $needs_status (if false, a linebreak will be added)
 *        	
 * @return void
 */
function showUpdateStep($task = null, $needs_status = true)
{
	global $update_tasks, $task_counter;

	set_time_limit(30);

	// output
	$update_tasks[$task_counter] = ['title' => $task, 'result' => 0];

	if (!$needs_status) {
		$task_counter++;
	}

	\Froxlor\FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_WARNING, $task);
}

/**
 * Function lastStepStatus
 *
 * outputs status of the last update-step
 *
 * @param int $status (0 = success, 1 = warning, 2 = failure)
 * @param string $message
 * @param string $additional_info
 *        	
 * @return string formatted output and log-entry
 */
function lastStepStatus(int $status = -1, string $message = '', string $additional_info = '')
{
	global $update_tasks, $task_counter;

	$update_tasks[$task_counter]['result_txt'] = $message ?? 'OK';
	$update_tasks[$task_counter]['result_desc'] = $additional_info ?? '';

	switch ($status) {

		case 0:
			break;
		case 1:
			$update_tasks[$task_counter]['result'] = 2;
			break;
		case 2:
			$update_tasks[$task_counter]['result'] = 1;
			break;
		default:
			$update_tasks[$task_counter]['result'] = -1;
			break;
	}

	$task_counter++;

	if ($status == -1 || $status == 2) {
		\Froxlor\FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_WARNING, 'Attention - last update task failed!!!');
	} elseif ($status == 0 || $status == 1) {
		\Froxlor\FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_WARNING, 'Success');
	}
}
