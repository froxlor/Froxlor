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
 * Class ConfigDaemon
 *
 * Parses a distributions XML - file and gives access to the configuration
 * Not to be used directly
 *
 * @copyright  (c) the authors
 * @author     Florian Aders <eleras@froxlor.org>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 */
class ConfigDaemon {
	/**
	 * Holding the commands for this daemon
	 * @var array
	 */
	private $orders = array();

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
	 * Sub - area of the full - XML only holding the daemon - data we are interessted in
	 * @var SimpleXMLElement
	 */
	private $daemon;

	/**
	 * xpath leading to this daemon in the full XML
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
		$this->daemon = $this->fullxml->xpath($this->xpath);
		$attributes = $this->daemon[0]->attributes();
		if ($attributes['title'] != '') {
			$this->title = $this->_parseContent((string)$attributes['title']);
		}
	}

	/**
	 * Parse the XML and populate $this->orders
	 * @return bool
	 */
	private function _parse() {
		// We only want to parse the stuff one time
		if ($this->isparsed == true) {
			return true;
		}

		$preparsed = array();
		// First: let's push everything into an array and expand all includes
		foreach ($this->daemon[0]->children() as $order) {
			switch((string)$order->getName()) {
				case "install":
				case "file":
				case "command":
					// Normal stuff, just add it to the preparsed - array
					$preparsed[] = $order; break;
				case "include":
					// Includes, get the part we want via xpath
					$includes = $this->fullxml->xpath((string)$order);
					foreach ($includes[0] as $include) {
						// The "include" is also a child, so just skip it, would make a mess later
						if ((string)$include->getName() == 'include') {
							continue;
						}
						$preparsed[] = $include;
					}
					break;
				default: continue;
			}
		}

		// Go through every preparsed order and evaluate what should happen to it
		foreach ($preparsed as $order) {
			$parsedorder = $this->_parseOrder($order);
			// We got an array (= valid order) and the array already has a type -> add to stack
			if (is_array($parsedorder) && array_key_exists('type', $parsedorder)) {
				$this->orders[] = $parsedorder;
			// We got an array, but no type, means we got multiple orders back, at them to the stack one at a time
			} elseif (is_array($parsedorder)) {
				foreach($parsedorder as $neworder) {
					$this->orders[] = $neworder;
				}
			}
		}

		// Switch flag to indicate we parsed our data
		$this->isparsed = true;
		return true;
	}

	/**
	 * Get config for this daemon
	 *
	 * The returned array will be an array of array, each sub-array looking like this:
	 * array('type' => 'install|file|command', 'content' => '<TEXT>')
	 * If the type is "file", an additional "name" - element will be added to the array
	 * To configure a daemon, the steps in the array must be followed in order
	 *
	 * @return array
	 */
	public function getConfig() {
		$this->_parse();
		return $this->orders;
	}

	/**
	 * Parse a single order and return it in a format for easier usage
	 *
	 * @param SimpleXMLElement object holding a single order from the distribution - XML
	 * @return array|string
	 */
	private function _parseOrder($order) {
		$attributes = array();
		foreach($order->attributes() as $key => $value) {
			$attributes[(string)$key] = (string)$value;
		}

		$parsedorder = '';
		switch((string)$order->getName()) {
			case "file": $parsedorder = $this->_parseFile($order, $attributes); break;
			case "command": $parsedorder = $this->_parseCommand($order, $attributes); break;
			case "install": $parsedorder = $this->_parseInstall($order, $attributes); break;
			default: throw new \Exception('Invalid order: ' . (string)$order->getName());
		}

		return $parsedorder;
	}

	/**
	 * Parse a install - order and return it in a format for easier usage
	 *
	 * @param SimpleXMLElement object holding a single install from the distribution - XML
	 * @return array|string
	 */
	private function _parseInstall($order, $attributes) {
		// No sub - elements, so the content can be returned directly
		if ($order->count() == 0) {
			return array('type' => 'install', 'content' => $this->_parseContent((string)$order));
		}

		// Hold the results
		$visibility = 1;
		$content = '';
		foreach($order->children() as $child) {
			switch((string)$child->getName()) {
				case "visibility": $visibility += $this->_checkVisibility($child); break;
				case "content": $content = (string)$child; break;
			}
		}

		if ($visibility > 0) {
			return array('type' => 'install', 'content' => $this->_parseContent($content));
		} else {
			return '';
		}
	}

