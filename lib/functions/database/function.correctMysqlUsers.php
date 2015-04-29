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
 * loop over all mysql databases and create/delete users according to $access_hosts.
 *
 * This function is called when system.mysql_access_hosts or system.ipaddress is changed
 *
 * @param array $access_hosts list of hosts from which mysql access should be allowed
 */
function correctMysqlUsers($access_hosts) {

	global $log;
	Database::needRoot(false);
	$databases_stmt = Database::query("SELECT * FROM `".TABLE_PANEL_DATABASES."` ORDER BY `dbserver`");
	$current_server = -1;
	$flush_privileges = false;
	$dbm = null;

	while ($dbdata = $databases_stmt->fetch(PDO::FETCH_ASSOC)) {

		// next server?
		if ($current_server != $dbdata['dbserver']) {
			// flush privileges if necessary
			if ($flush_privileges) {
				$dbm->getManager()->flushPrivileges();
			}
			// connect to the server which hosts this database
			Database::needRoot(true, $dbdata['dbserver'], true);
			$dbm = new DbManager($log);
		}

		// get the list of users belonging to this database
		$users = $dbm->getManager()->getAllSqlUsers(false, $dbdata['databasename']);

		// compare required access hosts with actual data
		foreach ($users as $username=>$data) {
			$hosts_to_create = $access_hosts;
			foreach($data['hosts'] as $host) {
				if (($key = array_search($host, $hosts_to_create))!== false) {
					// host is already in access_hosts, no need to create
					unset($hosts_to_create[$key]);
				} else {
					// host not in access_hosts, remove it
					$dbm->getManager()->deleteUser($username, $host);
					$flush_privileges = true;
				}
			}
			// create missing host permissions
			foreach($hosts_to_create as $host) {
				$dbm->getManager()->grantPrivilegesTo($username, $data['password'], $host, true);
			}
		}
	}
	if ($flush_privileges) {
		$dbm->getManager()->flushPrivileges();
	}
	Database::needRoot(false);
}
