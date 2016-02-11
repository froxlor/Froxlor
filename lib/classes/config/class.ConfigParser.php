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
 * Class ConfigParser
 *
 * Parses a distributions XML - file and gives access to the configuration
 *
 * @copyright  (c) the authors
 * @author     Florian Aders <eleras@froxlor.org>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 */
class ConfigParser {
	/**
	 * Holding the available services in the XML
	 * @var array 
	 */
	private $services = array();

	/**
	 * Store the parsed SimpleXMLElement for usage
	 * @var SimpleXMLElement
	 */
	private $xml;

	/**
	 * Memorize if we already parsed the XML
	 * @var bool
	 */
	private $isparsed = false;

	/**
	 * Name of the distribution this configuration is for
	 * @var string
	 */
	public $distributionName = '';

	/**
	 * Codename of the distribution this configuration is for
	 * @var string
	 */
	public $distributionCodename = '';

	/**
	 * Version of the distribution this configuration is for
	 * @var string
	 */
	public $distributionVersion = '';

	/**
	 * Recommended editor
	 * @var string
	 */
	public $distributionEditor = '/bin/nano';

	/**
	 * Show if this configuration is deprecated
	 * @var bool
	 */
	public $deprecated = false;

	/**
	 * Constructor
	 * 
	 * Initialize the XML - ConfigParser
	 * @param string $filename filename of the froxlor - configurationfile
	 * @return void
	 */
	public function __construct($filename) {
		if (!is_readable($filename)) {
			throw new Exception('File not readable');
		}

		$this->xml = simplexml_load_file($filename);
		if ($this->xml === false) {
			$error = '';
			foreach(libxml_get_errors() as $error) {
				$error .= "\t" . $error->message;
			}
			throw new \Exception($error);
		}
		
		// Let's see if we can find a <distribution> block in the XML
		$distribution = $this->xml->xpath('//distribution');

		// No distribution found - can't use this file
		if (!is_array($distribution)) {
			throw new \Exception('Invalid XML, no distribution found');
		}

		// Search for attributes we understand
		foreach($distribution[0]->attributes() as $key => $value) {
			switch ((string)$key) {
				case "name": $this->distributionName = (string)$value; break;
				case "version": $this->distributionVersion = (string)$value; break;
				case "codename": $this->distributionCodename = (string)$value; break;
				case "defaulteditor": $this->distributionEditor = (string)$value; break;
				case "deprecated": (string)$value == 'true' ? $this->deprecated = true : $this->deprecated = false; break;
			}
		}
	}

	/**
	 * Parse the XML and populate $this->services
	 * @return bool
	 */
	private function _parse() {
		// We only want to parse the stuff one time
		if ($this->isparsed == true) {
			return true;
		}

		// Get all services
		$services = $this->xml->xpath('//services/service');
		foreach ($services as $service) {
			// We don't want comments
			if ($service->getName() == 'comment') {
				continue;
			}
			// Search the attributes for "type"
			foreach ($service->attributes() as $key => $value) {
				if ($key == 'type') {
					$this->services[(string)$value] = new ConfigService($this->xml, '//services/service[@type="' . (string)$value . '"]');
				}
			}
		}

		// Switch flag to indicate we parsed our data
		$this->isparsed = true;
		return true;
	}

	/**
	 * Return all services defined by the XML
	 * 
	 * The array will hold ConfigService - Objects for further handling
	 * @return array
	 */
	public function getServices() {
		// Let's parse this shit(!)
		$this->_parse();

		// Return our carefully searched for services
		return $this->services;
	}
}
