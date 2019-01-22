<?php
namespace Froxlor\Dns;

use Froxlor\Settings;

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

	public function __construct($record = '', $type = 'A', $content = null, $prio = 0, $ttl = 0, $class = 'IN')
	{
		$this->record = $record;
		$this->type = $type;
		$this->content = $content;
		$this->priority = $prio;
		$this->ttl = ($ttl <= 0 ? Settings::Get('system.defaultttl') : $ttl);
		$this->class = $class;
	}

	public function __toString()
	{
		$_content = $this->content;
		// check content length for txt records for bind9 (multiline)
		if (Settings::Get('system.dns_server') != 'pdns' && $this->type == 'TXT' && strlen($_content) >= 255) {
			// split string
			$_contentlines = str_split($_content, 254);
			// first line
			$_l = array_shift($_contentlines);
			// check for starting quote
			if (substr($_l, 0, 1) == '"') {
				$_l = substr($_l, 1);
			}
			$_content = '("' . $_l . '"' . PHP_EOL;
			$_l = array_pop($_contentlines);
			// check for ending quote
			if (substr($_l, - 1) == '"') {
				$_l = substr($_l, 0, - 1);
			}
			foreach ($_contentlines as $_cl) {
				// lines in between
				$_content .= "\t\t\t\t" . '"' . $_cl . '"' . PHP_EOL;
			}
			// last line
			$_content .= "\t\t\t\t" . '"' . $_l . '")';
		}
		$result = $this->record . "\t" . $this->ttl . "\t" . $this->class . "\t" . $this->type . "\t" . (($this->priority >= 0 && ($this->type == 'MX' || $this->type == 'SRV')) ? $this->priority . "\t" : "") . $_content . PHP_EOL;
		return $result;
	}
}
