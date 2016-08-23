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
 * 
 *
 * Class extends FroxlorEventConstants for syntatic suggar
 * 
 * Example:
 * FroxlorEvent::fire(FroxlorEvent::MyEvent);
 * FroxlorEvent::fire(FroxlorEvent::MyEvent, $data);
 * 
 * FroxlorEvent::MyEvent($data);
 * 
 */
class FroxlorEvent extends FroxlorEventConstants {
	/**
	 * @var FroxlorEventDispatcher 
	 */
	private static $dispatcher;
	
	public static function init() {
		self::$dispatcher = new FroxlorEventDispatcher();
		self::$dispatcher->registerEventsByClass('FroxlorEventConstants');
	}
	
	/**
	 * Fire an event with optional data
	 * 
	 * @param string $eventname The event name to call
	 * @param type $data (optional)
	 */
	public static function fire($eventname, $data = null) {
		self::$dispatcher->fire($eventname, $data);
	}
	
	public static function __callStatic($eventname, $arguments) {
		$argcount = count($arguments);
		switch ($argcount) {
			case 0:
				self::$dispatcher->fire($eventname);
				return;
			case 1:
				self::$dispatcher->fire($eventname, $arguments[0]);
				return;
		}
		throw new Exception("Firing event only with none or one argument allowed");		
	}
	
	/**
	 * Register a callback for event
	 * 
	 * @param string $eventname
	 * @param callable $callback Callback recieving event
	 */	
	public static function listen($eventname, $callback) {
		return self::$dispatcher->listen($eventname, $callback);
	}
}

