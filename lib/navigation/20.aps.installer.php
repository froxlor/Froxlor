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
 * @package    Navigation
 *
 */

return array (
	'customer' => array (
		'aps' => array (
			'label' => $lng['customer']['aps'],
			'required_resources' => 'phpenabled',
			'show_element' => ( getSetting('aps', 'aps_active') == true ),
			'elements' => array (
				array (
					'url' => 'customer_aps.php?action=overview',
					'label' => $lng['aps']['overview'],
				),
				array (
					'url' => 'customer_aps.php?action=customerstatus',
					'label' => $lng['aps']['status'],
				),
				array (
					'url' => 'customer_aps.php?action=search',
					'label' => $lng['aps']['search'],
				),
			),
		),
	),
	'admin' => array (
		'aps' => array (
			'label' => $lng['admin']['aps'],
			'required_resources' => 'can_manage_aps_packages',
			'show_element' => ( getSetting('aps', 'aps_active') == true ),
			'elements' => array (
				array (
					'url' => 'admin_aps.php?action=upload',
					'label' => $lng['aps']['upload'],
				),
				array (
					'url' => 'admin_aps.php?action=scan',
					'label' => $lng['aps']['scan'],
				),
				array (
					'url' => 'admin_aps.php?action=managepackages',
					'label' => $lng['aps']['managepackages'],
				),
				array (
					'url' => 'admin_aps.php?action=manageinstances',
					'label' => $lng['aps']['manageinstances'],
				),
			),
		),
	),
);
?>