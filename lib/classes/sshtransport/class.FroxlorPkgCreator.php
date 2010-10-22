<?php

/**
 * Package Creator Class
 *
 * This class creates packages to send over ssh.
 *
 * PHP version 5
 *
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @category   FroxlorCore
 * @package    Classes
 * @subpackage System
 * @author     Froxlor Team <team@froxlor.org>
 * @copyright  2010 the authors
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @version    SVN: $Id$
 * @link       http://www.froxlor.org/
 */

/**
 * Class FroxlorPkgCreator
 * 
 * This class creates packages to send over ssh.
 *
 * @category   FroxlorCore
 * @package    Classes
 * @subpackage System
 * @author     Froxlor Team <team@froxlor.org>
 * @copyright  2010 the authors
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @link       http://www.froxlor.org/
 */
class FroxlorPkgCreator
{
	/**
	 * Path to save file.
	 * 
	 * @var string
	 */
	private $_path = null;
	
	/**
	 * Contains the file-list as an array.
	 * 
	 * @var array
	 */
	private $_config = array();
	
	/**
	 * Manual added files. 
	 * Contains an array with an array (name, data);
	 * 
	 * @var array
	 */
	private $_manualFiles = array();
	
	/**
	 * Constructor.
	 * 
	 * @param string $incListPath contains the path to include-configuration
	 * @param string $toPath      path where the package is saved
	 */
	public function __construct($incListPath, $toPath)
	{
		$this->_path = $toPath;
		
		// load the config
		$this->_config = $this->_readConfig($incListPath);
		
		// parse the config
		if (!$this->_checkConfig()) {
			throw new Exception("Error in FroxlorPkgCreator::_checkConfig()");
		}
	}
	
	/**
	 * Loads the config to an array.
	 * 
	 * @param string $path path to inc-list
	 * 
	 * @return array pathes to files
	 */
	private function _readConfig($path)
	{
		$arr = array();
		
		if (is_readable($path)) {
			$arr = file($path);
		}
		
		return $arr;
	}
	
	/**
	 * This function checks the files for readability and prohibted files.
	 * 
	 * @return boolean check result
	 */
	private function _checkConfig()
	{
		foreach ($this->_config as $key => $var) {
			if (strstr($var, "userdata.inc")) {
				// delete this entry
				unset($this->_config[$key]);
			} else {
				$this->_config[$key] = trim($var);
			}
		}
		
		// no items, can't pack them
		if (count($this->_config) == 0) {
			return false;
		}
		
		// everything checked
		return true;
	}
	
	/**
	 * Adds a "file".
	 * 
	 * @param string $name filename (containg path like lib/userdata.inc.php)
	 * @param string $data data to write
	 */
	public function addFile($name, $data)
	{
		$this->_manualFiles[] = array(
			'name' => $name, 
			'data' => $data
		);
	}
	
	/**
	 * This functions creates the package.
	 * 
	 * @param string $toPath the path where this file should be saved
	 * 
	 * @return string path
	 */
	public function pack()
	{
		$toPath = $this->_path;
		
		$zip = new ZipArchive;
		
		// create archive
		if ($zip->open($toPath, ZIPARCHIVE::OVERWRITE)) {
			// write data
			foreach ($this->_config as $var) {
				$name = str_replace("froxlor/", "", strstr($var, "froxlor/"));
				$zip->addFile($var, $name);
			}
			
			// add manual files
			foreach ($this->_manualFiles as $var) {
				$zip->addFromString($var['name'], $var['data']);
			}
			
			// close it
			$zip->close();
			
			return true;
		}
		
		// return
		return false;
	}
}
?>