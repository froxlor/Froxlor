<?php

/**
 * Deploy File Creator Class
 *
 * This class creates the deploy file.
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
 * Class FroxlorDeployfileCreator
 * 
 * This class creates the deploy file.
 *
 * @category   FroxlorCore
 * @package    Classes
 * @subpackage System
 * @author     Froxlor Team <team@froxlor.org>
 * @copyright  2010 the authors
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @link       http://www.froxlor.org/
 */
class FroxlorDeployfileCreator
{
	/**
	 * Contains the file listing.
	 * 
	 * @var array
	 */
	public static $_list = null;
	
	/**
	 * Excluded dirs, seperated with | (for RegEx)
	 * 
	 * @var string
	 */
	public static $_exclude = "userdata.inc.php|navigation|configfiles";
	
	/**
	 * This function iterates through the $dir and generates the deploy list.
	 * 
	 * @param array $dir dir to deploy
	 * 
	 * @return array file listing
	 */
	public static function createList($dirList)
	{
		$list = array();
		
		foreach ($dirList as $dir) {
			if (is_dir($dir)) {
				$its = new RecursiveIteratorIterator(
					new RecursiveDirectoryIterator($dir)
				);
	
				foreach ($its as $fullFileName => $it ) {
					if (!preg_match("/(".self::$_exclude.")/i", $fullFileName)) {
						$list[] = $fullFileName;
					}
				}
				
			} else {
				throw new Exception($dir." is not a directory!");
			}
		}
		
		self::$_list = $list;
		
		return $list;
	}
	
	/**
	 * This function saves the deploy list to a file.
	 * 
	 * @param string $toPath file path
	 * @param array  $list   array list with all needed files
	 * 
	 * @return boolean
	 */
	public static function saveListTo($toPath, $list = null)
	{
		if (is_null($list)) {
			$list = self::$_list;
		}
		
		return file_put_contents($toPath, implode("\n", $list));
	}
}