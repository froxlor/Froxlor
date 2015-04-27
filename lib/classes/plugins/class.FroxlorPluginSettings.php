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

class FroxlorPluginSettings {
	private $pluginid;
	public function __construct($id) {
		$this->pluginid = $id;
	}
	/**
	 * 
	 * @param string $name name of setting
	 * @return string|null
	 */
	public function Get($name) {
		$fullname = $this->pluginid.'.'.$name;
		return Settings::Get($fullname);
	}
	
	/**
	 * update a setting / set a new value for plugin
	 *
	 * @param string $name
	 * @param string $value
	 * 
	 * @return bool
	 */
	public function Set($name, $value) {
		$fullname = $this->pluginid.'.'.$name;
		return Settings::Set($fullname, $value);
	}
	
	/**
	 * create a new setting for plugin
	 * 
	 * @param type $name
	 * @param type $value
	 * @return bool
	 */
	public function AddNew($name, $value) {
		$fullname = $this->pluginid.'.'.$name;
		return Settings::AddNew($fullname, $value);
	}
}