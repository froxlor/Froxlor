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

abstract class FroxlorPlugin {
	protected $ID;

	/**
	 * Plugin name
	 * @var string
	 */
	public $name = '';
	
	/**
	 * Version of plugin
	 * @var string
	 */
	public $version = '';
	
	/**
	 * Settings for this plugin
	 * @var FroxlorPluginSettings
	 */
	protected $settings = null;
	
	/**
	 * text service
	 * @var FroxlorPluginText
	 */
	protected $text = null;


	/**
	 * template service
	 * @var FroxlorPluginTemplate
	 */
	protected $tpl = null;
	
	/**
	 * plugin logger service
	 * @var FroxlorPluginLog 
	 */
	protected $logger = null;
	
	/**
	 * Basic constructor filling ID and prepare setting
	 */
	public function __construct() {
		$this->ID = get_class($this);
		$this->settings = new FroxlorPluginSettings($this->ID);
		$this->_checkPlugin();
		
		$this->logger = new FroxlorPluginLog($this->ID);
		
		$textService = new FroxlorPluginText($this->ID);
		$this->text = $textService;
		
		$_eventLoadLanguage = function ($eventData) use ($textService) {
			$textService->loadLang($eventData['language']);
		};
		FroxlorEvent::listen(FroxlorEvent::LoadLanguage, $_eventLoadLanguage);
		
		$this->tpl = new FroxlorPluginTemplate($this->ID);	
		$this->_register_events();
	}

	/**
	 * Get the Plugin ID
	 * @return string 
	 */
	public function getID() {
		return $this->ID;
	}

	/**
	 * Check if this Plugin is well-formed
	 * @throws Exception
	 */
	protected function _checkPlugin() {
		if (empty($this->version) || empty($this->name)) {
			throw new Exception('Plugin '.$this->ID.' needs valid version and name property!');
		}
	}

	/**
	 * Register all event* Methods as event listener
	 */
	protected function _register_events() {
		if (!$this->hasUpdate()) {
			$methods = get_class_methods($this);
			foreach ($methods as $method) {
				if (strpos($method, 'event') === 0) {
					$eventname = substr($method, 5);
					FroxlorEvent::listen($eventname, array($this, $method));
				}
			}
		}
	}

	/**
	 * Return true if this plugin needs to be installed/updated
	 * @return boolean
	 */
	public function hasUpdate() {
		if (empty($this->ID)) {
			throw new Exception('Plugin '.  get_class($this).' misses call to parent::__construct()!');
		}
		// If pluginid.version doesn't exits in database, 
		// add it so install function is simpler (no need for addNew check)
		if ($this->settings->Get('version') === null) {
			$this->settings->AddNew('version', ''); 
		}
		if ($this->settings->Get('version') != $this->version) {
			return true;
		}
		return false;
	}
	
	/**
	 * Called when installing/updating seems necessary
	 * @return boolean
	 */
	public function install() {
		$this->settings->Set('version', $this->version);
		return true;
	}

	/**
	 * Logs a plugin message
	 * 
	 * @param int $type LOG_*
	 * @param string $message
	 */
	public function log($type = LOG_NOTICE, $message = null) {
		FroxlorPlugins::logPluginMessage($this->ID, $type, $message);
	}
}
