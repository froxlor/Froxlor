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
			throw new Exception($error);
		}
		$this->parse();
	}
	
	/**
	 * Parse the XML and populate $this->services
	 * @return void
	 */
	private function parse() {
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
	}
	
	/**
	 * Return all services defined by the XML
	 * 
	 * The array will hold ConfigService - Objects for further handling
	 * @return array
	 */
	public function getServices() {
		return $this->services;
	}
}