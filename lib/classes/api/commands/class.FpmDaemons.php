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
 * @package    Panel
 *
 */
class FpmDaemons extends ApiCommand implements ResourceEntity
{

	/**
	 * lists all php-config entries
	 *
	 * @return array count|list
	 */
	public function list()
	{
		if ($this->isAdmin()) {
			$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] list fpm-daemons");
			
			$result = Database::query("
				SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` ORDER BY `description` ASC
			");
			
			$fpmdaemons = array();
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				
				$query_params = array(
					'id' => $row['id']
				);
				
				$query = "SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `fpmsettingid` = :id";
				
				$configresult_stmt = Database::prepare($query);
				Database::pexecute($configresult_stmt, $query_params, true, true);
				
				$configs = array();
				if (Database::num_rows() > 0) {
					while ($row2 = $configresult_stmt->fetch(PDO::FETCH_ASSOC)) {
						$configs[] = $row2['description'];
					}
				}
				
				if (empty($configs)) {
					$configs[] = $lng['admin']['phpsettings']['notused'];
				}
				
				$row['configs'] = $configs;
				$fpmdaemons[] = $row;
			}
			
			return $this->response(200, "successfull", array(
				'count' => count($fpmdaemons),
				'list' => $fpmdaemons
			));
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function get()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id');
			
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` WHERE `id` = :id
			");
			$result = Database::pexecute_first($result_stmt, array(
				'id' => $id
			), true, true);
			if ($result) {
				return $this->response(200, "successfull", $result);
			}
			throw new Exception("fpm-daemon with id #" . $id . " could not be found", 404);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function add()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			
			// required parameter
			$description = $this->getParam('description');
			$reload_cmd = $this->getParam('reload_cmd');
			$config_dir = $this->getParam('config_dir');
			
			// parameters
			$pm = $this->getParam('pm', true, 'static');
			$max_children = $this->getParam('max_children', true, 0);
			$start_servers = $this->getParam('start_servers', true, 0);
			$min_spare_servers = $this->getParam('min_spare_servers', true, 0);
			$max_spare_servers = $this->getParam('max_spare_servers', true, 0);
			$max_requests = $this->getParam('max_requests', true, 0);
			$idle_timeout = $this->getParam('idle_timeout', true, 0);
			$limit_extensions = $this->getParam('limit_extensions', true, '');
			
			// validation
			$description = validate($description, 'description', '', '', array(), true);
			$reload_cmd = validate($reload_cmd, 'reload_cmd', '', '', array(), true);
			$config_dir = validate($config_dir, 'config_dir', '', '', array(), true);
			if (! in_array($pm, array(
				'static',
				'dynamic',
				'ondemand'
			))) {
				throw new ErrorException("Unknown process manager", 406);
			}
			$limit_extensions = validate($limit_extensions, 'limit_extensions', '/^(\.[a-z]([a-z0-9]+)\ ?)+$/', '', array(), true);
			
			if (strlen($description) == 0 || strlen($description) > 50) {
				standard_error('descriptioninvalid', '', true);
			}
			
			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_FPMDAEMONS . "` SET
				`description` = :desc,
				`reload_cmd` = :reload_cmd,
				`config_dir` = :config_dir,
				`pm` = :pm,
				`max_children` = :max_children,
				`start_servers` = :start_servers,
				`min_spare_servers` = :min_spare_servers,
				`max_spare_servers` = :max_spare_servers,
				`max_requests` = :max_requests,
				`idle_timeout` = :idle_timeout,
				`limit_extensions` = :limit_extensions
			");
			$ins_data = array(
				'desc' => $description,
				'reload_cmd' => $reload_cmd,
				'config_dir' => makeCorrectDir($config_dir),
				'pm' => $pm,
				'max_children' => $max_children,
				'start_servers' => $start_servers,
				'min_spare_servers' => $min_spare_servers,
				'max_spare_servers' => $max_spare_servers,
				'max_requests' => $max_requests,
				'idle_timeout' => $idle_timeout,
				'limit_extensions' => $limit_extensions
			);
			Database::pexecute($ins_stmt, $ins_data);
			$ins_data['id'] = Database::lastInsertId();
			
			inserttask('1');
			$this->logger()->logAction(ADM_ACTION, LOG_INFO, "[API] fpm-daemon with description '" . $description . "' has been created by '" . $this->getUserDetail('loginname') . "'");
			return $this->response(200, "successfull", $ins_data);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function update()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			
			// required parameter
			$id = $this->getParam('id');
			
			$json_result = PhpSettings::getLocal($this->getUserData(), array(
				'id' => $id
			))->get();
			$result = json_decode($json_result, true)['data'];
			
			// parameters
			$description = $this->getParam('description', true, $result['description']);
			$reload_cmd = $this->getParam('reload_cmd', true, $result['reload_cmd']);
			$config_dir = $this->getParam('config_dir', true, $result['config_dir']);
			$pm = $this->getParam('pm', true, $result['pm']);
			$max_children = $this->getParam('max_children', true, $result['max_children']);
			$start_servers = $this->getParam('start_servers', true, $result['start_servers']);
			$min_spare_servers = $this->getParam('min_spare_servers', true, $result['min_spare_servers']);
			$max_spare_servers = $this->getParam('max_spare_servers', true, $result['max_spare_servers']);
			$max_requests = $this->getParam('max_requests', true, $result['max_requests']);
			$idle_timeout = $this->getParam('idle_timeout', true, $result['idle_timeout']);
			$limit_extensions = $this->getParam('limit_extensions', true, $result['limit_extensions']);
			
			// validation
			$description = validate($description, 'description', '', '', array(), true);
			$reload_cmd = validate($reload_cmd, 'reload_cmd', '', '', array(), true);
			$config_dir = validate($config_dir, 'config_dir', '', '', array(), true);
			if (! in_array($pm, array(
				'static',
				'dynamic',
				'ondemand'
			))) {
				throw new ErrorException("Unknown process manager", 406);
			}
			$limit_extensions = validate($limit_extensions, 'limit_extensions', '/^(\.[a-z]([a-z0-9]+)\ ?)+$/', '', array(), true);
			
			if (strlen($description) == 0 || strlen($description) > 50) {
				standard_error('descriptioninvalid', '', true);
			}
			
			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_FPMDAEMONS . "` SET
				`description` = :desc,
				`reload_cmd` = :reload_cmd,
				`config_dir` = :config_dir,
				`pm` = :pm,
				`max_children` = :max_children,
				`start_servers` = :start_servers,
				`min_spare_servers` = :min_spare_servers,
				`max_spare_servers` = :max_spare_servers,
				`max_requests` = :max_requests,
				`idle_timeout` = :idle_timeout,
				`limit_extensions` = :limit_extensions
				WHERE `id` = :id
			");
			$upd_data = array(
				'desc' => $description,
				'reload_cmd' => $reload_cmd,
				'config_dir' => makeCorrectDir($config_dir),
				'pm' => $pm,
				'max_children' => $max_children,
				'start_servers' => $start_servers,
				'min_spare_servers' => $min_spare_servers,
				'max_spare_servers' => $max_spare_servers,
				'max_requests' => $max_requests,
				'idle_timeout' => $idle_timeout,
				'limit_extensions' => $limit_extensions,
				'id' => $id
			);
			Database::pexecute($upd_stmt, $upd_data, true, true);
			
			inserttask('1');
			$this->logger()->logAction(ADM_ACTION, LOG_INFO, "[API] fpm-daemon with description '" . $description . "' has been updated by '" . $this->getUserDetail('loginname') . "'");
			return $this->response(200, "successfull", $upd_data);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function delete()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			$id = $this->getParam('id');
			
			if ($id == 1) {
				standard_error('cannotdeletedefaultphpconfig', '', true);
			}
			
			$json_result = FpmDaemons::getLocal($this->getUserData(), array(
				'id' => $id
			))->get();
			$result = json_decode($json_result, true)['data'];
			
			// set default fpm daemon config for all php-config that use this config that is to be deleted
			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_PHPCONFIGS . "` SET
				`fpmsettingid` = '1' WHERE `fpmsettingid` = :id
			");
			Database::pexecute($upd_stmt, array(
				'id' => $id
			), true, true);
			
			$del_stmt = Database::prepare("
				DELETE FROM `" . TABLE_PANEL_FPMDAEMONS . "` WHERE `id` = :id
			");
			Database::pexecute($del_stmt, array(
				'id' => $id
			), true, true);
			
			inserttask('1');
			$this->logger()->logAction(ADM_ACTION, LOG_INFO, "[API] fpm-daemon setting '" . $result['description'] . "' has been deleted by '" . $this->getUserDetail('loginname') . "'");
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}
}
