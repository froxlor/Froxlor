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

define('FROXLOR_PLUGINS_DIR', FROXLOR_INSTALL_DIR. '/plugins/');

class FroxlorPlugins {
	/**
	 * current plugins object
	 *
	 * @var FroxlorPlugins
	 */
	private static $_obj = null;

	/**
	 * All loaded plugins
	 * @var FroxlorPlugin[]
	 */
	private $_plugins = array();
	
	
	/**
	 * All active plugin names
	 * @var string[]
	 */
	private $_plugins_active = array();

	/**
	 * private constructor
	 */
	private function __construct() {
		$path = FROXLOR_PLUGINS_DIR;
		$activated = trim((string)Settings::Get('plugins.active'));
		if ($activated != '') {
			$this->_plugins_active = array_map('trim', explode(',', $activated));
			
			foreach($this->_plugins_active as $pluginname) {
				if (!class_exists($pluginname, false)) {
					$filename = "$path/$pluginname/$pluginname.php";
					require $filename;
				}
				$plugin = new $pluginname();
				$this->_plugins[$plugin->ID] = $plugin;
			}
		}
	}
	
	/**
	 * Return all loaded plugins
	 * 
	 * @return FroxlorPlugin[]
	 */
	public function getPlugins() {
		return $this->_plugins;
	}
	
	/**
	 * Return a loaded plugin by id
	 * 
	 * @param string $id ID
	 * @return FroxlorPlugin
	 */
	public function getPlugin($id) {
		return $this->_plugins[$id];
	}
	
	/**
	 * Check if any active plugin has updates
	 * 
	 * @return boolean
	 */
	public function hasUpdates() {
		foreach ($this->_plugins as $plugin) {
			if ($plugin->hasUpdate()) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * return instance of singleton
	 *
	 * @return FroxlorPlugins
	 */
	public static function getInstance() {
		// do we got an object already?
		if (self::$_obj == null) {
			self::$_obj = new self();
		}
		// return it
		return self::$_obj;
	}	
	
	/** 
	 * The ui needs an option list for displaying, should't be here
	 * 
	 * @return array
	 */
	public static function getOptionList() {
		$obj = self::getInstance();
		$options = array();
		$pluginlist = $obj->getAvailablePlugins();
		foreach ($pluginlist as $pluginid => $plugindesc) {
			$options[$pluginid] = $plugindesc['name'] . ' - '.$plugindesc['version'];
		}
		return $options;
	}
	
	/**
	 * Return a list of available plugins 
	 * 
	 * @return array
	 */
	public function getAvailablePlugins() {
		$plugins = array();
		
		$path = FROXLOR_PLUGINS_DIR;
		
		if (!is_dir($path)) {
			return $plugins;
		}
		
		$its = new DirectoryIterator($path);

		foreach ($its as $it) {
			if ($it->isDir() && !$it->isDot()) {
				$id = $it->getBasename();
				if (file_exists("$path/$id/$id.php")) {
					$plugins[$id] = $this->_inspecPlugin($id);
				}
			}
		}
		return $plugins;

	}
	
	protected function _inspecPlugin($id) {
		$path = FROXLOR_PLUGINS_DIR;
		if (!class_exists($id, false)) {
			$filename = "$path/$id/$id.php";
			require_once $filename;
		}
		
		$pluginRefClass = new ReflectionClass($id);
		$props = $pluginRefClass->getDefaultProperties();	
		
		$plugin = array(
			'id' => $id,
			'name' => isset($props['name']) ? $props['name'] : $id, 
			'version' => isset($props['version']) ? $props['version'] : '?'
		);
		return $plugin;
	}
}
