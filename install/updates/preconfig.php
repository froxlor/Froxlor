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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    http://files.froxlor.org/misc/COPYING.txt GPLv2
 */

/**
 * Function getPreConfig
 *
 * outputs various form-field-arrays before the update process
 * can be continued (asks for agreement whatever is being asked)
 *
 * @param string $current_version
 * @param int $current_db_version
 *
 * @return array
 */
function getPreConfig($current_version, $current_db_version): array
{
	$has_preconfig = false;

	include_once \Froxlor\FileDir::makeCorrectFile(dirname(__FILE__) . '/preconfig/0.11/preconfig_0.11.inc.php');
	$return['section_011'] = [
		'title' => '0.11.x updates',
		'fields' => []
	];
	parseAndOutputPreconfig011($has_preconfig, $return['section_011']['fields'], $current_version, $current_db_version);

	if (empty($return['section_011']['fields'])) {
		unset($return['section_011']);
	}

	if (!empty($return)) {
		$has_preconfig = true;
		$return['section_agree'] = [
			'title' => 'Check',
			'fields' => [
				'update_changesagreed' => ['type' => 'checkbox', 'value' => 1, 'label' => '<strong>I have read the update notifications above and I am aware of the changes made to my system.</strong>'],
				'update_preconfig' => ['type' => 'hidden', 'value' => 1]
			]
		];
	}

	if ($has_preconfig) {
		return $return;
	} else {
		return [];
	}
}

function versionInUpdate($current_version, $version_to_check)
{
	if (!\Froxlor\Froxlor::isFroxlor()) {
		return true;
	}

	return \Froxlor\Froxlor::versionCompare2($current_version, $version_to_check) == -1;
}
