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
 * @package    Formfields
 *
 */

return array(
	'section_a' => array(
		'fields' => array(
			'cronfile' => array(
				'label' => 'Cronjob',
				'type' => ($change_cronfile == 1 ? 'text' : 'static'),
			),
			'isactive' => array(
				'label' => $lng['admin']['activated'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => 1,
			),
			'interval_value' => array(
				'label' => $lng['cronjob']['cronjobintervalv'],
				'type' => 'text'
			),
			'interval_interval' => array(
				'label' => $lng['cronjob']['cronjobinterval'],
				'type' => 'select',
				'values' => $interval_interval
			)
		)
	)
);