	/**
	 * Parse a command - order and return it in a format for easier usage
	 *
	 * @param SimpleXMLElement object holding a single command from the distribution - XML
	 * @return array|string
	 */
	private function _parseCommand($order, $attributes) {
		// No sub - elements, so the content can be returned directly
		if ($order->count() == 0) {
			return array('type' => 'command', 'content' => $this->_parseContent((string)$order));
		}

		// Hold the results
		$visibility = 1;
		$content = '';
		foreach($order->children() as $child) {
			switch((string)$child->getName()) {
				case "visibility": $visibility += $this->_checkVisibility($child); break;
				case "content": $content = (string)$child; break;
			}
		}

		if ($visibility > 0) {
			return array('type' => 'command', 'content' => $this->_parseContent($content));
		} else {
			return '';
		}
	}

	/**
	 * Parse a file - order and return it in a format for easier usage
	 *
	 * @param SimpleXMLElement object holding a single file from the distribution - XML
	 * @return array|string
	 */
	private function _parseFile($order, $attributes) {
		$visibility = 1;
		// No sub - elements, so the content can be returned directly
		if ($order->count() == 0) {
			$content = (string)$order;
		} else {
			// Hold the results
			foreach($order->children() as $child) {
				switch((string)$child->getName()) {
					case "visibility": $visibility += $this->_checkVisibility($child); break;
					case "content": $content = (string)$child; break;
				}
			}
		}

		$return = array();
		// Check if the original file should be backupped
		// @TODO: Maybe have a backup - space somewhere?
		// @TODO: Use IO - class
		if (array_key_exists('backup', $attributes)) {
			$return[] = array('type' => 'command', 'content' => 'mv "' . $this->_parseContent($attributes['name']) . '" "' . $this->_parseContent($attributes['name']) . '.frx.bak"');
		}

		// Now the content of the file can be written
		if (isset($attributes['mode'])) {
			$return[] = array('type' => 'file', 'content' => $this->_parseContent($content), 'name' => $this->_parseContent($attributes['name']), 'mode' => $this->_parseContent($attributes['mode']));
		} else {
			$return[] = array('type' => 'file', 'content' => $this->_parseContent($content), 'name' => $this->_parseContent($attributes['name']));
		}

		// Let's check if the mode of the file should be changed
		if (array_key_exists('chmod', $attributes)) {
			$return[] = array('type' => 'command', 'content' => 'chmod ' . $attributes['chmod'] . ' "' . $this->_parseContent($attributes['name']) . '"');
		}

		// Let's check if the owner of the file should be changed
		if (array_key_exists('chown', $attributes)) {
			$return[] = array('type' => 'command', 'content' => 'chown ' . $attributes['chown'] . ' "' . $this->_parseContent($attributes['name']) . '"');
		}

		if ($visibility > 0) {
			return $return;
		} else {
			return '';
		}
	}

	/**
	 * Replace placeholders with content
	 * @param string $content
	 * @return string $content w/o placeholder
	 */
	private function _parseContent($content) {
		$content = preg_replace_callback('/\{\{(.*)\}\}/Ui', function ($matches) {
			if (preg_match('/^settings\.(.*)$/', $matches[1], $match)) {
				return Settings::Get($match[1]);
			} elseif (preg_match('/^lng\.(.*)(?:\.(.*)(?:\.(.*)))$/U', $matches[1], $match)) {
				global $lng;
				if (isset($match[1]) && $match[1] != '' && isset($match[2]) && $match[2] != '' && isset($match[3]) && $match[3] != '') {
					return $lng[$match[1]][$match[2]][$match[3]];
				} elseif (isset($match[1]) && $match[1] != '' && isset($match[2]) && $match[2] != '') {
					return $lng[$match[1]][$match[2]];
				} elseif (isset($match[1]) && $match[1] != '') {
					return $lng[$match[1]];
				}
				return '';
			}
		}, $content);
		return $content;
	}

	/**
	 * Check if visibility should be changed
	 * @param SimpleXMLElement $order
	 * @return int 0|-1
	 */
	private function _checkVisibility($order) {
		$attributes = array();
		foreach($order->attributes() as $key => $value) {
			$attributes[(string)$key] = $this->_parseContent((string)$value);
		}

		$order = $this->_parseContent((string)$order);
		if (!array_key_exists('mode', $attributes)) {
			throw new \Exception('"<visibility>' . $order . '</visibility>" is missing mode');
		}

		switch ($attributes['mode']) {
			case "isfile": if (!is_file($order)) { return -1; }; break;
			case "isdir": if (!is_dir($order)) { return -1; }; break;
			case "isdir": if (!is_dir($order)) { return -1; }; break;
			case "false": if ($order == true) { return -1; }; break;
			case "true": if ($order == false) { return -1; }; break;
			case "notempty": if ($order == "") { return -1; }; break;
			case "userexists": if (true) { return 0; }; break;
			case "groupexists": if (true) { return 0; }; break;
		}
		return 0;
	}
}
