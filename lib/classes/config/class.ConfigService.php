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
	/**
	 * Holding the available daemons in this service
	 * @var array 
	 */
	private $daemons = array();

	/**
	 * Store the parsed SimpleXMLElement for usage
	 * @var SimpleXMLElement
	 */
	private $fullxml;

	/**
	 * Memorize if we already parsed the XML
	 * @var bool
	 */
	private $isparsed = false;

	/**
	 * xpath leading to this service in the full XML
	 * @var string
	 */
	private $xpath;

	/**
	 * Human - readable title of this service
	 * @var string
	 */
	public $title;

	public function __construct($xml, $xpath) {
		$this->fullxml = $xml;
		$this->xpath = $xpath;
		$service = $this->fullxml->xpath($this->xpath);
		$attributes = $service[0]->attributes();
		if ($attributes['title'] != '') {
			$this->title = (string)$attributes['title'];
		}
	}

	/**
	 * Parse the XML and populate $this->daemons
	 * @return bool
	 */
	private function _parse() {
		// We only want to parse the stuff one time
		if ($this->isparsed == true) {
			return true;
		}

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

		// Switch flag to indicate we parsed our data
		$this->isparsed = true;
		return true;
	}

	public function getDaemons() {
		$this->_parse();
		return $this->daemons;
	}
}
