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
	public $ID;
	
	/**
	 * Version of plugin
	 * @var string
	 */
	public $version = '';
	
	/**
	 * Settings for this plugin
	 * @var FroxlorPluginSetting
	 */
	public $settings = null;
	

	/**
	 * Basic constructor filling ID and prepare setting
	 */
	public function __construct() {
		$this->ID = get_class($this);
		$this->settings = new FroxlorPluginSettings($this->ID);
		$this->_checkPlugin();
	}
	
	protected function _checkPlugin() {
		if (empty($this->version) || empty($this->name)) {
			throw new Exception('Plugin '.$this->ID.' needs valid version and name property!');
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
	 */
	public function install() {
		$this->settings->Set('version', $this->version);
	}
}
