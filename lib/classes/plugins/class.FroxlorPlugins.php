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
	 * Active logger for plugins
	 * @var AbstractLogger 
	 */
	private $_logger = null;
	
	/**
	 * Current log action
	 * @var int USR_ACTION|RES_ACTION|ADM_ACTION|CRON_ACTION|LOGIN_ACTION|LOG_ERROR
	 *
	 */
	private $_logAction = LOG_ERROR;
	
	/**
	 * private constructor
	 */
	private function __construct() {
		$this->_plugins_dir = FROXLOR_INSTALL_DIR. '/plugins/';
		$this->_selectLogger();
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
					if (!file_exists($filename)) {
						// TODO: Tell admin plugin is missing?
						continue;
					}
					require $filename;
				}
				$plugin = new $pluginname();
				$this->_plugins[$plugin->getID()] = $plugin;
			}
		}
		FroxlorEvent::listen(FroxlorEvent::GetServiceConfiguration, array($this, 'event_GetServiceConfiguration'));
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
		$oldlogger = $this->_logger;
		$this->_logger = new LoggerTee(array($oldlogger));
		
		if ($extralogger) {
			$this->_logger->addLogger($extralogger);
		}
		
		foreach ($this->_plugins as $plugin) {
			if (!$plugin->hasUpdate()) {
				continue;
			}
			$this->_logger->logAction(ADM_ACTION, LOG_NOTICE, "Updateing {$plugin->name} to {$plugin->version}");
			if (!$plugin->install()) {
				$ret = false;
			}
		}
		$this->_logger = $oldlogger;
		return $ret;
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
	
	
	public function event_GetServiceConfiguration($eventdata) {
		if (!is_array($eventdata['distribution'])) {
			return;
		}
		$distribution = $eventdata['distribution'];
		if (empty($distribution['name'])) {
			return;
		}
		$dname = makeSecurePath(strtolower($distribution['name']));
		$dcodename = makeSecurePath(strtolower($distribution['codename']));
		foreach ($this->_plugins as $plugin) {
			$config_dir = $this->getPluginDir($plugin->getID()).'configfiles/';
			if (!empty($dcodename) && file_exists($config_dir.$dcodename.'.xml')) {
				$eventdata['files'][] = $config_dir.$dcodename.'.xml';
			} else if (file_exists($config_dir.$dname.'.xml')) {
				$eventdata['files'][] = $config_dir.$dname.'.xml';
			}
		}
	}
	
	/**
	 * Selects a logger and log action based on current environment
	 * MASTER_CRONJOB, AREA
	 * 
	 */
	private function _selectLogger() {
		global $log, $debugHandler;
		if (defined('MASTER_CRONJOB')) {
			$debugLogger = new FroxlorPluginsDebugLog($debugHandler);
			$this->_logger = new LoggerTee(array(
				$debugLogger, 
				FroxlorLogger::getInstanceOf(array('loginname' => 'cronjob'))
			));
			$this->_logAction = CRON_ACTION;
		} elseif (defined('AREA')) {
			$this->_logger = $log;
			$areatoaction = array(
				'admin' => ADM_ACTION,
				'customer' => USR_ACTION,
				'login' => LOGIN_ACTION,
			);
			if (array_key_exists(AREA, $areatoaction)) {
				$this->_logAction = $areatoaction[AREA];
			}
		} else {
			$this->_logger = FroxlorLogger::getInstanceOf(array('loginname' => 'plugins'));
		}
	}
	
	/**
	 * Routes a plugin message to the current logger
	 * 
	 * @param string $id Plugin ID
	 * @param int $type LOG_*
	 * @param string $message
	 */
	public static function logPluginMessage($id, $type, $message) {
		$obj = self::getInstance();
		$obj->_logger->logAction($obj->_logAction, $type, $id.': '.$message);
	}
}



/**
 * writes log messages to $debugHandler
 */
class FroxlorPluginsDebugLog {
	private $debugHandler;
	
	public function __construct($debugHandler) {
		$this->debugHandler = $debugHandler;
	}

	public function logAction ($action = USR_ACTION, $type = LOG_NOTICE, $text = null) {
		if ($text) {
			$prefix = '';
			switch($type)
			{
				case LOG_INFO:
					$prefix = '';
					break;
				case LOG_NOTICE:
					$prefix = '';
					break;
				case LOG_WARNING:
					$prefix = '[WARN] ';
					break;
				case LOG_ERR:
					$prefix = '[ERROR] ';
					break;
				case LOG_CRIT:
					$prefix = '[ERROR][CRITICAL] ';
					break;
				default:
					$prefix = '[??] ';
					break;
			}
			fwrite($this->debugHandler, $prefix.$text."\n");
		}
	}
}
