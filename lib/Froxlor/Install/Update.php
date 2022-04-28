<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\Install;

use Froxlor\FroxlorLogger;

class Update
{

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
	public static function showUpdateStep($task = null, $needs_status = true)
	{
		global $update_tasks, $task_counter;

		set_time_limit(30);

		// output
		$update_tasks[$task_counter] = ['title' => $task, 'result' => 0];

		if (!$needs_status) {
			$task_counter++;
		}

		FroxlorLogger::getInstanceOf()->logAction(FroxlorLogger::ADM_ACTION, LOG_WARNING, $task);
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
	public static function lastStepStatus(int $status = -1, string $message = '', string $additional_info = '')
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
			FroxlorLogger::getInstanceOf()->logAction(FroxlorLogger::ADM_ACTION, LOG_WARNING, 'Attention - last update task failed!!!');
		} elseif ($status == 0 || $status == 1) {
			FroxlorLogger::getInstanceOf()->logAction(FroxlorLogger::ADM_ACTION, LOG_WARNING, 'Success');
		}
	}
}
