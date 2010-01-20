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
 * @version    $Id: 30.aps.installer.php 2733 2009-11-06 09:32:00Z flo $
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