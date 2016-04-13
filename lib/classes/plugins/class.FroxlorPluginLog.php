<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Oskar Eisemuth
 * @author     Froxlor team <team@froxlor.org> (2016-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 */

class FroxlorPluginLog {
	protected $pluginid;
	public function __construct($id) {
		$this->pluginid = $id;
	}
	
	/**
	 * Log message (with pluginid)
	 * @param int $type
	 * @param string $message
	 */
	public function log($type, $message) {
		FroxlorPlugins::logPluginMessage($this->pluginid, $type, $message);
	}
	
	/**
	 * Adapter function for non plugin code
	 * @param string $action (unused)
	 * @param int $type
	 * @param string $message
	 */
	public function logAction($action, $type = LOG_NOTICE, $message = null) {
		FroxlorPlugins::logPluginMessage($this->pluginid, $type, $message);
	}
}
