<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\Api\Commands;

use Exception;
use Froxlor\Api\ApiCommand;
use Froxlor\Api\ResourceEntity;
use Froxlor\Database\Database;
use Froxlor\FroxlorLogger;
use Froxlor\Idna\IdnaWrapper;
use Froxlor\Settings;
use Froxlor\System\Crypt;
use Froxlor\UI\Response;
use Froxlor\User;
use Froxlor\Validate\Validate;
use PDO;

/**
 * @since 2.1.0
 */
class Backups extends ApiCommand implements ResourceEntity
{
	/**
	 * lists all admin entries
	 *
	 * @param array $sql_search
	 *            optional array with index = fieldname, and value = array with 'op' => operator (one of <, > or =),
	 *            LIKE is used if left empty and 'value' => searchvalue
	 * @param int $sql_limit
	 *            optional specify number of results to be returned
	 * @param int $sql_offset
	 *            optional specify offset for resultset
	 * @param array $sql_orderby
	 *            optional array with index = fieldname and value = ASC|DESC to order the resultset by one or more
	 *            fields
	 *
	 * @access admin
	 * @return string json-encoded array count|list
	 * @throws Exception
	 */
	public function listing()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			$this->logger()->logAction(FroxlorLogger::ADM_ACTION, LOG_INFO, "[API] list backups");
			$query_fields = [];
			$result_stmt = Database::prepare("
				SELECT `b`.*, `a`.`loginname` as `adminname`
				FROM `" . TABLE_PANEL_BACKUPS . "` `b`
				LEFT JOIN `" . TABLE_PANEL_ADMINS . "` `a` USING(`adminid`)
			");
			Database::pexecute($result_stmt, $query_fields, true, true);
			$result = [];
			while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $this->response([
				'count' => count($result),
				'list' => $result
			]);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * returns the total number of backups for the given admin
	 *
	 * @access admin
	 * @return string json-encoded response message
	 * @throws Exception
	 */
	public function listingCount()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			$result_stmt = Database::prepare("
				SELECT COUNT(*) as num_backups
				FROM `" . TABLE_PANEL_BACKUPS . "`
			");
			$result = Database::pexecute_first($result_stmt, null, true, true);
			if ($result) {
				return $this->response($result['num_backups']);
			}
			$this->response(0);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * create a new admin user
	 *
	 * @param string $name
	 *
	 * @access admin
	 * @return string json-encoded array
	 * @throws Exception
	 */
	public function add()
	{
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * return an admin entry by either id or loginname
	 *
	 * @param int $id
	 *            optional, the admin-id
	 * @param string $loginname
	 *            optional, the loginname
	 *
	 * @access admin
	 * @return string json-encoded array
	 * @throws Exception
	 */
	public function get()
	{
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * update an admin user by given id or loginname
	 *
	 * @param int $id
	 * 			required, the admin-id
	 *
	 * @access admin
	 * @return string json-encoded array
	 * @throws Exception
	 */
	public function update()
	{
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * delete a admin entry by either id or loginname
	 *
	 * @param int $id
	 *            required, the admin-id
	 *
	 * @access admin
	 * @return string json-encoded array
	 * @throws Exception
	 */
	public function delete()
	{
		throw new Exception("Not allowed to execute given command.", 403);
	}
}
