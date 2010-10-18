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
 * @package    Navigation
 * @version    $Id$
 */

return array (
	'admin' => array (
		'multiserver' => array (
			'label' => $lng['admin']['multiserver'],
			'required_resources' => 'change_serversettings',
			'show_element' => ( getSetting('multiserver', 'enabled') == true ),
			'elements' => array (
				array (
					'url' => 'admin_clients.php?page=clients',
					'label' => $lng['menue']['multiserver']['clients'],
				)
			)
		)
	)
);
