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

use Froxlor\Install\Update;
use Froxlor\Settings;

$preconfig = [
	'title' => '2.3.x updates',
	'fields' => []
];
$return = [];

if (Update::versionInUpdate($current_db_version, '202508310')) {
	if (Settings::Get('system.webserver') == 'lighttpd') {
		$has_preconfig = true;
		$description = 'You seem to be using "lighttpd" as webserver, froxlor 2.3 no longer supports this webserver. Please select an alternative one. Remember to configure the service after the update!';
		$question = '<strong>Switch webserver to:</strong>&nbsp;';
		$return['system_alt_webserver'] = [
			'type' => 'select',
			'select_var' => [
				'apache2' => 'Apache 2.4',
				'nginx' => 'Nginx'
			],
			'selected' => 'apache2',
			'label' => $question,
			'prior_infotext' => $description
		];
	}
}

$preconfig['fields'] = $return;
return $preconfig;
