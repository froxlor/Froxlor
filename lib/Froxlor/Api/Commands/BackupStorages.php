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
use Froxlor\FileDir;
use Froxlor\FroxlorLogger;
use Froxlor\UI\Response;
use Froxlor\Validate\Validate;
use PDO;

/**
 * @since 2.1.0
 */
class BackupStorages extends ApiCommand implements ResourceEntity
{
	/**
	 * lists all backup storages entries
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
			$this->logger()->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, "[API] list backups");
			$query_fields = [];
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_BACKUP_STORAGES . "`
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
	 * returns the total number of backup storages
	 *
	 * @access admin
	 * @return string json-encoded response message
	 * @throws Exception
	 */
	public function listingCount()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			$result_stmt = Database::prepare("
				SELECT COUNT(*) as num_backup_storagess
				FROM `" . TABLE_PANEL_BACKUP_STORAGES . "`
			");
			$result = Database::pexecute_first($result_stmt, null, true, true);
			if ($result) {
				return $this->response($result['num_backup_storagess']);
			}
			$this->response(0);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * create a backup storage by given id
	 *
	 * @param string $name
	 *
	 * @access admin
	 * @return string json-encoded array
	 * @throws Exception
	 */
	public function add()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			//
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * return an admin entry by id
	 *
	 * @param int $id
	 *            optional, the backup-storage-id
	 *
	 * @access admin
	 * @return string json-encoded array
	 * @throws Exception
	 */
	public function get()
	{
		$id = $this->getParam('id');

		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_BACKUP_STORAGES . "`
				WHERE `id` = :id"
			);
			$params = [
				'id' => $id
			];
			$result = Database::pexecute_first($result_stmt, $params, true, true);
			if ($result) {
				$this->logger()->logAction(FroxlorLogger::ADM_ACTION, LOG_INFO, "[API] get backup storage for '" . $result['id'] . "'");
				return $this->response($result);
			}
			throw new Exception("Backup storage with " . $id . " could not be found", 404);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * update a backup storage by given id
	 *
	 * @param int $id
	 * 			required, the backup-storage-id
	 *
	 * @access admin
	 * @return string json-encoded array
	 * @throws Exception
	 */
	public function update()
	{
		$id = $this->getParam('id');

		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			// validation
			$result = $this->apiCall('BackupStorages.get', [
				'id' => $id
			]);

			// parameters
			$description = $this->getParam('description', true, $result['description']);
			$type = $this->getParam('type', true, $result['type']);
			$region = $this->getParam('region', true, $result['region']);
			$bucket = $this->getParam('bucket', true, $result['bucket']);
			$destination_path = $this->getParam('destination_path', true, $result['destination_path']);
			$hostname = $this->getParam('hostname', true, $result['hostname']);
			$username = $this->getParam('username', true, $result['username']);
			$password = $this->getParam('password', true, 'password');
			$pgp_public_key = $this->getParam('pgp_public_key', true, $result['pgp_public_key']);
			$retention = $this->getParam('retention', true, $result['retention']);

			// validation
			$destination_path = FileDir::makeCorrectDir(Validate::validate($destination_path, 'destination_path', Validate::REGEX_DIR, '', [], true));

			// pgp public key validation
			if (!empty($pgp_public_key)) {
				// check if gnupg extension is loaded
				if (!extension_loaded('gnupg')) {
					Response::standardError('gnupgextensionnotavailable', '', true);
				}
				// check if the pgp public key is a valid key
				putenv('GNUPGHOME='.sys_get_temp_dir());
				if (gnupg_import(gnupg_init(), $pgp_public_key) === false) {
					Response::standardError('invalidpgppublickey', '', true);
				}
			}

			// update
			$stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_BACKUP_STORAGES . "`
				SET `description` = :description,
				`type` = :type,
				`region` = :region,
				`bucket` = :bucket,
				`destination_path` = :destination_path,
				`hostname` = :hostname,
				`username` = :username,
				`password` = :password,
				`pgp_public_key` = :pgp_public_key,
				`retention` = :retention
				WHERE `id` = :id
			");
			$params = [
				"id" => $id,
				"description" => $description,
				"type" => $type,
				"region" => $region,
				"bucket" => $bucket,
				"destination_path" => $destination_path,
				"hostname" => $hostname,
				"username" => $username,
				"password" => $password,
				"pgp_public_key" => $pgp_public_key,
				"retention" => $retention,
			];
			Database::pexecute($stmt, $params, true, true);
			$this->logger()->logAction($this->isAdmin() ? FroxlorLogger::ADM_ACTION : FroxlorLogger::USR_ACTION, LOG_NOTICE, "[API] edited backup storage for '" . $result['id'] . "'");

			// return
			$result = $this->apiCall('BackupStorages.get', [
				'id' => $id
			]);
			return $this->response($result);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * delete a backup-storage entry by either id
	 *
	 * @param int $id
	 *            required, the backup-storage-id
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
