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
 * @package    Panel
 * @version    $Id: 000.version.php 2733 2009-11-06 09:32:00Z flo $
 */

return array(
	'groups' => array(
		'version' => array(
			'fields' => array(
				'system_dbversion' => array(
					'settinggroup' => 'system',
					'varname' => 'dbversion',
					'type' => 'hidden',
					'default' => '',
					),
				'system_last_tasks_run' => array(
					'settinggroup' => 'system',
					'varname' => 'last_tasks_run',
					'type' => 'hidden',
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				'system_last_traffic_run' => array(
					'settinggroup' => 'system',
					'varname' => 'last_traffic_run',
					'type' => 'hidden',
					'default' => '',
					),
				'system_lastcronrun' => array(
					'settinggroup' => 'system',
					'varname' => 'lastcronrun',
					'type' => 'hidden',
					'default' => '',
					),
				'system_lastguid' => array(
					'settinggroup' => 'system',
					'varname' => 'lastguid',
					'type' => 'hidden',
					'default' => 9999,
					),
				'system_lastaccountnumber' => array(
					'settinggroup' => 'system',
					'varname' => 'lastaccountnumber',
					'type' => 'hidden',
					'default' => 0,
					),
				),
			),
		),
	);

?>