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
	 * Directory with loadable plugins 
	 * @var string
	 */
	private $_plugins_dir = '';
	
	/**
	 * private constructor
	 */
	private function __construct() {
		$this->_plugins_dir = FROXLOR_INSTALL_DIR. '/plugins/';
	}
	
	public static function init() {
		$obj = self::getInstance();
		$obj->loadPlugins();
	}
	
	public function loadPlugins() {
		$activated = trim((string)Settings::Get('plugins.active'));
		if ($activated != '') {
			$this->_plugins_active = array_map('trim', explode(',', $activated));
			
			foreach($this->_plugins_active as $pluginname) {
				if (!class_exists($pluginname, false)) {
					$filename = $this->_plugins_dir."$pluginname/$pluginname.php";
					require $filename;
				}
				$plugin = new $pluginname();
				$this->_plugins[$plugin->getID()] = $plugin;
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
	 * Return plugin directory
	 * 
	 * @param string $id ID
	 * @return string
	 */
	public function getPluginDir($id) {
		$path = $this->_plugins_dir.$id.'/';
		return $path;
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
	 * Perfom any pending install updates
	 * 
	 * @param object $extralogger (optional) 
	 * @return boolean
	 */
	public function installUpdates($extralogger = null) {
		$ret = true;
	
		$allloggers = array();
		$allloggers[] = FroxlorLogger::getInstanceOf(array('loginname' => 'plugininstaller'));
		if ($extralogger) {
			$allloggers[] = $extralogger;
		}
		$logger = new LoggerTee($allloggers);
		
		foreach ($this->_plugins as $plugin) {
			if (!$plugin->hasUpdate()) {
				continue;
			}
			$logger->logAction(ADM_ACTION, LOG_NOTICE, "Updateing {$plugin->name} to {$plugin->version}");
			$logger->setPreText($plugin->name.': ');
			if (!$plugin->install($logger)) {
				$ret = false;
			}
		}
		return true;
	}
	
	/**
	 * return instance of singleton
	 *
	 * @return FroxlorPlugins
	 */
	public static function getInstance() {
		static $instances = 0;
		if (self::$_obj == null) {
			if ($instances > 0) {
				throw new Exception('Circular reference while construction detected');
			}
			$instances++;
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
		
		if (!is_dir($this->_plugins_dir)) {
			return $plugins;
		}
		
		$its = new DirectoryIterator($this->_plugins_dir);

		foreach ($its as $it) {
			if ($it->isDir() && !$it->isDot()) {
				$id = $it->getBasename();
				if (file_exists($this->_plugins_dir."$id/$id.php")) {
					$plugins[$id] = $this->_inspecPlugin($id);
				}
			}
		}
		return $plugins;

	}
	
	protected function _inspecPlugin($id) {
		if (!class_exists($id, false)) {
			$filename = $this->_plugins_dir."$id/$id.php";
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
