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

namespace Froxlor\Traffic;

use Froxlor\Api\Commands\Customers;
use Froxlor\UI\Collection;

class Traffic
{
	public static function getCustomerStats($userinfo, $range = null): array
	{
		$trafficCollectionObj = (new Collection(\Froxlor\Api\Commands\Traffic::class, $userinfo, self::getParamsByRange($range, ['customer_traffic' => true,])));
		if ($userinfo['adminsession'] == 1) {
			$trafficCollectionObj->has('customer', Customers::class, 'customerid', 'customerid');
		}
		$trafficCollection = $trafficCollectionObj->get();

		// build stats for each user
		$users = [];
		$years = [];
		$months = [];
		foreach ($trafficCollection['data']['list'] as $item) {
			// per user total
			$users[$item['customerid']]['loginname'] = $item['customer']['loginname'];
			$users[$item['customerid']]['total'] += ($item['http'] + $item['ftp_up'] + $item['ftp_down'] + $item['mail']);
			$users[$item['customerid']]['http'] += $item['http'];
			$users[$item['customerid']]['ftp'] += ($item['ftp_up'] + $item['ftp_down']);
			$users[$item['customerid']]['mail'] += $item['mail'];
			// per year
			$years[$item['year']]['total']['total'] += ($item['http'] + $item['ftp_up'] + $item['ftp_down'] + $item['mail']);
			$years[$item['year']]['total']['http'] += $item['http'];
			$years[$item['year']]['total']['ftp'] += ($item['ftp_up'] + $item['ftp_down']);
			$years[$item['year']]['total']['mail'] += $item['mail'];
			// per month
			$months[$item['year']][$item['month']]['total'] += ($item['http'] + $item['ftp_up'] + $item['ftp_down'] + $item['mail']);
			$months[$item['year']][$item['month']]['http'] += $item['http'];
			$months[$item['year']][$item['month']]['ftp'] += ($item['ftp_up'] + $item['ftp_down']);
			$months[$item['year']][$item['month']]['mail'] += $item['mail'];
		}

		// calculate overview for given range from users
		$metrics = [];
		foreach ($users as $user) {
			$metrics['total'] += $user['total'];
			$metrics['http'] += $user['http'];
			$metrics['ftp'] += $user['ftp'];
			$metrics['mail'] += $user['mail'];
		}

		return [
			'metrics' => $metrics,
			'users' => $users,
			'years' => $years,
			'months' => $months
		];
	}

	private static function getParamsByRange($range = null, array $params = [])
	{
		$dateParams = [];

		if (preg_match("/year:([0-9]{4})/", $range, $matches)) {
			$dateParams = ['year' => $matches[1]];
		}

		// TODO: get params by range: hours:x, days:x, months:x

		return array_merge($dateParams, $params);
	}

	public static function getCustomerChart($userinfo, $range = 30): array
	{
		// FIXME: this is currently an example for the chart

		$data = [];

		for ($i = 0; $i < $range; $i++) {
			$data['labels'][] = date("d.m", strtotime('-' . $i . ' days'));

			// put data for given date
			$data['http'][] = 0;
			$data['ftp'][] = 0;
			$data['mail'][] = 0;
		}

		return [
			'labels' => array_reverse($data['labels']),
			'http' => array_reverse($data['http']),
			'ftp' => array_reverse($data['ftp']),
			'mail' => array_reverse($data['mail']),
			'range' => $range,
		];
	}
}
