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
	'cronjobs_edit' => array(
		'title' => $lng['admin']['cronjob_edit'],
		'image' => 'icons/clock_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['cronjob']['cronjobsettings'],
				'image' => 'icons/clock_edit.png',
				'fields' => array(
					'cronfile' => array(
						'label' => 'Cronjob',
						'type' => ($change_cronfile == 1 ? 'text' : 'label'),
						'value' => $result['cronfile']
					),
					'isactive' => array(
						'label' => $lng['admin']['activated'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array($result['isactive'])
					),
					'interval_value' => array(
						'label' => $lng['cronjob']['cronjobintervalv'],
						'type' => 'text',
						'value' => $interval_value
					),
					'interval_interval' => array(
						'label' => $lng['cronjob']['cronjobinterval'],
						'type' => 'select',
						'select_var' => $interval_interval
					)
				)
			)
		)
	)
);
