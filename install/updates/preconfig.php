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
 * @package    Language
 *
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

	include_once \Froxlor\FileDir::makeCorrectFile(dirname(__FILE__) . '/preconfig/0.9/preconfig_0.9.inc.php');
	$return['section_09'] = [
		'title' => '0.9.x updates',
		'fields' => []
	];
	parseAndOutputPreconfig09($has_preconfig, $return['section_09']['fields'], $current_version, $current_db_version);

	include_once \Froxlor\FileDir::makeCorrectFile(dirname(__FILE__) . '/preconfig/0.10/preconfig_0.10.inc.php');
	$return['section_010'] = [
		'title' => '0.10.x updates',
		'fields' => []
	];
	parseAndOutputPreconfig010($has_preconfig, $return['section_010']['fields'], $current_version, $current_db_version);

	include_once \Froxlor\FileDir::makeCorrectFile(dirname(__FILE__) . '/preconfig/0.11/preconfig_0.11.inc.php');
	$return['section_011'] = [
		'title' => '0.11.x updates',
		'fields' => []
	];
	parseAndOutputPreconfig011($has_preconfig, $return['section_011']['fields'], $current_version, $current_db_version);

	if (empty($return['section_09']['fields'])) {
		unset($return['section_09']);
	}
	if (empty($return['section_010']['fields'])) {
		unset($return['section_010']);
	}
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
