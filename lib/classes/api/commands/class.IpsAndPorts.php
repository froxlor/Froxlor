<?php

class IpsAndPorts extends ApiCommand
{

	public function list()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] list ips and ports");
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` ORDER BY `ip` ASC, `port` ASC
			");
			Database::pexecute($result_stmt);
			$result = array();
			while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $this->response(200, "successfull", array(
				'count' => count($result),
				'list' => $result
			));
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function get()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			$id = $this->getParam('id');
			$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] get ip and port #" . $id);
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id` = :id
			");
			$result = Database::pexecute_first($result_stmt, array(
				'id' => $id
			), true, true);
			if ($result) {
				return $this->response(200, "successfull", $result);
			}
			throw new Exception("IP/port with id #" . $id . " could not be found");
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function add()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			$ip = validate_ip2($this->getParam('ip'), false, 'invalidip', false, false, false, true);
			$port = validate($this->getParam('port'), 'port', '/^(([1-9])|([1-9][0-9])|([1-9][0-9][0-9])|([1-9][0-9][0-9][0-9])|([1-5][0-9][0-9][0-9][0-9])|(6[0-4][0-9][0-9][0-9])|(65[0-4][0-9][0-9])|(655[0-2][0-9])|(6553[0-5]))$/Di', array(
				'stringisempty',
				'myport'
			), array(), true);
			$listen_statement = ! empty($this->getParam('listen_statement')) ? 1 : 0;
			$namevirtualhost_statement = ! empty($this->getParam('namevirtualhost_statement')) ? 1 : 0;
			$vhostcontainer = ! empty($this->getParam('vhostcontainer')) ? 1 : 0;
			$specialsettings = validate(str_replace("\r\n", "\n", $this->getParam('specialsettings')), 'specialsettings', '/^[^\0]*$/', '', array(), true);
			$vhostcontainer_servername_statement = ! empty($this->getParam('vhostcontainer_servername_statement')) ? 1 : 0;
			$default_vhostconf_domain = validate(str_replace("\r\n", "\n", $this->getParam('default_vhostconf_domain')), 'default_vhostconf_domain', '/^[^\0]*$/', '', array(), true);
			$docroot = validate($this->getParam('docroot'), 'docroot', '', '', array(), true);
			
			if ((int) Settings::Get('system.use_ssl') == 1) {
				$ssl = ! empty($this->getParam('ssl')) ? intval($this->getParam('ssl')) : 0;
				$ssl_cert_file = validate($this->getParam('ssl_cert_file'), 'ssl_cert_file', '', '', array(), true);
				$ssl_key_file = validate($this->getParam('ssl_key_file'), 'ssl_key_file', '', '', array(), true);
				$ssl_ca_file = validate($this->getParam('ssl_ca_file'), 'ssl_ca_file', '', '', array(), true);
				$ssl_cert_chainfile = validate($this->getParam('ssl_cert_chainfile'), 'ssl_cert_chainfile', '', '', array(), true);
			} else {
				$ssl = 0;
				$ssl_cert_file = '';
				$ssl_key_file = '';
				$ssl_ca_file = '';
				$ssl_cert_chainfile = '';
			}
			
			if ($listen_statement != '1') {
				$listen_statement = '0';
			}
			
			if ($namevirtualhost_statement != '1') {
				$namevirtualhost_statement = '0';
			}
			
			if ($vhostcontainer != '1') {
				$vhostcontainer = '0';
			}
			
			if ($vhostcontainer_servername_statement != '1') {
				$vhostcontainer_servername_statement = '0';
			}
			
			if ($ssl != '1') {
				$ssl = '0';
			}
			
			if ($ssl_cert_file != '') {
				$ssl_cert_file = makeCorrectFile($ssl_cert_file);
			}
			
			if ($ssl_key_file != '') {
				$ssl_key_file = makeCorrectFile($ssl_key_file);
			}
			
			if ($ssl_ca_file != '') {
				$ssl_ca_file = makeCorrectFile($ssl_ca_file);
			}
			
			if ($ssl_cert_chainfile != '') {
				$ssl_cert_chainfile = makeCorrectFile($ssl_cert_chainfile);
			}
			
			if (strlen(trim($docroot)) > 0) {
				$docroot = makeCorrectDir($docroot);
			} else {
				$docroot = '';
			}
			
			$result_checkfordouble_stmt = Database::prepare("
			SELECT `id` FROM `" . TABLE_PANEL_IPSANDPORTS . "`
			WHERE `ip` = :ip AND `port` = :port");
			$result_checkfordouble = Database::pexecute_first($result_checkfordouble_stmt, array(
				'ip' => $ip,
				'port' => $port
			));
			
			if ($result_checkfordouble['id'] != '') {
				standard_error('myipnotdouble', '', true);
			}
			
			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_IPSANDPORTS . "`
				SET
				`ip` = :ip, `port` = :port, `listen_statement` = :ls,
				`namevirtualhost_statement` = :nvhs, `vhostcontainer` = :vhc,
				`vhostcontainer_servername_statement` = :vhcss,
				`specialsettings` = :ss, `ssl` = :ssl,
				`ssl_cert_file` = :ssl_cert, `ssl_key_file` = :ssl_key,
				`ssl_ca_file` = :ssl_ca, `ssl_cert_chainfile` = :ssl_chain,
				`default_vhostconf_domain` = :dvhd, `docroot` = :docroot;
			");
			$ins_data = array(
				'ip' => $ip,
				'port' => $port,
				'ls' => $listen_statement,
				'nvhs' => $namevirtualhost_statement,
				'vhc' => $vhostcontainer,
				'vhcss' => $vhostcontainer_servername_statement,
				'ss' => $specialsettings,
				'ssl' => $ssl,
				'ssl_cert' => $ssl_cert_file,
				'ssl_key' => $ssl_key_file,
				'ssl_ca' => $ssl_ca_file,
				'ssl_chain' => $ssl_cert_chainfile,
				'dvhd' => $default_vhostconf_domain,
				'docroot' => $docroot
			);
			Database::pexecute($ins_stmt, $ins_data);
			$ins_data['id'] = Database::lastInsertId();
			
			inserttask('1');
			// Using nameserver, insert a task which rebuilds the server config
			inserttask('4');
			
			if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
				$ip = '[' . $ip . ']';
			}
			$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] added IP/port '" . $ip . ":" . $port . "'");
			return $this->response(200, "successfull", $ins_data);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function update()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			$id = $this->getParam('id');
			
			$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id` = :id
		");
			$result = Database::pexecute_first($result_stmt, array(
				'id' => $id
			), true, true);
			
			$ip = validate_ip2($this->getParam('ip'), false, 'invalidip', false, false, false, true);
			$port = validate($this->getParam('port'), 'port', '/^(([1-9])|([1-9][0-9])|([1-9][0-9][0-9])|([1-9][0-9][0-9][0-9])|([1-5][0-9][0-9][0-9][0-9])|(6[0-4][0-9][0-9][0-9])|(65[0-4][0-9][0-9])|(655[0-2][0-9])|(6553[0-5]))$/Di', array(
				'stringisempty',
				'myport'
			), array(), true);
			$listen_statement = ! empty($this->getParam('listen_statement')) ? 1 : 0;
			$namevirtualhost_statement = ! empty($this->getParam('namevirtualhost_statement')) ? 1 : 0;
			$vhostcontainer = ! empty($this->getParam('vhostcontainer')) ? 1 : 0;
			$specialsettings = validate(str_replace("\r\n", "\n", $this->getParam('specialsettings')), 'specialsettings', '/^[^\0]*$/', '', array(), true);
			$vhostcontainer_servername_statement = ! empty($this->getParam('vhostcontainer_servername_statement')) ? 1 : 0;
			$default_vhostconf_domain = validate(str_replace("\r\n", "\n", $this->getParam('default_vhostconf_domain')), 'default_vhostconf_domain', '/^[^\0]*$/', '', array(), true);
			$docroot = validate($this->getParam('docroot'), 'docroot', '', '', array(), true);
			
			if ((int) Settings::Get('system.use_ssl') == 1) {
				$ssl = ! empty($this->getParam('ssl')) ? intval($this->getParam('ssl')) : 0;
				$ssl_cert_file = validate($this->getParam('ssl_cert_file'), 'ssl_cert_file', '', '', array(), true);
				$ssl_key_file = validate($this->getParam('ssl_key_file'), 'ssl_key_file', '', '', array(), true);
				$ssl_ca_file = validate($this->getParam('ssl_ca_file'), 'ssl_ca_file', '', '', array(), true);
				$ssl_cert_chainfile = validate($this->getParam('ssl_cert_chainfile'), 'ssl_cert_chainfile', '', '', array(), true);
			} else {
				$ssl = 0;
				$ssl_cert_file = '';
				$ssl_key_file = '';
				$ssl_ca_file = '';
				$ssl_cert_chainfile = '';
			}
			
			$result_checkfordouble_stmt = Database::prepare("
			SELECT `id` FROM `" . TABLE_PANEL_IPSANDPORTS . "`
			WHERE `ip` = :ip AND `port` = :port
		");
			$result_checkfordouble = Database::pexecute_first($result_checkfordouble_stmt, array(
				'ip' => $ip,
				'port' => $port
			));
			
			$result_sameipotherport_stmt = Database::prepare("
			SELECT `id` FROM `" . TABLE_PANEL_IPSANDPORTS . "`
			WHERE `ip` = :ip AND `id` <> :id
		");
			$result_sameipotherport = Database::pexecute_first($result_sameipotherport_stmt, array(
				'ip' => $ip,
				'id' => $id
			));
			
			if ($listen_statement != '1') {
				$listen_statement = '0';
			}
			
			if ($namevirtualhost_statement != '1') {
				$namevirtualhost_statement = '0';
			}
			
			if ($vhostcontainer != '1') {
				$vhostcontainer = '0';
			}
			
			if ($vhostcontainer_servername_statement != '1') {
				$vhostcontainer_servername_statement = '0';
			}
			
			if ($ssl != '1') {
				$ssl = '0';
			}
			
			if ($ssl_cert_file != '') {
				$ssl_cert_file = makeCorrectFile($ssl_cert_file);
			}
			
			if ($ssl_key_file != '') {
				$ssl_key_file = makeCorrectFile($ssl_key_file);
			}
			
			if ($ssl_ca_file != '') {
				$ssl_ca_file = makeCorrectFile($ssl_ca_file);
			}
			
			if ($ssl_cert_chainfile != '') {
				$ssl_cert_chainfile = makeCorrectFile($ssl_cert_chainfile);
			}
			
			if (strlen(trim($docroot)) > 0) {
				$docroot = makeCorrectDir($docroot);
			} else {
				$docroot = '';
			}
			
			if ($result['ip'] != $ip && $result['ip'] == Settings::Get('system.ipaddress') && $result_sameipotherport['id'] == '') {
				standard_error('cantchangesystemip', '', true);
			} elseif ($result_checkfordouble['id'] != '' && $result_checkfordouble['id'] != $id) {
				standard_error('myipnotdouble', '', true);
			} else {
				
				$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_IPSANDPORTS . "`
				SET
				`ip` = :ip, `port` = :port, `listen_statement` = :ls,
				`namevirtualhost_statement` = :nvhs, `vhostcontainer` = :vhc,
				`vhostcontainer_servername_statement` = :vhcss,
				`specialsettings` = :ss, `ssl` = :ssl,
				`ssl_cert_file` = :ssl_cert, `ssl_key_file` = :ssl_key,
				`ssl_ca_file` = :ssl_ca, `ssl_cert_chainfile` = :ssl_chain,
				`default_vhostconf_domain` = :dvhd, `docroot` = :docroot
				WHERE `id` = :id;
			");
				$upd_data = array(
					'ip' => $ip,
					'port' => $port,
					'ls' => $listen_statement,
					'nvhs' => $namevirtualhost_statement,
					'vhc' => $vhostcontainer,
					'vhcss' => $vhostcontainer_servername_statement,
					'ss' => $specialsettings,
					'ssl' => $ssl,
					'ssl_cert' => $ssl_cert_file,
					'ssl_key' => $ssl_key_file,
					'ssl_ca' => $ssl_ca_file,
					'ssl_chain' => $ssl_cert_chainfile,
					'dvhd' => $default_vhostconf_domain,
					'docroot' => $docroot,
					'id' => $id
				);
				Database::pexecute($upd_stmt, $upd_data);
				
				inserttask('1');
				// Using nameserver, insert a task which rebuilds the server config
				inserttask('4');
				
				$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] changed IP/port from '" . $result['ip'] . ":" . $result['port'] . "' to '" . $ip . ":" . $port . "'");
				return $this->response(200, "successfull", $upd_data);
			}
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function delete()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			$id = $this->getParam('id');
			
			$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id` = :id
		");
			$result = Database::pexecute_first($result_stmt, array(
				'id' => $id
			), true, true);
			
			$result_checkdomain_stmt = Database::prepare("
			SELECT `id_domain` as `id` FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_ipandports` = :id
		");
			$result_checkdomain = Database::pexecute_first($result_checkdomain_stmt, array(
				'id' => $id
			), true, true);
			
			if ($result_checkdomain['id'] == '') {
				if (! in_array($result['id'], explode(',', Settings::Get('system.defaultip')))) {
					
					$result_sameipotherport_stmt = Database::prepare("
						SELECT `id` FROM `" . TABLE_PANEL_IPSANDPORTS . "`
						WHERE `ip` = :ip AND `id` <> :id");
					$result_sameipotherport = Database::pexecute_first($result_sameipotherport_stmt, array(
						'id' => $id,
						'ip' => $result['ip']
					));
					
					if (($result['ip'] != Settings::Get('system.ipaddress')) || ($result['ip'] == Settings::Get('system.ipaddress') && $result_sameipotherport['id'] != '')) {
						$result_stmt = Database::prepare("
							SELECT `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "`
							WHERE `id` = :id");
						$result = Database::pexecute_first($result_stmt, array(
							'id' => $id
						));
						if ($result['ip'] != '') {
							
							$del_stmt = Database::prepare("
							DELETE FROM `" . TABLE_PANEL_IPSANDPORTS . "`
							WHERE `id` = :id
						");
							Database::pexecute($del_stmt, array(
								'id' => $id
							));
							
							// also, remove connections to domains (multi-stack)
							$del_stmt = Database::prepare("
							DELETE FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_ipandports` = :id
						");
							Database::pexecute($del_stmt, array(
								'id' => $id
							));
							
							inserttask('1');
							// Using nameserver, insert a task which rebuilds the server config
							inserttask('4');
							
							$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] deleted IP/port '" . $result['ip'] . ":" . $result['port'] . "'");
							return $this->response(200, "successfull", $result);
						}
					} else {
						standard_error('cantdeletesystemip', '', true);
					}
				} else {
					standard_error('cantdeletedefaultip', '', true);
				}
			} else {
				standard_error('ipstillhasdomains', '', true);
			}
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}
}
