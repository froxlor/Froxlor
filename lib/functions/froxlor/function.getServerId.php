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
 *
 */

/**
 * this function checks whether $server_id (multi-server) is set
 * in userdata.inc.php and returns the value. If not set or invalid,
 * always return the id of the master (which is '0')
 * 
 * @return int server_id of current server
 * @since 0.9.14-svn7
 */
function getServerId() {

	global $server_id, $theme;

	if(isset($server_id)
		&& is_numeric($server_id)
		&& $server_id > 0
	) {
		return $server_id;
	}
	// return default (master) 
	return 0;
}
