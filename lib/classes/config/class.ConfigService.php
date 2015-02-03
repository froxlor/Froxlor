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
 * @author     Florian Aders <eleras@froxlor.org>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 * @since      0.9.34
 */


/**
 * Class ConfigService
 *
 * Parses a distributions XML - file and gives access to the services within
 * Not to be used directly
 *
 * @copyright  (c) the authors
 * @author     Florian Aders <eleras@froxlor.org>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 */
class ConfigService {
	private $daemons = array();
	
	private $fullxml;
	
	private $service;
	
	private $xpath;
	
	public $title;
	
	public function __construct($xml, $xpath) {
		$this->fullxml = $xml;
		$this->xpath = $xpath;
		$this->service = $this->fullxml->xpath($this->xpath);
		$attributes = $this->service[0]->attributes();
		if ($attributes['title'] != '') {
			$this->title = (string)$attributes['title'];
		}
		$this->parse();
	}

	private function parse() {
		$daemons = $this->fullxml->xpath($this->xpath . '/daemon');
		foreach ($daemons as $daemon) {
			if ($daemon->getName() == 'comment') {
				continue;
			}
			$name = '';
			$nametag = '';
			$versiontag = '';
			foreach($daemon->attributes() as $key => $value) {
				if ($key == 'name' && $name == '') {
					$name = (string)$value;
					$nametag = "[@name='" . $value . "']";
				} elseif ($key == 'name' && $name != '') {
					$name = (string)$value . '_' . $name;
					$nametag = "[@name='" . $value . "']";
				} elseif ($key == 'version' && $name == '') {
					$name = str_replace('.', '', $value);
					$versiontag = "[@version='" . $value . "']";
				} elseif ($key == 'version' && $name != '') {
					$name = $name . str_replace('.', '', $value);
					$versiontag = "[@version='" . $value . "']";
				}
			}
			if ($name == '') {
				throw new Exception ('No name attribute for daemon');
			}
			$this->daemons[$name] = new ConfigDaemon($this->fullxml, $this->xpath . "/daemon" . $nametag . $versiontag);
		}
	}
	
	public function getDaemons() {
		return $this->daemons;
	}
}