<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2015 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Oskar Eisemuth
 * @author     Froxlor team <team@froxlor.org> (2015-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 */

class FroxlorPluginText implements ArrayAccess {
	private $pluginid;
	/**
	 * The language file directory
	 * @var string
	 */
	private $langdir;
	public function __construct($id) {
		$this->pluginid = $id;
		$plugins = FroxlorPlugins::getInstance();
		$this->langdir = $plugins->getPluginDir($this->pluginid).'lng/';
	}
	/**
	 * Load a language file by language name
	 * @param string $language
	 */
	public function loadLang($language) {
		// Intentional not global scope here, plugin namespace added later
		$lng = array();
		$en = $this->langdir.'english.lng.php';
		if (file_exists($en)) {
			include $en;
		}
		$langfile = $this->langdir.$language.'.lng.php';
		if (file_exists($langfile)) {
			include $langfile;
		}
		$this->applyLangData($lng);
	}
	
	protected function applyLangData($data) {
		global $lng;
		$lng[$this->pluginid] = $data;
	}
	
	public function getText($textid) {
		global $lng;
		if (isset($lng[$textid])) {
			return $lng[$textid];
		}
		$segments = explode('.', $textid);
		array_unshift($segments, $this->pluginid);
		
		$ptr = $lng;
		foreach ($segments as $segment) {
			if (!is_array($ptr) || !array_key_exists($segment, $ptr)) {
				return 'TXT('.$this->pluginid.'.'.$textid.')';
			}
			$ptr = $ptr[$segment];
		}
		return $ptr;
	}

	public function offsetExists($offset) {
		global $lng;
		return array_key_exists($offset, $lng[$this->pluginid]);
	}

	public function offsetGet($offset) {
		global $lng;
		return $lng[$this->pluginid][$offset];
	}

	public function offsetSet($offset, $value) {
		throw new Exception("Setting language string '$offset' not allowed");
	}

	public function offsetUnset($offset) {
		throw new Exception("Unsetting language string '$offset' not allowed");
	}

}
