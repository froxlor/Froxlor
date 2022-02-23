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
		}

		$disk_percent = 0;
		$style = 'bg-info';
		$text = \Froxlor\PhpHelper::sizeReadable($attributes['diskspace_used'] * 1024, null, 'bi') . ' / ' . \Froxlor\UI\Panel\UI::getLng('customer.unlimited');
		if ((int) $attributes['diskspace'] >= 0) {
			if (($attributes['diskspace'] / 100) * (int)\Froxlor\Settings::Get('system.report_webmax') < $attributes['diskspace_used']) {
				$style = 'bg-danger';
			} elseif (($attributes['diskspace'] / 100) * ((int)\Froxlor\Settings::Get('system.report_webmax') - 15) < $attributes['diskspace_used']) {
				$style = 'bg-warning';
			}
			$disk_percent = round(($attributes['diskspace_used'] * 100) / ($attributes['diskspace'] == 0 ? 1 : $attributes['diskspace']), 0);
			if ($disk_percent > 100) {
				$disk_percent = 100;
			}
			$text = \Froxlor\PhpHelper::sizeReadable($attributes['diskspace_used'] * 1024, null, 'bi') . ' / ' . \Froxlor\PhpHelper::sizeReadable($attributes['diskspace'] * 1024, null, 'bi');
		}

		if (!empty($infotext)) {
			$infotext = '<i class="fa-solid fa-circle-info" title="' . $infotext . '"></i>&nbsp;';
		}
		return '<div class="progress progress-thin"><div class="progress-bar bg-info" style="width: ' . $disk_percent . '%;"></div></div><div class="text-end">' . $infotext . $text . '</div>';
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
		$percentage = $attributes['traffic_used'] ? round(100 * $attributes['traffic_used'] / $attributes['traffic']) : 0;
		$text = Number::traffic($attributes['traffic_used']) . ' / ' . Number::traffic($attributes['traffic']);

		return '<div class="progress progress-thin"><div class="progress-bar bg-info" style="width: ' . $percentage . '%;"></div></div><div class="text-end">' . $text . '</div>';
	}
}
