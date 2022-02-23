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
 * @author     Maurice Preuß <hello@envoyr.com>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Tabellisting
 *
 */

return [
	'ipsandports_list' => [
		'title' => $lng['admin']['ipsandports']['ipsandports'],
		'icon' => 'fa-solid fa-user',
		'columns' => [
			'ip' => [
				'label' => $lng['admin']['ipsandports']['ip'],
				'column' => 'ip',
			],
			'port' => [
				'label' => $lng['admin']['ipsandports']['port'],
				'column' => 'port',
			],
			'listen' => [
				'label' => 'Listen',
				'column' => 'listen_statement',
				'format_callback' => [\Froxlor\UI\Callbacks\Text::class, 'boolean'],
				'visible' => \Froxlor\Settings::Get('system.webserver') != 'nginx'
			],
			'namevirtualhost' => [
				'label' => 'NameVirtualHost',
				'column' => 'namevirtualhost_statement',
				'format_callback' => [\Froxlor\UI\Callbacks\Text::class, 'boolean'],
				'visible' => \Froxlor\Settings::Get('system.webserver') == 'apache2' && (int) \Froxlor\Settings::Get('system.apache24') == 0
			],
			'vhostcontainer' => [
				'label' => 'vHost-Container',
				'column' => 'vhostcontainer',
				'format_callback' => [\Froxlor\UI\Callbacks\Text::class, 'boolean']
			],
			'specialsettings' => [
				'label' => 'Specialsettings',
				'column' => 'specialsettings',
				'format_callback' => [\Froxlor\UI\Callbacks\Text::class, 'boolean']
			],
			'servername' => [
				'label' => 'ServerName',
				'column' => 'vhostcontainer_servername_statement',
				'format_callback' => [\Froxlor\UI\Callbacks\Text::class, 'boolean'],
				'visible' => \Froxlor\Settings::Get('system.webserver') == 'apache2'
			],
			'ssl' => [
				'label' => 'SSL',
				'column' => 'ssl',
				'format_callback' => [\Froxlor\UI\Callbacks\Text::class, 'boolean']
			],
		],
		'visible_columns' => \Froxlor\UI\Listing::getVisibleColumnsForListing('ipsandports_list', [
			'ip',
			'port',
			'listen',
			'namevirtualhost',
			'vhostcontainer',
			'specialsettings',
			'servername',
			'ssl'
		]),
	]
];
