<?php
namespace Froxlor\Api\Commands;

use Froxlor\Database\Database;
use Froxlor\Settings;

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
class DirOptions extends \Froxlor\Api\ApiCommand implements \Froxlor\Api\ResourceEntity
{

	/**
	 * add options for a given directory
	 *
	 * @param int $customerid
	 *        	optional, admin-only, the customer-id
	 * @param string $loginname
	 *        	optional, admin-only, the loginname
	 * @param string $path
	 *        	path relative to the customer's home-Directory
	 * @param bool $options_indexes
	 *        	optional, activate directory-listing for this path, default 0 (false)
	 * @param bool $options_cgi
	 *        	optional, allow Perl/CGI execution, default 0 (false)
	 * @param string $error404path
	 *        	optional, custom 404 error string/file
	 * @param string $error403path
	 *        	optional, custom 403 error string/file
	 * @param string $error500path
	 *        	optional, custom 500 error string/file
	 *        	
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function add()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras')) {
			throw new \Exception("You cannot access this resource", 405);
		}
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras.pathoptions')) {
			throw new \Exception("You cannot access this resource", 405);
		}

		// get needed customer info to reduce the email-address-counter by one
		$customer = $this->getCustomerData();

		// required parameters
		$path = $this->getParam('path');

		// parameters
		$options_indexes = $this->getBoolParam('options_indexes', true, 0);
		$options_cgi = $this->getBoolParam('options_cgi', true, 0);
		$error404path = $this->getParam('error404path', true, '');
		$error403path = $this->getParam('error403path', true, '');
		$error500path = $this->getParam('error500path', true, '');

		// validation
		$path = \Froxlor\FileDir::makeCorrectDir(\Froxlor\Validate\Validate::validate($path, 'path', '', '', array(), true));
		$userpath = $path;
		$path = \Froxlor\FileDir::makeCorrectDir($customer['documentroot'] . '/' . $path);

		if (! empty($error404path)) {
			$error404path = $this->correctErrorDocument($error404path, true);
		}

		if (! empty($error403path)) {
			$error403path = $this->correctErrorDocument($error403path, true);
		}

		if (! empty($error500path)) {
			$error500path = $this->correctErrorDocument($error500path, true);
		}

		// check for duplicate path
		$path_dupe_check_stmt = Database::prepare("
			SELECT `id`, `path` FROM `" . TABLE_PANEL_HTACCESS . "`
			WHERE `path`= :path AND `customerid`= :customerid
		");
		$path_dupe_check = Database::pexecute_first($path_dupe_check_stmt, array(
			"path" => $path,
			"customerid" => $customer['customerid']
		), true, true);

		// duplicate check
		if ($path_dupe_check && $path_dupe_check['path'] == $path) {
			\Froxlor\UI\Response::standard_error('errordocpathdupe', $userpath, true);
		}

		// insert the entry
		$stmt = Database::prepare('
			INSERT INTO `' . TABLE_PANEL_HTACCESS . '` SET
			`customerid` = :customerid,
			`path` = :path,
			`options_indexes` = :options_indexes,
			`error404path` = :error404path,
			`error403path` = :error403path,
			`error500path` = :error500path,
			`options_cgi` = :options_cgi
		');
		$params = array(
			"customerid" => $customer['customerid'],
			"path" => $path,
			"options_indexes" => $options_indexes,
			"error403path" => $error403path,
			"error404path" => $error404path,
			"error500path" => $error500path,
			"options_cgi" => $options_cgi
		);
		Database::pexecute($stmt, $params, true, true);
		$id = Database::lastInsertId();
		$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_INFO, "[API] added directory-option for '" . $userpath . "'");
		\Froxlor\System\Cronjob::inserttask('1');

		$result = $this->apiCall('DirOptions.get', array(
			'id' => $id
		));
		return $this->response(200, "successful", $result);
	}

	/**
	 * return a directory-protection entry by id
	 *
	 * @param int $id
	 *        	id of dir-protection entry
	 *        	
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function get()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras')) {
			throw new \Exception("You cannot access this resource", 405);
		}

		$id = $this->getParam('id', true, 0);

		$params = array();
		if ($this->isAdmin()) {
			if ($this->getUserDetail('customers_see_all') == false) {
				// if it's a reseller or an admin who cannot see all customers, we need to check
				// whether the database belongs to one of his customers
				$_custom_list_result = $this->apiCall('Customers.listing');
				$custom_list_result = $_custom_list_result['list'];
				$customer_ids = array();
				foreach ($custom_list_result as $customer) {
					$customer_ids[] = $customer['customerid'];
				}
				$result_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_PANEL_HTACCESS . "`
					WHERE `customerid` IN (" . implode(", ", $customer_ids) . ")
					AND `id` = :id
				");
			} else {
				$result_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_PANEL_HTACCESS . "`
					WHERE `id` = :id
				");
			}
		} else {
			if (Settings::IsInList('panel.customer_hide_options', 'extras.pathoptions')) {
				throw new \Exception("You cannot access this resource", 405);
			}
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_HTACCESS . "`
				WHERE `customerid` = :customerid
				AND `id` = :id
			");
			$params['customerid'] = $this->getUserDetail('customerid');
		}
		$params['id'] = $id;
		$result = Database::pexecute_first($result_stmt, $params, true, true);
		if ($result) {
			$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "[API] get directory options for '" . $result['path'] . "'");
			return $this->response(200, "successful", $result);
		}
		$key = "id #" . $id;
		throw new \Exception("Directory option with " . $key . " could not be found", 404);
	}

	/**
	 * update options for a given directory by id
	 *
	 * @param int $id
	 *        	id of dir-protection entry
	 * @param int $customerid
	 *        	optional, admin-only, the customer-id
	 * @param string $loginname
	 *        	optional, admin-only, the loginname
	 * @param bool $options_indexes
	 *        	optional, activate directory-listing for this path, default 0 (false)
	 * @param bool $options_cgi
	 *        	optional, allow Perl/CGI execution, default 0 (false)
	 * @param string $error404path
	 *        	optional, custom 404 error string/file
	 * @param string $error403path
	 *        	optional, custom 403 error string/file
	 * @param string $error500path
	 *        	optional, custom 500 error string/file
	 *        	
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function update()
	{
		$id = $this->getParam('id', true, 0);

		// validation
		$result = $this->apiCall('DirOptions.get', array(
			'id' => $id
		));

		// get needed customer info to reduce the email-address-counter by one
		$customer = $this->getCustomerData();

		// parameters
		$options_indexes = $this->getBoolParam('options_indexes', true, $result['options_indexes']);
		$options_cgi = $this->getBoolParam('options_cgi', true, $result['options_cgi']);
		$error404path = $this->getParam('error404path', true, $result['error404path']);
		$error403path = $this->getParam('error403path', true, $result['error403path']);
		$error500path = $this->getParam('error500path', true, $result['error500path']);

		if (! empty($error404path)) {
			$error404path = $this->correctErrorDocument($error404path, true);
		}

		if (! empty($error403path)) {
			$error403path = $this->correctErrorDocument($error403path, true);
		}

		if (! empty($error500path)) {
			$error500path = $this->correctErrorDocument($error500path, true);
		}

		if (($options_indexes != $result['options_indexes']) || ($error404path != $result['error404path']) || ($error403path != $result['error403path']) || ($error500path != $result['error500path']) || ($options_cgi != $result['options_cgi'])) {
			\Froxlor\System\Cronjob::inserttask('1');
			$stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_HTACCESS . "`
				SET `options_indexes` = :options_indexes,
				`error404path` = :error404path,
				`error403path` = :error403path,
				`error500path` = :error500path,
				`options_cgi` = :options_cgi
				WHERE `customerid` = :customerid
				AND `id` = :id
			");
			$params = array(
				"customerid" => $customer['customerid'],
				"options_indexes" => $options_indexes,
				"error403path" => $error403path,
				"error404path" => $error404path,
				"error500path" => $error500path,
				"options_cgi" => $options_cgi,
				"id" => $id
			);
			Database::pexecute($stmt, $params, true, true);
			$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_INFO, "[API] edited directory options for '" . str_replace($customer['documentroot'], '/', $result['path']) . "'");
		}

		$result = $this->apiCall('DirOptions.get', array(
			'id' => $id
		));
		return $this->response(200, "successful", $result);
	}

	/**
	 * list all directory-options, if called from an admin, list all directory-options of all customers you are allowed to view, or specify id or loginname for one specific customer
	 *
	 * @param int $customerid
	 *        	optional, admin-only, select directory-protections of a specific customer by id
	 * @param string $loginname
	 *        	optional, admin-only, select directory-protections of a specific customer by loginname
	 * @param array $sql_search
	 *        	optional array with index = fieldname, and value = array with 'op' => operator (one of <, > or =), LIKE is used if left empty and 'value' => searchvalue
	 * @param int $sql_limit
	 *        	optional specify number of results to be returned
	 * @param int $sql_offset
	 *        	optional specify offset for resultset
	 * @param array $sql_orderby
	 *        	optional array with index = fieldname and value = ASC|DESC to order the resultset by one or more fields
	 *
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array count|list
	 */
	public function listing()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras')) {
			throw new \Exception("You cannot access this resource", 405);
		}
		$customer_ids = $this->getAllowedCustomerIds('extras.pathoptions');

		$result = array();
		$query_fields = array();
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_HTACCESS . "`
			WHERE `customerid` IN (" . implode(', ', $customer_ids) . ")" . $this->getSearchWhere($query_fields, true) . $this->getOrderBy() . $this->getLimit());
		Database::pexecute($result_stmt, $query_fields, true, true);
		while ($row = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "[API] list directory-options");
		return $this->response(200, "successful", array(
			'count' => count($result),
			'list' => $result
		));
	}

	/**
	 * returns the total number of accessable directory options
	 *
	 * @param int $customerid
	 *        	optional, admin-only, select directory-protections of a specific customer by id
	 * @param string $loginname
	 *        	optional, admin-only, select directory-protections of a specific customer by loginname
	 *
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array count|list
	 */
	public function listingCount()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras')) {
			throw new \Exception("You cannot access this resource", 405);
		}
		$customer_ids = $this->getAllowedCustomerIds('extras.pathoptions');
		
		$result = array();
		$result_stmt = Database::prepare("
			SELECT COUNT(*) as num_htaccess FROM `" . TABLE_PANEL_HTACCESS . "`
			WHERE `customerid` IN (" . implode(', ', $customer_ids) . ")
		");
		$result = Database::pexecute_first($result_stmt, null, true, true);
		if ($result) {
			return $this->response(200, "successful", $result['num_htaccess']);
		}
	}

	/**
	 * delete a directory-options by id
	 *
	 * @param int $id
	 *        	id of dir-protection entry
	 *        	
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function delete()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras')) {
			throw new \Exception("You cannot access this resource", 405);
		}

		$id = $this->getParam('id');

		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras.pathoptions')) {
			throw new \Exception("You cannot access this resource", 405);
		}

		// get directory-option
		$result = $this->apiCall('DirOptions.get', array(
			'id' => $id
		));

		if ($this->isAdmin()) {
			// get customer-data
			$customer_data = $this->apiCall('Customers.get', array(
				'id' => $result['customerid']
			));
		} else {
			$customer_data = $this->getUserData();
		}

		// do we have to remove the symlink and folder in suexecpath?
		if ((int) Settings::Get('perl.suexecworkaround') == 1) {
			$loginname = $customer_data['loginname'];
			$suexecpath = \Froxlor\FileDir::makeCorrectDir(Settings::Get('perl.suexecpath') . '/' . $loginname . '/' . md5($result['path']) . '/');
			$perlsymlink = \Froxlor\FileDir::makeCorrectFile($result['path'] . '/cgi-bin');
			// remove symlink
			if (file_exists($perlsymlink)) {
				\Froxlor\FileDir::safe_exec('rm -f ' . escapeshellarg($perlsymlink));
				$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_DEBUG, "[API] deleted suexecworkaround symlink '" . $perlsymlink . "'");
			}
			// remove folder in suexec-path
			if (file_exists($suexecpath)) {
				\Froxlor\FileDir::safe_exec('rm -rf ' . escapeshellarg($suexecpath));
				$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_DEBUG, "[API] deleted suexecworkaround path '" . $suexecpath . "'");
			}
		}
		$stmt = Database::prepare("
			DELETE FROM `" . TABLE_PANEL_HTACCESS . "`
			WHERE `customerid`= :customerid
			AND `id`= :id
		");
		Database::pexecute($stmt, array(
			"customerid" => $customer_data['customerid'],
			"id" => $id
		), true, true);
		$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_INFO, "[API] deleted directory-option for '" . str_replace($customer_data['documentroot'], '/', $result['path']) . "'");
		\Froxlor\System\Cronjob::inserttask('1');
		return $this->response(200, "successful", $result);
	}

	/**
	 * this functions validates a given value as ErrorDocument
	 * refs #267
	 *
	 * @param
	 *        	string error-document-string
	 * @param bool $throw_exception
	 *
	 * @return string error-document-string
	 *        
	 */
	private function correctErrorDocument($errdoc = null, $throw_exception = false)
	{
		if ($errdoc !== null && $errdoc != '') {
			// not a URL
			if ((strtoupper(substr($errdoc, 0, 5)) != 'HTTP:' && strtoupper(substr($errdoc, 0, 6)) != 'HTTPS:') || ! \Froxlor\Validate\Validate::validateUrl($errdoc)) {
				// a file
				if (substr($errdoc, 0, 1) != '"') {
					$errdoc = \Froxlor\FileDir::makeCorrectFile($errdoc);
					// apache needs a starting-slash (starting at the domains-docroot)
					if (! substr($errdoc, 0, 1) == '/') {
						$errdoc = '/' . $errdoc;
					}
				} else {
					// a string (check for ending ")
					// string won't work for lighty
					if (Settings::Get('system.webserver') == 'lighttpd') {
						\Froxlor\UI\Response::standard_error('stringerrordocumentnotvalidforlighty', '', $throw_exception);
					} elseif (substr($errdoc, - 1) != '"') {
						$errdoc .= '"';
					}
				}
			} else {
				if (Settings::Get('system.webserver') == 'lighttpd') {
					\Froxlor\UI\Response::standard_error('urlerrordocumentnotvalidforlighty', '', $throw_exception);
				}
			}
		}
		return $errdoc;
	}
}
