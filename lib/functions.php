<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

$libdirname = dirname(__FILE__);

includeFunctions($libdirname . '/functions/');

function includeFunctions($dirname)
{
	$dirhandle = opendir($dirname);
	while(false !== ($filename = readdir($dirhandle)))
	{
		if($filename != '.' && $filename != '..' && $filename != '')
		{
			if((substr($filename, 0, 9) == 'function.' || substr($filename, 0, 9) == 'constant.') && substr($filename, -4 ) == '.php')
			{
				include($dirname . $filename);
			}

			if(is_dir($dirname . $filename))
			{
				includeFunctions($dirname . $filename . '/');
			}
		}
	}
	closedir($dirhandle);
}

Autoloader::init();

/**
 * Class Autoloader
 *
 * iterates through given directory and includes
 * the file which matches $classname
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2013-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Autoloader
 * @since      0.9.29.1
 */
class Autoloader {

	/**
	 * returns a new AutoLoader-object
	 * @return Autoloader
	 */
	public static function init() {
		return new self();
	}

	/**
	 * class constructor
	 *
	 * @return null
	 */
	public function __construct() {
		// register autoload.function
		spl_autoload_register(array($this, 'doAutoload'));
	}

	/**
	 * gets the class to load as parameter, searches the library-paths
	 * recursively for this class and includes it
	 *
	 * @param string $class
	 *
	 * @throws Exception
	 * @return boolean
	 */
	public function doAutoload($class) {

		// define the paths where to look for classes
		$paths = array(
				dirname(__FILE__) . '/',
				dirname(dirname(__FILE__)) . '/scripts/',
				dirname(dirname(__FILE__)) . '/install/',
		);

		if (substr($class, 0, 15) == "Mso\IdnaConvert") {
			$class = substr($class, 16);
			include_once __DIR__.'/classes/idna/ext/'.$class.'.php';
			return true;
		}

		// don't load anything from a namespace, it's not our responsibility
		if (strpos($class, "\\") !== false) {
			return true;
		}

		// now iterate through the paths
		foreach ($paths as $path) {
			// valid directory?
			if (is_dir($path)) {
				// create RecursiveIteratorIterator
				$its = new RecursiveIteratorIterator(
						new RecursiveDirectoryIterator($path)
				);

				// check every file
				foreach ($its as $fullFileName => $it ) {
					// does it match the Filename pattern?
					if (preg_match("/^(class|module|interface|abstract|)\.?$class\.php$/i", $it->getFilename())) {
						// include the file and return from the loop
						include_once $fullFileName;
						return true;
					}
				}
			} else {
				// yikes - no valid directory to check
				throw new Exception("Cannot autoload from directory '".$path."'. No such directory.");
			}
		}
		// yikes - class not found
		throw new Exception("Could not find class '".$class."'");
	}
}
