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
 * @version    $Id: formfield.domains_add.php 112 2010-12-14 12:11:20Z d00p $
 */

return array(
	'emails_addforwarder' => array(
		'title' => $lng['emails']['forwarder_add'],
		'image' => 'icons/add_autoresponder.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['emails']['forwarder_add'],
				'image' => 'icons/add_autoresponder.png',
				'fields' => array(
					'email_full' => array(
						'label' => $lng['emails']['from'],
						'type' => 'label',
						'value' => $result['email_full']
					),
					'destination' => array(
						'label' => $lng['emails']['to'],
						'type' => 'text'
					)
				)
			)
		)
	)
);
