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
	 * Path to file-include list.
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
	 * Constructor.
	 * 
	 * @param string $incListPath contains the path to include-configuration
	 * @param string $toPath      path where the package is saved
	 */
	public function __construct($incListPath, $toPath)
	{
		$this->_path = $incListPath;
		
		// load the config
		$this->_config = $this->_readConfig();
		
		// parse the config
		if (!$this->_checkConfig()) {
			die("Error in FroxlorPkgCreator::_checkConfig()");
		}
		
		$this->pack($toPath);
	}
	
	/**
	 * Loads the config to an array.
	 * 
	 * @return array pathes to files
	 */
	private function _readConfig()
	{
		$arr = array();
		
		if (is_readable($this->_path)) {
			$arr = file($this->_path);
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
			// TODO maybe more excluded files?
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
	 * This functions creates the package.
	 * 
	 * @param string $toPath the path where this file should be saved
	 * 
	 * @return string path
	 */
	public function pack($toPath)
	{
		$zip = new ZipArchive;
		
		// create archive
		if ($zip->open($toPath, ZIPARCHIVE::OVERWRITE)) {
			// write data
			foreach ($this->_config as $var) {
				$zip->addFile($var);
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