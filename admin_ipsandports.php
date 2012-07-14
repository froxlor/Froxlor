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
 * @package    Panel
 *
 */

define('AREA', 'admin');

/**
 * Include our init.php, which manages Sessions, Language etc.
 */

require ("./lib/init.php");

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

if($page == 'ipsandports'
   || $page == 'overview')
{
	if($action == '')
	{
		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_ipsandports");
		$fields = array(
			'ip' => $lng['admin']['ipsandports']['ip'],
			'port' => $lng['admin']['ipsandports']['port']
		);
		$paging = new paging($userinfo, $db, TABLE_PANEL_IPSANDPORTS, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
		$ipsandports = '';
		$result = $db->query("SELECT `id`, `ip`, `port`, `listen_statement`, `namevirtualhost_statement`, `vhostcontainer`, `vhostcontainer_servername_statement`, `specialsettings`, `ssl` FROM `" . TABLE_PANEL_IPSANDPORTS . "` " . $paging->getSqlWhere(false) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		$paging->setEntries($db->num_rows($result));
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;

		while($row = $db->fetch_array($result))
		{
			if($paging->checkDisplay($i))
			{
				$row = htmlentities_array($row);

				if(filter_var($row['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
				{
					$row['ip'] = '[' . $row['ip'] . ']';
				}

				eval("\$ipsandports.=\"" . getTemplate("ipsandports/ipsandports_ipandport") . "\";");
				$count++;
			}

			$i++;
		}

		eval("echo \"" . getTemplate("ipsandports/ipsandports") . "\";");
	}
	elseif($action == 'delete'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id`='" . (int)$id . "'");

		if(isset($result['id'])
		   && $result['id'] == $id)
		{
			$result_checkdomain = $db->query_first("SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `ipandport`='" . (int)$id . "'");

			if($result_checkdomain['id'] == '')
			{
				if($result['id'] != $settings['system']['defaultip'])
				{
					$result_sameipotherport = $db->query_first("SELECT `id` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ip`='" . $db->escape($result['ip']) . "' AND `id`!='" . (int)$id . "'");

					if(($result['ip'] != $settings['system']['ipaddress'])
					   || ($result['ip'] == $settings['system']['ipaddress'] && $result_sameipotherport['id'] != ''))
					{
						$result = $db->query_first("SELECT `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id`='" . (int)$id . "'");

						if($result['ip'] != '')
						{
							if(isset($_POST['send'])
							   && $_POST['send'] == 'send')
							{
								$db->query("DELETE FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id`='" . (int)$id . "'");
								$log->logAction(ADM_ACTION, LOG_WARNING, "deleted IP/port '" . $result['ip'] . ":" . $result['port'] . "'");
								inserttask('1');

								# Using nameserver, insert a task which rebuilds the server config
								if ($settings['system']['bind_enable'])
								{
									inserttask('4');
								}
								redirectTo($filename, Array('page' => $page, 's' => $s));
							}
							else
							{
								ask_yesno('admin_ip_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['ip'] . ':' . $result['port']);
							}
						}
					}
					else
					{
						standard_error('cantdeletesystemip');
					}
				}
				else
				{
					standard_error('cantdeletedefaultip');
				}
			}
			else
			{
				standard_error('ipstillhasdomains');
			}
		}
	}
	elseif($action == 'add')
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$ip = validate_ip($_POST['ip']);
			$port = validate($_POST['port'], 'port', '/^(([1-9])|([1-9][0-9])|([1-9][0-9][0-9])|([1-9][0-9][0-9][0-9])|([1-5][0-9][0-9][0-9][0-9])|(6[0-4][0-9][0-9][0-9])|(65[0-4][0-9][0-9])|(655[0-2][0-9])|(6553[0-5]))$/Di', array('stringisempty', 'myport'));
			$listen_statement = isset($_POST['listen_statement']) ? 1 : 0;
			$namevirtualhost_statement = isset($_POST['namevirtualhost_statement']) ? 1 : 0;
			$vhostcontainer = isset($_POST['vhostcontainer']) ? 1 : 0;
			$specialsettings = validate(str_replace("\r\n", "\n", $_POST['specialsettings']), 'specialsettings', '/^[^\0]*$/');
			$vhostcontainer_servername_statement = isset($_POST['vhostcontainer_servername_statement']) ? 1 : 0;
			$default_vhostconf_domain = validate(str_replace("\r\n", "\n", $_POST['default_vhostconf_domain']), 'default_vhostconf_domain', '/^[^\0]*$/');
			$docroot = validate($_POST['docroot'], 'docroot');
			if((int)$settings['system']['use_ssl'] == 1)
			{
				$ssl = intval($_POST['ssl']);
				$ssl_cert_file = validate($_POST['ssl_cert_file'], 'ssl_cert_file');
				$ssl_key_file = validate($_POST['ssl_key_file'], 'ssl_key_file');
				$ssl_ca_file = validate($_POST['ssl_ca_file'], 'ssl_ca_file');
				$ssl_cert_chainfile = validate($_POST['ssl_cert_chainfile'], 'ssl_cert_chainfile');
			} else {
				$ssl = 0;
				$ssl_cert_file = '';
				$ssl_key_file = '';
				$ssl_ca_file = '';
				$ssl_cert_chainfile = '';
			}
			
			if($listen_statement != '1')
			{
				$listen_statement = '0';
			}

			if($namevirtualhost_statement != '1')
			{
				$namevirtualhost_statement = '0';
			}

			if($vhostcontainer != '1')
			{
				$vhostcontainer = '0';
			}

			if($vhostcontainer_servername_statement != '1')
			{
				$vhostcontainer_servername_statement = '0';
			}

			if($ssl != '1')
			{
				$ssl = '0';
			}
		
			if($ssl_cert_file != '')
			{
				$ssl_cert_file = makeCorrectFile($ssl_cert_file);
			}

			if($ssl_key_file != '')
			{
				$ssl_key_file = makeCorrectFile($ssl_key_file);
			}

			if($ssl_ca_file != '')
			{
				$ssl_ca_file = makeCorrectFile($ssl_ca_file);
			}

			if($ssl_cert_chainfile != '')
			{
				$ssl_cert_chainfile = makeCorrectFile($ssl_cert_chainfile);
			}

			if(strlen(trim($docroot)) > 0)
			{
				$docroot = makeCorrectDir($docroot);
			}
			else
			{
				$docroot = '';
			}

			$result_checkfordouble = $db->query_first("SELECT `id` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ip`='" . $db->escape($ip) . "' AND `port`='" . (int)$port . "'");

			if($result_checkfordouble['id'] != '')
			{
				standard_error('myipnotdouble');
			}
			else
			{
				$db->query("INSERT INTO `" . TABLE_PANEL_IPSANDPORTS . "`
					SET 
						`ip` = '" . $db->escape($ip) . "', 
						`port` = '" . (int)$port . "', 
						`listen_statement` = '" . (int)$listen_statement . "', 
						`namevirtualhost_statement` = '" . (int)$namevirtualhost_statement . "', 
						`vhostcontainer` = '" . (int)$vhostcontainer . "', 
						`vhostcontainer_servername_statement` = '" . (int)$vhostcontainer_servername_statement . "', 
						`specialsettings` = '" . $db->escape($specialsettings) . "', 
						`ssl` = '" . (int)$ssl . "', 
						`ssl_cert_file` = '" . $db->escape($ssl_cert_file) . "', 
						`ssl_key_file` = '" . $db->escape($ssl_key_file) . "', 
						`ssl_ca_file` = '" . $db->escape($ssl_ca_file) . "',
						`ssl_cert_chainfile` = '" . $db->escape($ssl_cert_chainfile) . "', 
						`default_vhostconf_domain` = '" . $db->escape($default_vhostconf_domain) . "',
						`docroot` = '" . $db->escape($docroot) . "';
					");

				if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
				{
					$ip = '[' . $ip . ']';
				}

				$log->logAction(ADM_ACTION, LOG_WARNING, "added IP/port '" . $ip . ":" . $port . "'");
				inserttask('1');

				# Using nameserver, insert a task which rebuilds the server config
				if ($settings['system']['bind_enable'])
				{
					inserttask('4');
				}
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
		}
		else
		{
			/*
			$enable_ssl = makeyesno('ssl', '1', '0', '0');
			$listen_statement = makeyesno('listen_statement', '1', '0', '1');
			$namevirtualhost_statement = makeyesno('namevirtualhost_statement', '1', '0', '1');
			$vhostcontainer = makeyesno('vhostcontainer', '1', '0', '1');
			$vhostcontainer_servername_statement = makeyesno('vhostcontainer_servername_statement', '1', '0', '1');
			*/

			$ipsandports_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/ipsandports/formfield.ipsandports_add.php';
			$ipsandports_add_form = htmlform::genHTMLForm($ipsandports_add_data);

			$title = $ipsandports_add_data['ipsandports_add']['title'];
			$image = $ipsandports_add_data['ipsandports_add']['image'];

			eval("echo \"" . getTemplate("ipsandports/ipsandports_add") . "\";");
		}
	}
	elseif($action == 'edit'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id`='" . (int)$id . "'");

		if($result['ip'] != '')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$ip = validate_ip($_POST['ip']);
				$port = validate($_POST['port'], 'port', '/^(([1-9])|([1-9][0-9])|([1-9][0-9][0-9])|([1-9][0-9][0-9][0-9])|([1-5][0-9][0-9][0-9][0-9])|(6[0-4][0-9][0-9][0-9])|(65[0-4][0-9][0-9])|(655[0-2][0-9])|(6553[0-5]))$/Di', array('stringisempty', 'myport'));
				$result_checkfordouble = $db->query_first("SELECT `id` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ip`='" . $db->escape($ip) . "' AND `port`='" . (int)$port . "'");
				$result_sameipotherport = $db->query_first("SELECT `id` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ip`='" . $db->escape($result['ip']) . "' AND `id`!='" . (int)$id . "'");
				$listen_statement = isset($_POST['listen_statement']) ? 1 : 0;
				$namevirtualhost_statement = isset($_POST['namevirtualhost_statement']) ? 1 : 0;
				$vhostcontainer = isset($_POST['vhostcontainer']) ? 1 : 0;
				$specialsettings = validate(str_replace("\r\n", "\n", $_POST['specialsettings']), 'specialsettings', '/^[^\0]*$/');
				$vhostcontainer_servername_statement = isset($_POST['vhostcontainer_servername_statement']) ? 1 : 0;
				$default_vhostconf_domain = validate(str_replace("\r\n", "\n", $_POST['default_vhostconf_domain']), 'default_vhostconf_domain', '/^[^\0]*$/');
				$docroot =  validate($_POST['docroot'], 'docroot');

				if((int)$settings['system']['use_ssl'] == 1
					/* 
					 * check here if ssl is even checked, cause if not, we don't need
					 * to validate and set all the $ssl_*_file vars
					 */
					&& isset($_POST['ssl'])
					&& $_POST['ssl'] != 0
				) {
					$ssl = 1;
					$ssl_cert_file = validate($_POST['ssl_cert_file'], 'ssl_cert_file');
					$ssl_key_file = validate($_POST['ssl_key_file'], 'ssl_key_file');
					$ssl_ca_file = validate($_POST['ssl_ca_file'], 'ssl_ca_file');
					$ssl_cert_chainfile = validate($_POST['ssl_cert_chainfile'], 'ssl_cert_chainfile');
				} else {
					$ssl = 0;
					$ssl_cert_file = '';
					$ssl_key_file = '';
					$ssl_ca_file = '';
					$ssl_cert_chainfile = '';
				}
				
				if($listen_statement != '1')
				{
					$listen_statement = '0';
				}

				if($namevirtualhost_statement != '1')
				{
					$namevirtualhost_statement = '0';
				}

				if($vhostcontainer != '1')
				{
					$vhostcontainer = '0';
				}

				if($vhostcontainer_servername_statement != '1')
				{
					$vhostcontainer_servername_statement = '0';
				}

				if($ssl != '1')
				{
					$ssl = '0';
				}
				
				if($ssl_cert_file != '')
				{
					$ssl_cert_file = makeCorrectFile($ssl_cert_file);
				}

				if($ssl_key_file != '')
				{
					$ssl_key_file = makeCorrectFile($ssl_key_file);
				}

				if($ssl_ca_file != '')
				{
					$ssl_ca_file = makeCorrectFile($ssl_ca_file);
				}

				if($ssl_cert_chainfile != '')
				{
					$ssl_cert_chainfile = makeCorrectFile($ssl_cert_chainfile);
				}

				if(strlen(trim($docroot)) > 0)
				{
					$docroot = makeCorrectDir($docroot);
				}
				else
				{
					$docroot = '';
				}

				if($result['ip'] != $ip
				   && $result['ip'] == $settings['system']['ipaddress']
				   && $result_sameipotherport['id'] == '')
				{
					standard_error('cantchangesystemip');
				}
				elseif($result_checkfordouble['id'] != ''
				       && $result_checkfordouble['id'] != $id)
				{
					standard_error('myipnotdouble');
				}
				else
				{

					$db->query("UPDATE `" . TABLE_PANEL_IPSANDPORTS . "`
					SET 
						`ip` = '" . $db->escape($ip) . "', 
						`port` = '" . (int)$port . "', 
						`listen_statement` = '" . (int)$listen_statement . "', 
						`namevirtualhost_statement` = '" . (int)$namevirtualhost_statement . "', 
						`vhostcontainer` = '" . (int)$vhostcontainer . "', 
						`vhostcontainer_servername_statement` = '" . (int)$vhostcontainer_servername_statement . "', 
						`specialsettings` = '" . $db->escape($specialsettings) . "', 
						`ssl` = '" . (int)$ssl . "', 
						`ssl_cert_file` = '" . $db->escape($ssl_cert_file) . "', 
						`ssl_key_file` = '" . $db->escape($ssl_key_file) . "', 
						`ssl_ca_file` = '" . $db->escape($ssl_ca_file) . "',
						`ssl_cert_chainfile` = '" . $db->escape($ssl_cert_chainfile) . "', 
						`default_vhostconf_domain` = '" . $db->escape($default_vhostconf_domain) . "',
						`docroot` = '" . $db->escape($docroot) . "' 
					WHERE `id`='" . (int)$id . "'
					");

					$log->logAction(ADM_ACTION, LOG_WARNING, "changed IP/port from '" . $result['ip'] . ":" . $result['port'] . "' to '" . $ip . ":" . $port . "'");
					inserttask('1');

					// Using nameserver, insert a task which rebuilds the server config
					if ($settings['system']['bind_enable'])
					{
						inserttask('4');
					}
					redirectTo($filename, Array('page' => $page, 's' => $s));
				}
			}
			else
			{
				$result = htmlentities_array($result);
				/*
				$enable_ssl = makeyesno('ssl', '1', '0', $result['ssl']);
				$listen_statement = makeyesno('listen_statement', '1', '0', $result['listen_statement']);
				$namevirtualhost_statement = makeyesno('namevirtualhost_statement', '1', '0', $result['namevirtualhost_statement']);
				$vhostcontainer = makeyesno('vhostcontainer', '1', '0', $result['vhostcontainer']);
				$vhostcontainer_servername_statement = makeyesno('vhostcontainer_servername_statement', '1', '0', $result['vhostcontainer_servername_statement']);
				*/

				$ipsandports_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/ipsandports/formfield.ipsandports_edit.php';
				$ipsandports_edit_form = htmlform::genHTMLForm($ipsandports_edit_data);
	
				$title = $ipsandports_edit_data['ipsandports_edit']['title'];
				$image = $ipsandports_edit_data['ipsandports_edit']['image'];

				eval("echo \"" . getTemplate("ipsandports/ipsandports_edit") . "\";");
			}
		}
	}
}

?>