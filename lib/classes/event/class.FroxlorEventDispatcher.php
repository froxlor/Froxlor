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
 *
 */

/**
 * Event dispatcher responsible to holding all references
 *
 * @author oskar
 */
class FroxlorEventDispatcher {
	protected $events = array();
	protected $validevents = array();
	protected $deprecatedevents = array();
	
	public function __construct() {
		
	}
	
	public function fire($name, $data = null) {
		if (!isset($this->events[$name])) {
			return;
		}
		
		$listeners = $this->events[$name];
		
		if (is_null($data)) {
			foreach ($listeners as $listener) {
				call_user_func($listener);
			}
		} else {
			foreach ($listeners as $listener) {
				call_user_func($listener, $data);
			}
		}
	}
	
	
	public function listen($name, $callback) {
		if (!is_callable($callback)) {
			throw new Exception("Invalid callback for $name");
		}
		if (!isset($this->validevents[$name])) {
			return false;
		}
		$this->events[$name][] = $callback;
		return isset($this->deprecatedevents[$name]) ? 'deprecated' : true;
	}
	
	public function remove($name, $callback) {
		$key = array_search($callback, $this->events[$name]);
		if ($key === false) {
			return false;
		}
		array_splice($this->events[$name], $key, 1);
		return true;
	}
	
	/**
	 * Register events with a class full of constants of valid event names
	 * @param string $classname
	 */
	public function registerEventsByClass($classname) {
		$ref_Events = new ReflectionClass($classname);
		$ref_EventsDeprecated = $ref_Events->getParentClass();
		if ($ref_EventsDeprecated) {
			// Array union, won't overwrite older keys...
			if (strpos($ref_EventsDeprecated->getName(), 'Deprecated') !== false) {
				$this->deprecatedevents += $ref_EventsDeprecated->getConstants();
			}
		}
		$this->validevents += $ref_Events->getConstants();
	}
}
