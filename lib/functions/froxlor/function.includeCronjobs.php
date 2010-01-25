<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id: $
 */

function includeCronjobs($path, $debugHandler)
{
	$cronbasedir = makeCorrectDir($path);
	$crondir = new DirectoryIterator($cronbasedir);

	foreach($crondir as $file)
	{
		if($file->isDot()) continue;

		if($file->isFile())
		{
			if(fileowner(__FILE__) == $file->getOwner()
			&& filegroup(__FILE__) == $file->getGroup()
			&& $file->isReadable())
			{
				fwrite($debugHandler, 'Including ...' . $file->getPathname() . "\n");
				include_once($file->getPathname());
			}
			else
			{
				fwrite($debugHandler, 'WARNING! uid and/or gid of "' . __FILE__ . '" and "' . $file->getPathname() . '" don\'t match! Execution aborted!' . "\n");
				fclose($debugHandler);
				die('WARNING! uid and/or gid of "' . __FILE__ . '" and "' . $file->getPathname() . '" don\'t match! Execution aborted!');
			}
		}
	}
}
