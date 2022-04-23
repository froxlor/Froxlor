<?php

namespace Froxlor\UI\Callbacks;

use Froxlor\PhpHelper;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\User;

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
 * @package    Froxlor\UI\Callbacks
 *
 */
class Style
{
	public static function deactivated(array $attributes): string
	{
		return $attributes['fields']['deactivated'] ? 'bg-danger' : '';
	}

	public static function resultIntegrityBad(array $attributes): string
	{
		return $attributes['fields']['result'] ? '' : 'bg-warning';
	}

	public static function invalidApiKey(array $attributes): string
	{
		// check whether the api key is not valid anymore
		$isValid = true;
		if ($attributes['fields']['valid_until'] >= 0) {
			if ($attributes['fields']['valid_until'] < time()) {
				$isValid = false;
			}
		}
		return $isValid ? '' : 'bg-danger';
	}

	public static function resultDomainTerminatedOrDeactivated(array $attributes): string
	{
		$termination_date = str_replace("0000-00-00", "", $attributes['fields']['termination_date'] ?? '');
		$termination_css = '';
		if (!empty($termination_date)) {
			$cdate = strtotime($termination_date . " 23:59:59");
			$today = time();
			$termination_css = 'bg-warning';
			if ($cdate < $today) {
				$termination_css = 'bg-danger';
			}
		}
		return $attributes['fields']['deactivated'] ? 'bg-info' : $termination_css;
	}

	public static function diskspaceWarning(array $attributes): string
	{
		return self::getWarningStyle('diskspace', $attributes['fields'], (int)Settings::Get('system.report_webmax'));
	}

	public static function trafficWarning(array $attributes): string
	{
		return self::getWarningStyle('traffic', $attributes['fields'], (int)Settings::Get('system.report_trafficmax'));
	}

	private static function getWarningStyle(string $field, array $attributes, int $report_max = 90): string
	{
		$style = '';
		if ((int)$attributes[$field] >= 0) {
			if (($attributes[$field] / 100) * $report_max < $attributes[$field . '_used']) {
				$style = 'bg-danger';
			} elseif (($attributes[$field] / 100) * ($report_max - 15) < $attributes[$field . '_used']) {
				$style = 'bg-warning';
			}
		}
		return $style;
	}
}
