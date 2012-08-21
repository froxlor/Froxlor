<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2011- the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2011-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

function getFilesystemQuota()
{
	global $settings, $theme;
	if ($settings['system']['diskquota_enabled'])
	{
		# Fetch all quota in the desired partition
		exec($settings['system']['diskquota_repquota_path'] . " -np " . escapeshellarg($settings['system']['diskquota_customer_partition']), $repquota);

		$usedquota = array();
		foreach ($repquota as $tmpquota)
		{
			# Let's see if the line matches a quota - line
			if (preg_match('/^#([0-9]+)\s*[+-]{2}\s*(\d+)\s*(\d+)\s*(\d+)\s*(\d+)\s*(\d+)\s*(\d+)\s*(\d+)\s*(\d+)/i', $tmpquota, $matches))
			{
				# It matches - put it into an array with userid as key (for easy lookup later)
				$usedquota[$matches[1]] = array(
						'block' => array(
						'used' => $matches[2],
						'soft' => $matches[3],
						'hard' => $matches[4],
						'grace' => $matches[5]
					),
						'file' => array(
						'used' => $matches[6],
						'soft' => $matches[7],
						'hard' => $matches[8],
						'grace' => $matches[9]
					),
				);
			}
		}

		return $usedquota;
	}
	return false;
}
