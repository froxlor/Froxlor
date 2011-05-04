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
		'tickets' => array (
			'url' => 'customer_tickets.php',
			'label' => $lng['menue']['ticket']['ticket'],
			'show_element' => ( getSetting('ticket', 'enabled') == true ),
			'elements' => array (
				array (
					'url' => 'customer_tickets.php?page=tickets',
					'label' => $lng['menue']['ticket']['ticket'],
				),
			),
		),
	),
	'admin' => array (
		'tickets' => array (
			'label' => $lng['admin']['ticketsystem'],
			'show_element' => ( getSetting('ticket', 'enabled') == true ),
			'elements' => array (
				array (
					'url' => 'admin_tickets.php?page=tickets',
					'label' => $lng['menue']['ticket']['ticket'],
				),
				array (
					'url' => 'admin_tickets.php?page=archive',
					'label' => $lng['menue']['ticket']['archive'],
				),
				array (
					'url' => 'admin_tickets.php?page=categories',
					'label' => $lng['menue']['ticket']['categories'],
				),
			),
		),
	),
);
?>