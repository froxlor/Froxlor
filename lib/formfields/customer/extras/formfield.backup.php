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
 */

return array(
	'backup' => array(
		'title' => $lng['backup'],
		'image' => 'icons/backup.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['backup'],
				'image' => 'icons/backup.png',
				'fields' => array(
					'path' => array(
						'label' => $lng['extras']['backup_create'],
						'desc' => $lng['extras']['backup_info'].'<br />'.($settings['system']['backup_bigfile'] == 1 ? $lng['extras']['backup_info_big'] : $lng['extras']['backup_info_sep']).'<br />'.($settings['system']['backup_count'] == 1 ? $lng['extras']['backup_count_info'] : ''),
						'type' => 'yesno',
						'yesno_var' => $backup_enabled
					)
				)
			)
		)
	)
);
