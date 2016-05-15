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
class DnsEntry
{

	public $record;

	public $ttl;

	public $class = 'IN';

	public $type;

	public $priority;

	public $content;

	public function __construct($record = '', $type = 'A', $content = null, $prio = 0, $ttl = 18000, $class = 'IN')
	{
		$this->record = $record;
		$this->type = $type;
		$this->content = $content;
		$this->priority = $prio;
		$this->ttl = $ttl;
		$this->class = $class;
	}

	public function __toString()
	{
		$result = $this->record . "\t" . $this->ttl . "\t" . $this->class . "\t" . $this->type . "\t" . (($this->priority >= 0 && ($this->type == 'MX' || $this->type == 'SRV')) ? $this->priority . "\t" : "") . $this->content . PHP_EOL;
		return $result;
	}
}
