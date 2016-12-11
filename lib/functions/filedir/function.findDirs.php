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


/**
 * Returns an array of found directories
 *
 * This function checks every found directory if they match either $uid or $gid, if they do
 * the found directory is valid. It uses recursive-iterators to find subdirectories.
 *
 * @param string $path
 *        	the path to start searching in
 * @param int $uid
 *        	the uid which must match the found directories
 * @param int $gid
 *        	the gid which must match the found direcotries
 *
 * @return array Array of found valid paths
 */
function findDirs($path, $uid, $gid)
{
	$_fileList = array();
	$path = makeCorrectDir($path);

	// valid directory?
	if (is_dir($path)) {

		// Will exclude everything under these directories
		$exclude = array(
			'awstats',
			'webalizer'
		);

		/**
		 *
		 * @param SplFileInfo $file
		 * @param mixed $key
		 * @param RecursiveCallbackFilterIterator $iterator
		 * @return bool True if you need to recurse or if the item is acceptable
		 */
		$filter = function ($file, $key, $iterator) use ($exclude) {
			if (in_array($file->getFilename(), $exclude)) {
				return false;
			}
			return true;
		};

		// create RecursiveIteratorIterator
		$its = new RecursiveIteratorIterator(
			new RecursiveCallbackFilterIterator(
				new IgnorantRecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
				$filter
			)
		);
		// we can limit the recursion-depth, but will it be helpful or
		// will people start asking "why do I only see 2 subdirectories, i want to use /a/b/c"
		// let's keep this in mind and see whether it will be useful
		// @TODO
		// $its->setMaxDepth(2);

		// check every file
		foreach ($its as $fullFileName => $it) {
			if ($it->isDir() && (fileowner($fullFileName) == $uid || filegroup($fullFileName) == $gid)) {
				$_fileList[] = makeCorrectDir(dirname($fullFileName));
			}
		}
		$_fileList[] = $path;
	}

	return array_unique($_fileList);
}

/**
 * If you use RecursiveDirectoryIterator with RecursiveIteratorIterator and run
 * into UnexpectedValueException you may use this little hack to ignore those
 * directories, such as lost+found on linux.
 * (User "antennen" @ http://php.net/manual/en/class.recursivedirectoryiterator.php#101654)
 */
class IgnorantRecursiveDirectoryIterator extends RecursiveDirectoryIterator
{

	function getChildren()
	{
		try {
			return new IgnorantRecursiveDirectoryIterator($this->getPathname());
		} catch (UnexpectedValueException $e) {
			return new RecursiveArrayIterator(array());
		}
	}
}
