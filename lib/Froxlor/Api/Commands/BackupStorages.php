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
use Froxlor\Settings;
use Froxlor\UI\Response;
use Froxlor\Validate\Validate;
use PDO;

/**
 * @since 2.1.0
 */
class BackupStorages extends ApiCommand implements ResourceEntity
{
	const SUPPORTED_TYPES = [
		'local',
		'ftp',
		'sftp',
		'rsync',
		's3',
	];

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
			$this->logger()->logAction(FroxlorLogger::ADM_ACTION, LOG_INFO, "[API] list backup storages");
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
	 * create a backup storage
	 *
	 * @param string $type
	 *            required, backup storage type
	 * @param string $destination_path
	 *            required, destination path for backup storage
	 * @param string $description
	 *            required, description for backup storage
	 * @param string $region
	 *            optional, required if type=s3. Region for backup storage (used for S3)
	 * @param string $bucket
	 *            optional, required if type=s3. Bucket for backup storage (used for S3)
	 * @param string $hostname
	 *            optional, required if type != local. Hostname for backup storage
	 * @param string $username
	 *            optional, required if type != local. Username for backup storage (also used as access key for S3)
	 * @param string $password
	 *            optional, required if type != local. Password for backup storage (also used as secret key for S3)
	 * @param string $pgp_public_key
	 *            optional, pgp public key for backup storage
	 * @param string $retention
	 *            optional, retention for backup storage (default 3)
	 *
	 * @access admin
	 * @return string json-encoded array
	 * @throws Exception
	 */
	public function add()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			// required parameters
			$type = $this->getParam('type');
			$destination_path = $this->getParam('destination_path');
			$description = $this->getParam('description');

			// type related requirements
			$optional_flags = [
				'region' => true,
				'bucket' => true,
				'hostname' => true,
				'username' => true,
				'password' => true,
			];

			if (!in_array($type, self::SUPPORTED_TYPES)) {
				throw new Exception("Unsupported storage type: '" . $type . "'", 406);
			}

			if ($type != 'local') {
				$optional_flags['hostname'] = false;
				$optional_flags['username'] = false;
				$optional_flags['password'] = false;
			}
			if ($type == 's3') {
				$optional_flags['region'] = false;
				$optional_flags['bucket'] = false;
			}

			// parameters
			$region = $this->getParam('region', $optional_flags['region']);
			$bucket = $this->getParam('bucket', $optional_flags['bucket']);
			$hostname = $this->getParam('hostname', $optional_flags['hostname']);
			$username = $this->getParam('username', $optional_flags['username']);
			$password = $this->getParam('password', $optional_flags['password']);
			$pgp_public_key = $this->getParam('pgp_public_key', true, null);
			$retention = $this->getParam('retention', true, 3);

			// validation
			$destination_path = FileDir::makeCorrectDir(Validate::validate($destination_path, 'destination_path', Validate::REGEX_DIR, '', [], true));
			// TODO: add more validation

			// pgp public key validation
			if (!empty($pgp_public_key)) {
				// check if gnupg extension is loaded
				if (!extension_loaded('gnupg')) {
					Response::standardError('gnupgextensionnotavailable', '', true);
				}
				// check if the pgp public key is a valid key
				putenv('GNUPGHOME=' . sys_get_temp_dir());
				if (gnupg_import(gnupg_init(), $pgp_public_key) === false) {
					Response::standardError('invalidpgppublickey', '', true);
				}
			}

