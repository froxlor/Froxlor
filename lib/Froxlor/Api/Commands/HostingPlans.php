<?php
namespace Froxlor\Api\Commands;

use Froxlor\Settings;
use Froxlor\Database\Database;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package API
 * @since 0.10.0
 *       
 */
class HostingPlans extends \Froxlor\Api\ApiCommand implements \Froxlor\Api\ResourceEntity
{

	/**
	 * list all available hosting plans
	 *
	 * @param array $sql_search
	 *        	optional array with index = fieldname, and value = array with 'op' => operator (one of <, > or =), LIKE is used if left empty and 'value' => searchvalue
	 * @param int $sql_limit
	 *        	optional specify number of results to be returned
	 * @param int $sql_offset
	 *        	optional specify offset for resultset
	 * @param array $sql_orderby
	 *        	optional array with index = fieldname and value = ASC|DESC to order the resultset by one or more fields
	 *        	
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array count|list
	 */
	public function listing()
	{
		if ($this->isAdmin()) {
			$this->logger()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "[API] list hosting-plans");
			$query_fields = array();
			$result_stmt = Database::prepare("
				SELECT p.*, a.loginname as adminname
				FROM `" . TABLE_PANEL_PLANS . "` p, `" . TABLE_PANEL_ADMINS . "` a
				WHERE `p`.`adminid` = `a`.`adminid`" . ($this->getUserDetail('customers_see_all') ? '' : " AND `p`.`adminid` = :adminid ") . $this->getSearchWhere($query_fields, true) . $this->getOrderBy() . $this->getLimit());
			$params = array();
			if ($this->getUserDetail('customers_see_all') == '0') {
				$params['adminid'] = $this->getUserDetail('adminid');
			}
			$params = array_merge($params, $query_fields);
			Database::pexecute($result_stmt, $params, true, true);
			$result = array();
			while ($row = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $this->response(200, "successful", array(
				'count' => count($result),
				'list' => $result
			));
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * returns the total number of accessable hosting plans
	 *
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function listingCount()
	{
		if ($this->isAdmin()) {
			$result_stmt = Database::prepare("
				SELECT COUNT(*) as num_plans
				FROM `" . TABLE_PANEL_PLANS . "` p, `" . TABLE_PANEL_ADMINS . "` a
				WHERE `p`.`adminid` = `a`.`adminid`" . ($this->getUserDetail('customers_see_all') ? '' : " AND `p`.`adminid` = :adminid "));
			$params = array();
			if ($this->getUserDetail('customers_see_all') == '0') {
				$params['adminid'] = $this->getUserDetail('adminid');
			}
			$result = Database::pexecute_first($result_stmt, $params, true, true);
			if ($result) {
				return $this->response(200, "successful", $result['num_plans']);
			}
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * return a hosting-plan entry by either id or plan-name
	 *
	 * @param int $id
	 *        	optional, the hosting-plan-id
	 * @param string $planname
	 *        	optional, the hosting-plan-name
	 *        	
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function get()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id', true, 0);
			$dn_optional = ($id <= 0 ? false : true);
			$planname = $this->getParam('planname', $dn_optional, '');
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_PLANS . "` WHERE " . ($id > 0 ? "`id` = :iddn" : "`name` = :iddn") . ($this->getUserDetail('customers_see_all') ? '' : " AND `adminid` = :adminid"));
			$params = array(
				'iddn' => ($id <= 0 ? $planname : $id)
			);
			if ($this->getUserDetail('customers_see_all') == '0') {
				$params['adminid'] = $this->getUserDetail('adminid');
			}
			$result = Database::pexecute_first($result_stmt, $params, true, true);
			if ($result) {
				$this->logger()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "[API] get hosting-plan '" . $result['name'] . "'");
				return $this->response(200, "successful", $result);
			}
			$key = ($id > 0 ? "id #" . $id : "planname '" . $planname . "'");
			throw new \Exception("Hosting-plan with " . $key . " could not be found", 404);
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * add new hosting-plan
	 *
	 * @param string $name
	 *        	name of the plan
	 * @param string $description
	 *        	optional, description for hosting-plan
	 * @param int $diskspace
	 *        	optional disk-space available for customer in MB, default 0
	 * @param bool $diskspace_ul
	 *        	optional, whether customer should have unlimited diskspace, default 0 (false)
	 * @param int $traffic
	 *        	optional traffic available for customer in GB, default 0
	 * @param bool $traffic_ul
	 *        	optional, whether customer should have unlimited traffic, default 0 (false)
	 * @param int $subdomains
	 *        	optional amount of subdomains available for customer, default 0
	 * @param bool $subdomains_ul
	 *        	optional, whether customer should have unlimited subdomains, default 0 (false)
	 * @param int $emails
	 *        	optional amount of emails available for customer, default 0
	 * @param bool $emails_ul
	 *        	optional, whether customer should have unlimited emails, default 0 (false)
	 * @param int $email_accounts
	 *        	optional amount of email-accounts available for customer, default 0
	 * @param bool $email_accounts_ul
	 *        	optional, whether customer should have unlimited email-accounts, default 0 (false)
	 * @param int $email_forwarders
	 *        	optional amount of email-forwarders available for customer, default 0
	 * @param bool $email_forwarders_ul
	 *        	optional, whether customer should have unlimited email-forwarders, default 0 (false)
	 * @param int $email_quota
	 *        	optional size of email-quota available for customer in MB, default is system-setting mail_quota
	 * @param bool $email_quota_ul
	 *        	optional, whether customer should have unlimited email-quota, default 0 (false)
	 * @param bool $email_imap
	 *        	optional, whether to allow IMAP access, default 0 (false)
	 * @param bool $email_pop3
	 *        	optional, whether to allow POP3 access, default 0 (false)
	 * @param int $ftps
	 *        	optional amount of ftp-accounts available for customer, default 0
	 * @param bool $ftps_ul
	 *        	optional, whether customer should have unlimited ftp-accounts, default 0 (false)
	 * @param int $mysqls
	 *        	optional amount of mysql-databases available for customer, default 0
	 * @param bool $mysqls_ul
	 *        	optional, whether customer should have unlimited mysql-databases, default 0 (false)
	 * @param bool $phpenabled
	 *        	optional, whether to allow usage of PHP, default 0 (false)
	 * @param array $allowed_phpconfigs
	 *        	optional, array of IDs of php-config that the customer is allowed to use, default empty (none)
	 * @param bool $perlenabled
	 *        	optional, whether to allow usage of Perl/CGI, default 0 (false)
	 * @param bool $dnsenabled
	 *        	optional, ether to allow usage of the DNS editor (requires activated nameserver in settings), default 0 (false)
	 * @param bool $logviewenabled
	 *        	optional, ether to allow acccess to webserver access/error-logs, default 0 (false)
	 *        	
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function add()
	{
		if ($this->isAdmin()) {
			$name = $this->getParam('name');
			$description = $this->getParam('description', true, '');

			$value_arr = array();
			$value_arr['diskspace'] = $this->getUlParam('diskspace', 'diskspace_ul', true, 0);
			$value_arr['traffic'] = $this->getUlParam('traffic', 'traffic_ul', true, 0);
			$value_arr['subdomains'] = $this->getUlParam('subdomains', 'subdomains_ul', true, 0);
			$value_arr['emails'] = $this->getUlParam('emails', 'emails_ul', true, 0);
			$value_arr['email_accounts'] = $this->getUlParam('email_accounts', 'email_accounts_ul', true, 0);
			$value_arr['email_forwarders'] = $this->getUlParam('email_forwarders', 'email_forwarders_ul', true, 0);
			$value_arr['email_quota'] = $this->getUlParam('email_quota', 'email_quota_ul', true, Settings::Get('system.mail_quota'));
			$value_arr['email_imap'] = $this->getBoolParam('email_imap', true, 0);
			$value_arr['email_pop3'] = $this->getBoolParam('email_pop3', true, 0);
			$value_arr['ftps'] = $this->getUlParam('ftps', 'ftps_ul', true, 0);
			$value_arr['mysqls'] = $this->getUlParam('mysqls', 'mysqls_ul', true, 0);
			$value_arr['phpenabled'] = $this->getBoolParam('phpenabled', true, 0);
			$p_allowed_phpconfigs = $this->getParam('allowed_phpconfigs', true, array());
			$value_arr['perlenabled'] = $this->getBoolParam('perlenabled', true, 0);
			$value_arr['dnsenabled'] = $this->getBoolParam('dnsenabled', true, 0);
			$value_arr['logviewenabled'] = $this->getBoolParam('logviewenabled', true, 0);

			// validation
			$name = \Froxlor\Validate\Validate::validate(trim($name), 'name', '', '', array(), true);
			$description = \Froxlor\Validate\Validate::validate(str_replace("\r\n", "\n", $description), 'description', '/^[^\0]*$/');

			if (Settings::Get('system.mail_quota_enabled') != '1') {
				$value_arr['email_quota'] = - 1;
			}

			$value_arr['allowed_phpconfigs'] = array();
			if (! empty($p_allowed_phpconfigs) && is_array($p_allowed_phpconfigs)) {
				foreach ($p_allowed_phpconfigs as $allowed_phpconfig) {
					$allowed_phpconfig = intval($allowed_phpconfig);
					$value_arr['allowed_phpconfigs'][] = $allowed_phpconfig;
				}
			}
			$value_arr['allowed_phpconfigs'] = array_map('intval', $value_arr['allowed_phpconfigs']);

			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_PLANS . "`
				SET `adminid` = :adminid, `name` = :name, `description` = :desc, `value` = :valuearr, `ts` = UNIX_TIMESTAMP();
			");
			$ins_data = array(
				'adminid' => $this->getUserDetail('adminid'),
				'name' => $name,
				'desc' => $description,
				'valuearr' => json_encode($value_arr)
			);
			Database::pexecute($ins_stmt, $ins_data, true, true);
			$this->logger()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_WARNING, "[API] added hosting-plan '" . $name . "'");
			$result = $this->apiCall('HostingPlans.get', array(
				'planname' => $name
			));
			return $this->response(200, "successful", $result);
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * update hosting-plan by either id or plan-name
	 *
	 * @param int $id
	 *        	optional the hosting-plan-id
	 * @param string $planname
	 *        	optional the hosting-plan-name
	 * @param string $name
	 *        	optional name of the plan
	 * @param string $description
	 *        	optional description for hosting-plan
	 * @param int $diskspace
	 *        	optional disk-space available for customer in MB, default 0
	 * @param bool $diskspace_ul
	 *        	optional, whether customer should have unlimited diskspace, default 0 (false)
	 * @param int $traffic
	 *        	optional traffic available for customer in GB, default 0
	 * @param bool $traffic_ul
	 *        	optional, whether customer should have unlimited traffic, default 0 (false)
	 * @param int $subdomains
	 *        	optional amount of subdomains available for customer, default 0
	 * @param bool $subdomains_ul
	 *        	optional, whether customer should have unlimited subdomains, default 0 (false)
	 * @param int $emails
	 *        	optional amount of emails available for customer, default 0
	 * @param bool $emails_ul
	 *        	optional, whether customer should have unlimited emails, default 0 (false)
	 * @param int $email_accounts
	 *        	optional amount of email-accounts available for customer, default 0
	 * @param bool $email_accounts_ul
	 *        	optional, whether customer should have unlimited email-accounts, default 0 (false)
	 * @param int $email_forwarders
	 *        	optional amount of email-forwarders available for customer, default 0
	 * @param bool $email_forwarders_ul
	 *        	optional, whether customer should have unlimited email-forwarders, default 0 (false)
	 * @param int $email_quota
	 *        	optional size of email-quota available for customer in MB, default is system-setting mail_quota
	 * @param bool $email_quota_ul
	 *        	optional, whether customer should have unlimited email-quota, default 0 (false)
	 * @param bool $email_imap
	 *        	optional, whether to allow IMAP access, default 0 (false)
	 * @param bool $email_pop3
	 *        	optional, whether to allow POP3 access, default 0 (false)
	 * @param int $ftps
	 *        	optional amount of ftp-accounts available for customer, default 0
	 * @param bool $ftps_ul
	 *        	optional, whether customer should have unlimited ftp-accounts, default 0 (false)
	 * @param int $mysqls
	 *        	optional amount of mysql-databases available for customer, default 0
	 * @param bool $mysqls_ul
	 *        	optional, whether customer should have unlimited mysql-databases, default 0 (false)
	 * @param bool $phpenabled
	 *        	optional, whether to allow usage of PHP, default 0 (false)
	 * @param array $allowed_phpconfigs
	 *        	optional, array of IDs of php-config that the customer is allowed to use, default empty (none)
	 * @param bool $perlenabled
	 *        	optional, whether to allow usage of Perl/CGI, default 0 (false)
	 * @param bool $dnsenabled
	 *        	optional, ether to allow usage of the DNS editor (requires activated nameserver in settings), default 0 (false)
	 * @param bool $logviewenabled
	 *        	optional, ether to allow acccess to webserver access/error-logs, default 0 (false)
	 *        	
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function update()
	{
		if ($this->isAdmin()) {

			// parameters
			$id = $this->getParam('id', true, 0);
			$dn_optional = ($id <= 0 ? false : true);
			$planname = $this->getParam('planname', $dn_optional, '');

			// get requested hosting-plan
			$result = $this->apiCall('HostingPlans.get', array(
				'id' => $id,
				'planname' => $planname
			));
			$id = $result['id'];

			$result['value'] = json_decode($result['value'], true);
			foreach ($result['value'] as $index => $value) {
				$result[$index] = $value;
			}

			$name = $this->getParam('name', true, $result['name']);
			$description = $this->getParam('description', true, $result['description']);

			$value_arr = array();
			$value_arr['diskspace'] = $this->getUlParam('diskspace', 'diskspace_ul', true, $result['diskspace']);
			$value_arr['traffic'] = $this->getUlParam('traffic', 'traffic_ul', true, $result['traffic']);
			$value_arr['subdomains'] = $this->getUlParam('subdomains', 'subdomains_ul', true, $result['subdomains']);
			$value_arr['emails'] = $this->getUlParam('emails', 'emails_ul', true, $result['emails']);
			$value_arr['email_accounts'] = $this->getUlParam('email_accounts', 'email_accounts_ul', true, $result['email_accounts']);
			$value_arr['email_forwarders'] = $this->getUlParam('email_forwarders', 'email_forwarders_ul', true, $result['email_forwarders']);
			$value_arr['email_quota'] = $this->getUlParam('email_quota', 'email_quota_ul', true, $result['email_quota']);
			$value_arr['email_imap'] = $this->getParam('email_imap', true, $result['email_imap']);
			$value_arr['email_pop3'] = $this->getParam('email_pop3', true, $result['email_pop3']);
			$value_arr['ftps'] = $this->getUlParam('ftps', 'ftps_ul', true, $result['ftps']);
			$value_arr['mysqls'] = $this->getUlParam('mysqls', 'mysqls_ul', true, $result['mysqls']);
			$value_arr['phpenabled'] = $this->getBoolParam('phpenabled', true, $result['phpenabled']);
			$p_allowed_phpconfigs = $this->getParam('allowed_phpconfigs', true, $result['allowed_phpconfigs']);
			$value_arr['perlenabled'] = $this->getBoolParam('perlenabled', true, $result['perlenabled']);
			$value_arr['dnsenabled'] = $this->getBoolParam('dnsenabled', true, $result['dnsenabled']);
			$value_arr['logviewenabled'] = $this->getBoolParam('logviewenabled', true, $result['logviewenabled']);

			// validation
			$name = \Froxlor\Validate\Validate::validate(trim($name), 'name', '', '', array(), true);
			$description = \Froxlor\Validate\Validate::validate(str_replace("\r\n", "\n", $description), 'description', '/^[^\0]*$/');

			if (Settings::Get('system.mail_quota_enabled') != '1') {
				$value_arr['email_quota'] = - 1;
			}

			if (empty($name)) {
				$name = $result['name'];
			}

			$value_arr['allowed_phpconfigs'] = array();
			if (! empty($p_allowed_phpconfigs) && is_array($p_allowed_phpconfigs)) {
				foreach ($p_allowed_phpconfigs as $allowed_phpconfig) {
					$allowed_phpconfig = intval($allowed_phpconfig);
					$value_arr['allowed_phpconfigs'][] = $allowed_phpconfig;
				}
			}
			$value_arr['allowed_phpconfigs'] = array_map('intval', $value_arr['allowed_phpconfigs']);

			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_PLANS . "`
				SET `name` = :name, `description` = :desc, `value` = :valuearr, `ts` = UNIX_TIMESTAMP()
				WHERE `id` = :id
			");
			$update_data = array(
				'name' => $name,
				'desc' => $description,
				'valuearr' => json_encode($value_arr),
				'id' => $id
			);
			Database::pexecute($upd_stmt, $update_data, true, true);
			$this->logger()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_WARNING, "[API] updated hosting-plan '" . $result['name'] . "'");
			return $this->response(200, "successful", $update_data);
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * delete hosting-plan by either id or plan-name
	 *
	 * @param int $id
	 *        	optional the hosting-plan-id
	 * @param string $planname
	 *        	optional the hosting-plan-name
	 *        	
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function delete()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id', true, 0);
			$dn_optional = ($id <= 0 ? false : true);
			$planname = $this->getParam('planname', $dn_optional, '');

			// get requested hosting-plan
			$result = $this->apiCall('HostingPlans.get', array(
				'id' => $id,
				'planname' => $planname
			));
			$id = $result['id'];

			$del_stmt = Database::prepare("
				DELETE FROM `" . TABLE_PANEL_PLANS . "` WHERE `id` = :id
			");
			Database::pexecute($del_stmt, array(
				'id' => $id
			), true, true);
			$this->logger()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_WARNING, "[API] deleted hosting-plan '" . $result['name'] . "'");
			return $this->response(200, "successful", $result);
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}
}
