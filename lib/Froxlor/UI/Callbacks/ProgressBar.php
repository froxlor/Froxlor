<?php

namespace Froxlor\UI\Callbacks;

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
 * @package    Listing
 *
 */
class ProgressBar
{
	/**
	 * TODO: use twig for html templates ...
	 *
	 * @param string $data
	 * @param array $attributes
	 * @return string
	 */
	public static function diskspace(string $data, array $attributes): string
	{
		$infotext = '';
		if (isset($attributes['customerid'])) {
			// get disk-space usages for web, mysql and mail
			$usages_stmt = \Froxlor\Database\Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_DISKSPACE . "`
				WHERE `customerid` = :cid
				ORDER BY `stamp` DESC LIMIT 1
			");
			$usages = \Froxlor\Database\Database::pexecute_first($usages_stmt, array(
				'cid' => $attributes['customerid']
			));

			if ($usages != true) {
				$usages = [
					'webspace' => 0,
					'mailspace' => 0,
					'dbspace' => 0
				];
			}

			$infotext = \Froxlor\UI\Panel\UI::getLng('panel.used') . ':<br>';
			$infotext .= 'web: ' . \Froxlor\PhpHelper::sizeReadable($usages['webspace'] * 1024, null, 'bi') . '<br>';
			$infotext .= 'mail: ' . \Froxlor\PhpHelper::sizeReadable($usages['mailspace'] * 1024, null, 'bi') . '<br>';
			$infotext .= 'mysql: ' . \Froxlor\PhpHelper::sizeReadable($usages['dbspace'] * 1024, null, 'bi');

			$infotext = '<i class="fa-solid fa-circle-info" title="' . $infotext . '"></i>&nbsp;';
		}

		$pbdata = self::pbData('diskspace', $attributes, 1024, (int)\Froxlor\Settings::Get('system.report_webmax'));
		return '<div class="progress progress-thin"><div class="progress-bar ' . $pbdata['style'] . '" style="width: ' . $pbdata['percent'] . '%;"></div></div><div class="text-end">' . $infotext . $pbdata['text'] . '</div>';
	}

	/**
	 * TODO: use twig for html templates ...
	 *
	 * @param string $data
	 * @param array $attributes
	 * @return string
	 */
	public static function traffic(string $data, array $attributes): string
	{
		$pbdata = self::pbData('traffic', $attributes, 1024 * 1024, (int)\Froxlor\Settings::Get('system.report_trafficmax'));
		return '<div class="progress progress-thin"><div class="progress-bar ' . $pbdata['style'] . '" style="width: ' . $pbdata['percent'] . '%;"></div></div><div class="text-end">' . $pbdata['text'] . '</div>';
	}

	/**
	 * do needed calculations
	 */
	private static function pbData(string $field, array $attributes, int $size_factor = 1024, int $report_max = 90): array
	{
		$percent = 0;
		$style = 'bg-info';
		$text = \Froxlor\PhpHelper::sizeReadable($attributes[$field . '_used'] * $size_factor, null, 'bi') . ' / ' . \Froxlor\UI\Panel\UI::getLng('customer.unlimited');
		if ((int) $attributes[$field] >= 0) {
			if (($attributes[$field] / 100) * $report_max < $attributes[$field . '_used']) {
				$style = 'bg-danger';
			} elseif (($attributes[$field] / 100) * ($report_max - 15) < $attributes[$field . '_used']) {
				$style = 'bg-warning';
			}
			$percent = round(($attributes[$field . '_used'] * 100) / ($attributes[$field] == 0 ? 1 : $attributes[$field]), 0);
			if ($percent > 100) {
				$percent = 100;
			}
			$text = \Froxlor\PhpHelper::sizeReadable($attributes[$field . '_used'] * $size_factor, null, 'bi') . ' / ' . \Froxlor\PhpHelper::sizeReadable($attributes[$field] * $size_factor, null, 'bi');
		}

		return [
			'percent' => $percent,
			'style' => $style,
			'text' => $text
		];
	}
}