			// store
			$stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_BACKUP_STORAGES . "` (
				`description`,
				`type`,
				`region`,
				`bucket`,
				`destination_path`,
				`hostname`,
				`username`,
				`password`,
				`pgp_public_key`,
				`retention`
				) VALUES (
				:description,
				:type,
				:region,
				:bucket,
				:destination_path,
				:hostname,
				:username,
				:password,
				:pgp_public_key,
				:retention
				)
			");
			$params = [
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
			$id = Database::lastInsertId();

			// return
			$result = $this->apiCall('BackupStorages.get', [
				'id' => $id
			]);
			$this->logger()->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, "[API] added backup storage '" . $result['description'] . "' (" . $result['type'] . ")");
			return $this->response($result);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * return a backup storage entry by id
	 *
	 * @param int $id
	 *            the backup-storage-id
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
				$this->logger()->logAction(FroxlorLogger::ADM_ACTION, LOG_INFO, "[API] get backup storage '" . $result['description'] . "'");
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
	 *            required, the backup-storage-id
	 * @param string $type
	 *            optional, backup storage type
	 * @param string $destination_path
	 *            optional, destination path for backup storage
	 * @param string $description
	 *            required, description for backup storage
	 * @param string $region
	 *            optional, region for backup storage (used for S3)
	 * @param string $bucket
	 *            optional, bucket for backup storage (used for S3)
	 * @param string $hostname
	 *            optional, hostname for backup storage
	 * @param string $username
	 *            optional, username for backup storage (also used as access key for S3)
	 * @param string $password
	 *            optional, password for backup storage (also used as secret key for S3)
	 * @param string $pgp_public_key
	 *            optional, pgp public key for backup storage
	 * @param string $retention
	 *            optional, retention for backup storage (default 3)
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
			$password = $this->getParam('password', true, '');
			$pgp_public_key = $this->getParam('pgp_public_key', true, $result['pgp_public_key']);
			$retention = $this->getParam('retention', true, $result['retention']);

			if (!in_array($type, self::SUPPORTED_TYPES)) {
				throw new Exception("Unsupported storage type: '" . $type . "'", 406);
			}

			if ($type != 'local') {
				if (empty($hostname)) {
					throw new Exception("Field 'hostname' cannot be empty", 406);
				}
				if (empty($username)) {
					throw new Exception("Field 'username' cannot be empty", 406);
				}
				$password = Validate::validate($password, 'password', '', '', [], true);
			}
			if ($type == 's3') {
				if (empty($region)) {
					throw new Exception("Field 'region' cannot be empty", 406);
				}
				if (empty($bucket)) {
					throw new Exception("Field 'bucket' cannot be empty", 406);
				}
			}

			// validation
			$destination_path = FileDir::makeCorrectDir(Validate::validate($destination_path, 'destination_path', Validate::REGEX_DIR, '', [], true));
			// TODO: add more validation

			// pgp public key validation
			if (!empty($pgp_public_key) && $pgp_public_key != $result['pgp_public_key']) {
				// check if gnupg extension is loaded
				if (!extension_loaded('gnupg')) {
					Response::standardError('gnupgextensionnotavailable', '', true);
				}
				// check if the pgp public key is a valid key
				putenv('GNUPGHOME=' . sys_get_temp_dir());
				if (gnupg_import(gnupg_init(), $pgp_public_key) === false) {
					Response::standardError('invalidpgppublickey', '', true);
				}
			}

			if (!empty($password)) {
				$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_BACKUP_STORAGES . "`
					SET `password` = :password
					WHERE `id` = :id
				");
				Database::pexecute($stmt, [
					"id" => $id,
					"password" => $password
				], true, true);
				$this->logger()->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, "[API] updated password for backup-storage '" . $result['description'] . "'");
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
				"pgp_public_key" => $pgp_public_key,
				"retention" => $retention,
			];
			Database::pexecute($stmt, $params, true, true);
			$this->logger()->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, "[API] edited backup storage '" . $result['description'] . "'");

			// return
			$result = $this->apiCall('BackupStorages.get', [
				'id' => $id
			]);
			return $this->response($result);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * delete a backup-storage entry by id
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
		$id = $this->getParam('id');

		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			// validation
			$result = $this->apiCall('BackupStorages.get', [
				'id' => $id
			]);

			// validate no-one's using it

			// settings
			if ($id == Settings::Get('backup.default_storage')) {
				throw new Exception("Given backup storage is currently set as default storage and cannot be deleted.", 406);
			}
			// customers
			$sel_stmt = Database::prepare("
				SELECT COUNT(*) as num_storage_users
				FROM `" . TABLE_PANEL_CUSTOMERS . "`
				WHERE `backup` = :id
			");
			$storage_users_result = Database::pexecute_first($sel_stmt, ['id' => $id]);
			if ($storage_users_result && $storage_users_result['num_storage_users'] > 0) {
				throw new Exception("Given backup storage is currently assigned to " . $storage_users_result['num_storage_users'] . " customers and cannot be deleted.", 406);
			}
			// existing backups
			$sel_stmt = Database::prepare("
				SELECT COUNT(*) as num_storage_backups
				FROM `" . TABLE_PANEL_BACKUPS . "`
				WHERE `storage_id` = :id
			");
			$storage_backups_result = Database::pexecute_first($sel_stmt, ['id' => $id]);
			if ($storage_backups_result && $storage_backups_result['num_storage_backups'] > 0) {
				throw new Exception("Given backup storage has still " . $storage_backups_result['num_storage_backups'] . " backups on it and cannot be deleted.", 406);
			}

			// delete
			$stmt = Database::prepare("
				DELETE FROM `" . TABLE_PANEL_BACKUP_STORAGES . "`
				WHERE `id` = :id
			");
			$params = [
				"id" => $id
			];
			Database::pexecute($stmt, $params, true, true);
			$this->logger()->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, "[API] deleted backup storage '" . $result['description'] . "'");

			// return
			return $this->response(true);
		}

		throw new Exception("Not allowed to execute given command.", 403);
	}
}
