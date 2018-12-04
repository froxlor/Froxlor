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
 * @package    API
 * @since      0.10.0
 *
 */
class PhpSettings extends ApiCommand implements ResourceEntity
{

	/**
	 * lists all php-setting entries
	 *
	 * @access admin
	 * @throws Exception
	 * @return array count|list
	 */
	public function listing()
	{
		if ($this->isAdmin()) {
			$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] list php-configs");

			$result = Database::query("
				SELECT c.*, fd.description as fpmdesc
				FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
				LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fd ON fd.id = c.fpmsettingid
				ORDER BY c.description ASC
			");

			$phpconfigs = array();
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$query_params = array(
					'id' => $row['id']
				);

				$query = "SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `phpsettingid` = :id
					AND `parentdomainid` = '0'";

				if ((int) $this->getUserDetail('domains_see_all') == 0) {
					$query .= " AND `adminid` = :adminid";
					$query_params['adminid'] = $this->getUserDetail('adminid');
				}

				if ((int) Settings::Get('panel.phpconfigs_hidestdsubdomain') == 1) {
					$ssdids_res = Database::query("
					SELECT DISTINCT `standardsubdomain` FROM `" . TABLE_PANEL_CUSTOMERS . "`
					WHERE `standardsubdomain` > 0 ORDER BY `standardsubdomain` ASC;");
					$ssdids = array();
					while ($ssd = $ssdids_res->fetch(PDO::FETCH_ASSOC)) {
						$ssdids[] = $ssd['standardsubdomain'];
					}
					if (count($ssdids) > 0) {
						$query .= " AND `id` NOT IN (" . implode(', ', $ssdids) . ")";
					}
				}

				$domains = array();
				$domainresult_stmt = Database::prepare($query);
				Database::pexecute($domainresult_stmt, $query_params, true, true);

				if (Database::num_rows() > 0) {
					while ($row2 = $domainresult_stmt->fetch(PDO::FETCH_ASSOC)) {
						$domains[] = $row2['domain'];
					}
				}

				// check whether we use that config as froxor-vhost config
				if (Settings::Get('system.mod_fcgid_defaultini_ownvhost') == $row['id'] || Settings::Get('phpfpm.vhost_defaultini') == $row['id']) {
					$domains[] = Settings::Get('system.hostname');
				}

				if (empty($domains)) {
					$domains[] = $this->lng['admin']['phpsettings']['notused'];
				}

				// check whether this is our default config
				if ((Settings::Get('system.mod_fcgid') == '1' && Settings::Get('system.mod_fcgid_defaultini') == $row['id']) || (Settings::Get('phpfpm.enabled') == '1' && Settings::Get('phpfpm.defaultini') == $row['id'])) {
					$row['is_default'] = true;
				}

				$row['domains'] = $domains;
				$phpconfigs[] = $row;
			}

			return $this->response(200, "successfull", array(
				'count' => count($phpconfigs),
				'list' => $phpconfigs
			));
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * return a php-setting entry by id
	 *
	 * @param int $id
	 *        	php-settings-id
	 *        	
	 * @access admin
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id');

			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = :id
			");
			$result = Database::pexecute_first($result_stmt, array(
				'id' => $id
			), true, true);
			if ($result) {
				return $this->response(200, "successfull", $result);
			}
			throw new Exception("php-config with id #" . $id . " could not be found", 404);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * add new php-settings entry
	 *
	 * @param string $description
	 *        	description of the php-config
	 * @param string $phpsettings
	 *        	the actual ini-settings
	 * @param string $binary
	 *        	optional the binary to php-cgi if FCGID is used
	 * @param string $file_extensions
	 *        	optional allowed php-file-extensions if FCGID is used, default is 'php'
	 * @param int $mod_fcgid_starter
	 *        	optional number of fcgid-starters if FCGID is used, default is -1
	 * @param int $mod_fcgid_maxrequests
	 *        	optional number of fcgid-maxrequests if FCGID is used, default is -1
	 * @param string $mod_fcgid_umask
	 *        	optional umask if FCGID is used, default is '022'
	 * @param int $fpmconfig
	 *        	optional id of the fpm-daemon-config if FPM is used
	 * @param bool $phpfpm_enable_slowlog
	 *        	optional whether to write a slowlog or not if FPM is used, default is 0 (false)
	 * @param string $phpfpm_reqtermtimeout
	 *        	optional request terminate timeout if FPM is used, default is '60s'
	 * @param string $phpfpm_reqslowtimeout
	 *        	optional request slowlog timeout if FPM is used, default is '5s'
	 * @param bool $phpfpm_pass_authorizationheader
	 *        	optional whether to pass authorization header to webserver if FPM is used, default is 0 (false)
	 * @param bool $override_fpmconfig
	 *        	optional whether to override fpm-daemon-config value for the following settings if FPM is used, default is 0 (false)
	 * @param string $pm
	 *        	optional process-manager to use if FPM is used (allowed values are 'static', 'dynamic' and 'ondemand'), default is fpm-daemon-value
	 * @param int $max_children
	 *        	optional number of max children if FPM is used, default is the fpm-daemon-value
	 * @param int $start_server
	 *        	optional number of servers to start if FPM is used, default is fpm-daemon-value
	 * @param int $min_spare_servers
	 *        	optional number of minimum spare servers if FPM is used, default is fpm-daemon-value
	 * @param int $max_spare_servers
	 *        	optional number of maximum spare servers if FPM is used, default is fpm-daemon-value
	 * @param int $max_requests
	 *        	optional number of maximum requests if FPM is used, default is fpm-daemon-value
	 * @param int $idle_timeout
	 *        	optional number of seconds for idle-timeout if FPM is used, default is fpm-daemon-value
	 * @param string $limit_extensions
	 *        	optional limitation of php-file-extensions if FPM is used, default is fpm-daemon-value
	 *        	
	 * @access admin
	 * @throws Exception
	 * @return array
	 */
	public function add()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {

			// required parameter
			$description = $this->getParam('description');
			$phpsettings = $this->getParam('phpsettings');

			if (Settings::Get('system.mod_fcgid') == 1) {
				$binary = $this->getParam('binary');
				$fpm_config_id = 1;
			} elseif (Settings::Get('phpfpm.enabled') == 1) {
				$fpm_config_id = intval($this->getParam('fpmconfig'));
			} else {
				$fpm_config_id = 1;
			}

			// parameters
			$file_extensions = $this->getParam('file_extensions', true, 'php');
			$mod_fcgid_starter = $this->getParam('mod_fcgid_starter', true, - 1);
			$mod_fcgid_maxrequests = $this->getParam('mod_fcgid_maxrequests', true, - 1);
			$mod_fcgid_umask = $this->getParam('mod_fcgid_umask', true, "022");
			$fpm_enableslowlog = $this->getBoolParam('phpfpm_enable_slowlog', true, 0);
			$fpm_reqtermtimeout = $this->getParam('phpfpm_reqtermtimeout', true, "60s");
			$fpm_reqslowtimeout = $this->getParam('phpfpm_reqslowtimeout', true, "5s");
			$fpm_pass_authorizationheader = $this->getBoolParam('phpfpm_pass_authorizationheader', true, 0);

			$override_fpmconfig = $this->getBoolParam('override_fpmconfig', true, 0);
			$def_fpmconfig = $this->apiCall('FpmDaemons.get', array(
				'id' => $fpm_config_id
			));
			$pmanager = $this->getParam('pm', true, $def_fpmconfig['pm']);
			$max_children = $this->getParam('max_children', true, $def_fpmconfig['max_children']);
			$start_servers = $this->getParam('start_servers', true, $def_fpmconfig['start_servers']);
			$min_spare_servers = $this->getParam('min_spare_servers', true, $def_fpmconfig['min_spare_servers']);
			$max_spare_servers = $this->getParam('max_spare_servers', true, $def_fpmconfig['max_spare_servers']);
			$max_requests = $this->getParam('max_requests', true, $def_fpmconfig['max_requests']);
			$idle_timeout = $this->getParam('idle_timeout', true, $def_fpmconfig['idle_timeout']);
			$limit_extensions = $this->getParam('limit_extensions', true, $def_fpmconfig['limit_extensions']);

			// validation
			$description = validate($description, 'description', '', '', array(), true);
			$phpsettings = validate(str_replace("\r\n", "\n", $phpsettings), 'phpsettings', '/^[^\0]*$/', '', array(), true);
			if (Settings::Get('system.mod_fcgid') == 1) {
				$binary = makeCorrectFile(validate($binary, 'binary', '', '', array(), true));
				$file_extensions = validate($file_extensions, 'file_extensions', '/^[a-zA-Z0-9\s]*$/', '', array(), true);
				$mod_fcgid_starter = validate($mod_fcgid_starter, 'mod_fcgid_starter', '/^[0-9]*$/', '', array(
					'-1',
					''
				), true);
				$mod_fcgid_maxrequests = validate($mod_fcgid_maxrequests, 'mod_fcgid_maxrequests', '/^[0-9]*$/', '', array(
					'-1',
					''
				), true);
				$mod_fcgid_umask = validate($mod_fcgid_umask, 'mod_fcgid_umask', '/^[0-9]*$/', '', array(), true);
				// disable fpm stuff
				$fpm_config_id = 1;
				$fpm_enableslowlog = 0;
				$fpm_reqtermtimeout = 0;
				$fpm_reqslowtimeout = 0;
				$fpm_pass_authorizationheader = 0;
				$override_fpmconfig = 0;
			} elseif (Settings::Get('phpfpm.enabled') == 1) {
				$fpm_reqtermtimeout = validate($fpm_reqtermtimeout, 'phpfpm_reqtermtimeout', '/^([0-9]+)(|s|m|h|d)$/', '', array(), true);
				$fpm_reqslowtimeout = validate($fpm_reqslowtimeout, 'phpfpm_reqslowtimeout', '/^([0-9]+)(|s|m|h|d)$/', '', array(), true);
				if (! in_array($pmanager, array(
					'static',
					'dynamic',
					'ondemand'
				))) {
					throw new ErrorException("Unknown process manager", 406);
				}
				if (empty($limit_extensions)) {
					$limit_extensions = '.php';
				}
				$limit_extensions = validate($limit_extensions, 'limit_extensions', '/^(\.[a-z]([a-z0-9]+)\ ?)+$/', '', array(), true);

				// disable fcgid stuff
				$binary = '/usr/bin/php-cgi';
				$file_extensions = 'php';
				$mod_fcgid_starter = 0;
				$mod_fcgid_maxrequests = 0;
				$mod_fcgid_umask = "022";
			}

			if (strlen($description) == 0 || strlen($description) > 50) {
				standard_error('descriptioninvalid', '', true);
			}

			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_PHPCONFIGS . "` SET
				`description` = :desc,
				`binary` = :binary,
				`file_extensions` = :fext,
				`mod_fcgid_starter` = :starter,
				`mod_fcgid_maxrequests` = :mreq,
				`mod_fcgid_umask` = :umask,
				`fpm_slowlog` = :fpmslow,
				`fpm_reqterm` = :fpmreqterm,
				`fpm_reqslow` = :fpmreqslow,
				`phpsettings` = :phpsettings,
				`fpmsettingid` = :fpmsettingid,
				`pass_authorizationheader` = :fpmpassauth,
				`override_fpmconfig` = :ofc,
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
				'binary' => $binary,
				'fext' => $file_extensions,
				'starter' => $mod_fcgid_starter,
				'mreq' => $mod_fcgid_maxrequests,
				'umask' => $mod_fcgid_umask,
				'fpmslow' => $fpm_enableslowlog,
				'fpmreqterm' => $fpm_reqtermtimeout,
				'fpmreqslow' => $fpm_reqslowtimeout,
				'phpsettings' => $phpsettings,
				'fpmsettingid' => $fpm_config_id,
				'fpmpassauth' => $fpm_pass_authorizationheader,
				'ofc' => $override_fpmconfig,
				'pm' => $pmanager,
				'max_children' => $max_children,
				'start_servers' => $start_servers,
				'min_spare_servers' => $min_spare_servers,
				'max_spare_servers' => $max_spare_servers,
				'max_requests' => $max_requests,
				'idle_timeout' => $idle_timeout,
				'limit_extensions' => $limit_extensions
			);
			Database::pexecute($ins_stmt, $ins_data, true, true);
			$ins_data['id'] = Database::lastInsertId();

			inserttask('1');
			$this->logger()->logAction(ADM_ACTION, LOG_INFO, "[API] php setting with description '" . $description . "' has been created by '" . $this->getUserDetail('loginname') . "'");

			$result = $this->apiCall('PhpSettings.get', array(
				'id' => $ins_data['id']
			));
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * update a php-setting entry by given id
	 *
	 * @param int $id
	 * @param string $description
	 *        	description of the php-config
	 * @param string $phpsettings
	 *        	the actual ini-settings
	 * @param string $binary
	 *        	optional the binary to php-cgi if FCGID is used
	 * @param string $file_extensions
	 *        	optional allowed php-file-extensions if FCGID is used, default is 'php'
	 * @param int $mod_fcgid_starter
	 *        	optional number of fcgid-starters if FCGID is used, default is -1
	 * @param int $mod_fcgid_maxrequests
	 *        	optional number of fcgid-maxrequests if FCGID is used, default is -1
	 * @param string $mod_fcgid_umask
	 *        	optional umask if FCGID is used, default is '022'
	 * @param int $fpmconfig
	 *        	optional id of the fpm-daemon-config if FPM is used
	 * @param bool $phpfpm_enable_slowlog
	 *        	optional whether to write a slowlog or not if FPM is used, default is 0 (false)
	 * @param string $phpfpm_reqtermtimeout
	 *        	optional request terminate timeout if FPM is used, default is '60s'
	 * @param string $phpfpm_reqslowtimeout
	 *        	optional request slowlog timeout if FPM is used, default is '5s'
	 * @param bool $phpfpm_pass_authorizationheader
	 *        	optional whether to pass authorization header to webserver if FPM is used, default is 0 (false)
	 * @param bool $override_fpmconfig
	 *        	optional whether to override fpm-daemon-config value for the following settings if FPM is used, default is 0 (false)
	 * @param string $pm
	 *        	optional process-manager to use if FPM is used (allowed values are 'static', 'dynamic' and 'ondemand'), default is fpm-daemon-value
	 * @param int $max_children
	 *        	optional number of max children if FPM is used, default is the fpm-daemon-value
	 * @param int $start_server
	 *        	optional number of servers to start if FPM is used, default is fpm-daemon-value
	 * @param int $min_spare_servers
	 *        	optional number of minimum spare servers if FPM is used, default is fpm-daemon-value
	 * @param int $max_spare_servers
	 *        	optional number of maximum spare servers if FPM is used, default is fpm-daemon-value
	 * @param int $max_requests
	 *        	optional number of maximum requests if FPM is used, default is fpm-daemon-value
	 * @param int $idle_timeout
	 *        	optional number of seconds for idle-timeout if FPM is used, default is fpm-daemon-value
	 * @param string $limit_extensions
	 *        	optional limitation of php-file-extensions if FPM is used, default is fpm-daemon-value
	 *        	
	 * @access admin
	 * @throws Exception
	 * @return array
	 */
	public function update()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {

			// required parameter
			$id = $this->getParam('id');

			$result = $this->apiCall('PhpSettings.get', array(
				'id' => $id
			));

			// parameters
			$description = $this->getParam('description', true, $result['description']);
			$phpsettings = $this->getParam('phpsettings', true, $result['phpsettings']);
			$binary = $this->getParam('binary', true, $result['binary']);
			$fpm_config_id = intval($this->getParam('fpmconfig', true, $result['fpmsettingid']));
			$file_extensions = $this->getParam('file_extensions', true, $result['file_extensions']);
			$mod_fcgid_starter = $this->getParam('mod_fcgid_starter', true, $result['mod_fcgid_starter']);
			$mod_fcgid_maxrequests = $this->getParam('mod_fcgid_maxrequests', true, $result['mod_fcgid_maxrequests']);
			$mod_fcgid_umask = $this->getParam('mod_fcgid_umask', true, $result['mod_fcgid_umask']);
			$fpm_enableslowlog = $this->getBoolParam('phpfpm_enable_slowlog', true, $result['fpm_slowlog']);
			$fpm_reqtermtimeout = $this->getParam('phpfpm_reqtermtimeout', true, $result['fpm_reqterm']);
			$fpm_reqslowtimeout = $this->getParam('phpfpm_reqslowtimeout', true, $result['fpm_reqslow']);
			$fpm_pass_authorizationheader = $this->getBoolParam('phpfpm_pass_authorizationheader', true, $result['pass_authorizationheader']);
			$override_fpmconfig = $this->getBoolParam('override_fpmconfig', true, $result['override_fpmconfig']);
			$pmanager = $this->getParam('pm', true, $result['pm']);
			$max_children = $this->getParam('max_children', true, $result['max_children']);
			$start_servers = $this->getParam('start_servers', true, $result['start_servers']);
			$min_spare_servers = $this->getParam('min_spare_servers', true, $result['min_spare_servers']);
			$max_spare_servers = $this->getParam('max_spare_servers', true, $result['max_spare_servers']);
			$max_requests = $this->getParam('max_requests', true, $result['max_requests']);
			$idle_timeout = $this->getParam('idle_timeout', true, $result['idle_timeout']);
			$limit_extensions = $this->getParam('limit_extensions', true, $result['limit_extensions']);

			// validation
			$description = validate($description, 'description', '', '', array(), true);
			$phpsettings = validate(str_replace("\r\n", "\n", $phpsettings), 'phpsettings', '/^[^\0]*$/', '', array(), true);
			if (Settings::Get('system.mod_fcgid') == 1) {
				$binary = makeCorrectFile(validate($binary, 'binary', '', '', array(), true));
				$file_extensions = validate($file_extensions, 'file_extensions', '/^[a-zA-Z0-9\s]*$/', '', array(), true);
				$mod_fcgid_starter = validate($mod_fcgid_starter, 'mod_fcgid_starter', '/^[0-9]*$/', '', array(
					'-1',
					''
				), true);
				$mod_fcgid_maxrequests = validate($mod_fcgid_maxrequests, 'mod_fcgid_maxrequests', '/^[0-9]*$/', '', array(
					'-1',
					''
				), true);
				$mod_fcgid_umask = validate($mod_fcgid_umask, 'mod_fcgid_umask', '/^[0-9]*$/', '', array(), true);
				// disable fpm stuff
				$fpm_config_id = 1;
				$fpm_enableslowlog = 0;
				$fpm_reqtermtimeout = 0;
				$fpm_reqslowtimeout = 0;
				$fpm_pass_authorizationheader = 0;
				$override_fpmconfig = 0;
			} elseif (Settings::Get('phpfpm.enabled') == 1) {
				$fpm_reqtermtimeout = validate($fpm_reqtermtimeout, 'phpfpm_reqtermtimeout', '/^([0-9]+)(|s|m|h|d)$/', '', array(), true);
				$fpm_reqslowtimeout = validate($fpm_reqslowtimeout, 'phpfpm_reqslowtimeout', '/^([0-9]+)(|s|m|h|d)$/', '', array(), true);
				if (! in_array($pmanager, array(
					'static',
					'dynamic',
					'ondemand'
				))) {
					throw new ErrorException("Unknown process manager", 406);
				}
				if (empty($limit_extensions)) {
					$limit_extensions = '.php';
				}
				$limit_extensions = validate($limit_extensions, 'limit_extensions', '/^(\.[a-z]([a-z0-9]+)\ ?)+$/', '', array(), true);

				// disable fcgid stuff
				$binary = '/usr/bin/php-cgi';
				$file_extensions = 'php';
				$mod_fcgid_starter = 0;
				$mod_fcgid_maxrequests = 0;
				$mod_fcgid_umask = "022";
			}

			if (strlen($description) == 0 || strlen($description) > 50) {
				standard_error('descriptioninvalid', '', true);
			}

			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_PHPCONFIGS . "` SET
				`description` = :desc,
				`binary` = :binary,
				`file_extensions` = :fext,
				`mod_fcgid_starter` = :starter,
				`mod_fcgid_maxrequests` = :mreq,
				`mod_fcgid_umask` = :umask,
				`fpm_slowlog` = :fpmslow,
				`fpm_reqterm` = :fpmreqterm,
				`fpm_reqslow` = :fpmreqslow,
				`phpsettings` = :phpsettings,
				`fpmsettingid` = :fpmsettingid,
				`pass_authorizationheader` = :fpmpassauth,
				`override_fpmconfig` = :ofc,
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
				'binary' => $binary,
				'fext' => $file_extensions,
				'starter' => $mod_fcgid_starter,
				'mreq' => $mod_fcgid_maxrequests,
				'umask' => $mod_fcgid_umask,
				'fpmslow' => $fpm_enableslowlog,
				'fpmreqterm' => $fpm_reqtermtimeout,
				'fpmreqslow' => $fpm_reqslowtimeout,
				'phpsettings' => $phpsettings,
				'fpmsettingid' => $fpm_config_id,
				'fpmpassauth' => $fpm_pass_authorizationheader,
				'ofc' => $override_fpmconfig,
				'pm' => $pmanager,
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
			$this->logger()->logAction(ADM_ACTION, LOG_INFO, "[API] php setting with description '" . $description . "' has been updated by '" . $this->getUserDetail('loginname') . "'");

			$result = $this->apiCall('PhpSettings.get', array(
				'id' => $id
			));
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * delete a php-setting entry by id
	 *
	 * @param int $id
	 *        	php-settings-id
	 *        	
	 * @access admin
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			$id = $this->getParam('id');

			$result = $this->apiCall('PhpSettings.get', array(
				'id' => $id
			));

			if ((Settings::Get('system.mod_fcgid') == '1' && Settings::Get('system.mod_fcgid_defaultini_ownvhost') == $id) || (Settings::Get('phpfpm.enabled') == '1' && Settings::Get('phpfpm.vhost_defaultini') == $id)) {
				standard_error('cannotdeletehostnamephpconfig', '', true);
			}

			if ((Settings::Get('system.mod_fcgid') == '1' && Settings::Get('system.mod_fcgid_defaultini') == $id) || (Settings::Get('phpfpm.enabled') == '1' && Settings::Get('phpfpm.defaultini') == $id)) {
				standard_error('cannotdeletedefaultphpconfig', '', true);
			}

			// set php-config to default for all domains using the
			// config that is to be deleted
			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
				`phpsettingid` = '1' WHERE `phpsettingid` = :id
			");
			Database::pexecute($upd_stmt, array(
				'id' => $id
			), true, true);

			$del_stmt = Database::prepare("
				DELETE FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = :id
			");
			Database::pexecute($del_stmt, array(
				'id' => $id
			), true, true);

			inserttask('1');
			$this->logger()->logAction(ADM_ACTION, LOG_INFO, "[API] php setting '" . $result['description'] . "' has been deleted by '" . $this->getUserDetail('loginname') . "'");
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}
}
