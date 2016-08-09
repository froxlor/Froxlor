<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2016-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Classes
 *
 */
class DnsZone
{

	public $ttl;

	public $origin;

	public $serial;

	public $records;

	public function __construct($ttl = 18000, $origin = '', $serial = '', $records = null)
	{
		$this->ttl = $ttl;
		$this->origin = $origin;
		$this->serial = $serial;
		$this->records = $records;
	}

	public function __toString()
	{
		$_zonefile = "\$TTL " . $this->ttl . PHP_EOL;
		$_zonefile .= "\$ORIGIN " . $this->origin . "." . PHP_EOL;
		if (! empty($this->records)) {
			foreach ($this->records as $record) {
				$_zonefile .= (string) $record;
			}
		}
		return $_zonefile;
	}
}
