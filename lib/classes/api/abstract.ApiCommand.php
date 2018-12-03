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
abstract class ApiCommand extends ApiParameter
{

	/**
	 * debug flag
	 *
	 * @var boolean
	 */
	private $debug = false;

	/**
	 * is admin flag
	 *
	 * @var boolean
	 */
	private $is_admin = false;

	/**
	 * internal user data array
	 *
	 * @var array
	 */
	private $user_data = null;

	/**
	 * logger interface
	 *
	 * @var FroxlorLogger
	 */
	private $logger = null;

	/**
	 * mail interface
	 *
	 * @var PHPMailer
	 */
	private $mail = null;

	/**
	 * language strings array
	 *
	 * @var array
	 */
	protected $lng = null;

	/**
	 * froxlor version
	 *
	 * @var string
	 */
	protected $version = null;

	/**
	 * froxlor dbversion
	 *
	 * @var int
	 */
	protected $dbversion = null;

	/**
	 * froxlor version-branding
	 *
	 * @var string
	 */
	protected $branding = null;

	/**
	 *
	 * @param array $header
	 *        	optional, passed via API
	 * @param array $params
	 *        	optional, array of parameters (var=>value) for the command
	 * @param array $userinfo
	 *        	optional, passed via WebInterface (instead of $header)
	 *        	
	 * @throws Exception
	 */
	public function __construct($header = null, $params = null, $userinfo = null)
	{
		global $lng, $version, $dbversion, $branding;

		parent::__construct($params);

		$this->version = $version;
		$this->dbversion = $dbversion;
		$this->branding = $branding;

		if (! empty($header)) {
			$this->readUserData($header);
		} elseif (! empty($userinfo)) {
			$this->user_data = $userinfo;
			$this->is_admin = (isset($userinfo['adminsession']) && $userinfo['adminsession'] == 1 && $userinfo['adminid'] > 0) ? true : false;
		} else {
			throw new Exception("Invalid user data", 500);
		}
		$this->logger = FroxlorLogger::getInstanceOf($this->user_data);

		// check whether the user is deactivated
		if ($this->getUserDetail('deactivated') == 1) {
			$this->logger()->logAction(LOG_ERROR, LOG_INFO, "[API] User '" . $this->getUserDetail('loginnname') . "' tried to use API but is deactivated");
			throw new Exception("Account suspended", 406);
		}

		$this->initLang();
		$this->initMail();

		if ($this->debug) {
			$this->logger()->logAction(LOG_ERROR, LOG_DEBUG, "[API] " . get_called_class() . ": " . json_encode($params, JSON_UNESCAPED_SLASHES));
		}
	}

	/**
	 * initialize global $lng variable to have
	 * localized strings available for the ApiCommands
	 */
	private function initLang()
	{
		global $lng;

		// query the whole table
		$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_LANGUAGE . "`");

		$langs = array();
		// presort languages
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$langs[$row['language']][] = $row;
		}

		// set default language before anything else to
		// ensure that we can display messages
		$language = Settings::Get('panel.standardlanguage');

		if (isset($this->user_data['language']) && isset($langs[$this->user_data['language']])) {
			// default: use language from session, #277
			$language = $this->user_data['language'];
		} elseif (isset($this->user_data['def_language'])) {
			$language = $this->user_data['def_language'];
		}

		// include every english language file we can get
		foreach ($langs['English'] as $value) {
			include_once makeSecurePath(FROXLOR_INSTALL_DIR . '/' . $value['file']);
		}

		// now include the selected language if its not english
		if ($language != 'English') {
			if (isset($langs[$language])) {
				foreach ($langs[$language] as $value) {
					include_once makeSecurePath(FROXLOR_INSTALL_DIR . '/' . $value['file']);
				}
			} else {
				if ($this->debug) {
					$this->logger()->logAction(LOG_ERROR, LOG_DEBUG, "[API] unable to include user-language '" . $language . "'. Not found in database.", 404);
				}
			}
		}

		// last but not least include language references file
		include_once makeSecurePath(FROXLOR_INSTALL_DIR . '/lng/lng_references.php');

		// set array for ApiCommand
		$this->lng = $lng;
	}

	/**
	 * initialize mail interface so an API wide mail-object is available
	 * @throws phpmailerException
	 */
	private function initMail()
	{
		/**
		 * Initialize the mailingsystem
		 */
		$this->mail = new PHPMailer(true);
		$this->mail->CharSet = "UTF-8";

		if (Settings::Get('system.mail_use_smtp')) {
			$this->mail->isSMTP();
			$this->mail->Host = Settings::Get('system.mail_smtp_host');
			$this->mail->SMTPAuth = Settings::Get('system.mail_smtp_auth') == '1' ? true : false;
			$this->mail->Username = Settings::Get('system.mail_smtp_user');
			$this->mail->Password = Settings::Get('system.mail_smtp_passwd');
			if (Settings::Get('system.mail_smtp_usetls')) {
				$this->mail->SMTPSecure = 'tls';
			} else {
				$this->mail->SMTPAutoTLS = false;
			}
			$this->mail->Port = Settings::Get('system.mail_smtp_port');
		}

		if ( PHPMailer::validateAddress(Settings::Get('panel.adminmail')) !== false) {
			// set return-to address and custom sender-name, see #76
			$this->mail->setFrom(Settings::Get('panel.adminmail'), Settings::Get('panel.adminmail_defname'));
			if (Settings::Get('panel.adminmail_return') != '') {
				$this->mail->addReplyTo(Settings::Get('panel.adminmail_return'), Settings::Get('panel.adminmail_defname'));
			}
		}
	}

	/**
	 * returns an instance of the wanted ApiCommand (e.g.
	 * Customers, Domains, etc);
	 * this is used widely in the WebInterface
	 *
	 * @param array $userinfo
	 *        	array of user-data
	 * @param array $params
	 *        	array of parameters for the command
	 *        	
	 * @return ApiCommand
	 * @throws Exception
	 */
	public static function getLocal($userinfo = null, $params = null)
	{
		return new static(null, $params, $userinfo);
	}

	/**
	 * admin flag
	 *
	 * @return boolean
	 */
	protected function isAdmin()
	{
		return $this->is_admin;
	}

	/**
	 * return field from user-table
	 *
	 * @param string $detail
	 *
	 * @return string
	 */
	protected function getUserDetail($detail = null)
	{
		return (isset($this->user_data[$detail]) ? $this->user_data[$detail] : null);
	}

	/**
	 * return user-data array
	 *
	 * @return array
	 */
	protected function getUserData()
	{
		return $this->user_data;
	}

	/**
	 * return logger instance
	 *
	 * @return FroxlorLogger
	 */
	protected function logger()
	{
		return $this->logger;
	}

	/**
	 * return mailer instance
	 *
	 * @return PHPMailer
	 */
	protected function mailer()
	{
		return $this->mail;
	}

	/**
	 * call an api-command internally
	 *
	 * @param string $command
	 * @param array|null $params
	 *
	 * @return array
	 */
	protected function apiCall($command = null, $params = null)
	{
		$_command = explode(".", $command);
		$module = $_command[0];
		$function = $_command[1];
		$json_result = $module::getLocal($this->getUserData(), $params)->{$function}();
		return json_decode($json_result, true)['data'];
	}

	/**
	 * return api-compatible response in JSON format and send corresponding http-header
	 *
	 * @param int $status
	 * @param string $status_message
	 * @param mixed $data
	 *
	 * @return string json-encoded response message
	 */
	protected function response($status, $status_message, $data = null)
	{
		if (isset($_SERVER["SERVER_PROTOCOL"]) && ! empty($_SERVER["SERVER_PROTOCOL"])) {
			$resheader = $_SERVER["SERVER_PROTOCOL"] . " " . $status;
			if (! empty($status_message)) {
				$resheader .= ' ' . str_replace("\n", " ", $status_message);
			}
			header($resheader);
		}

		$response = array();
		$response['status'] = $status;
		$response['status_message'] = $status_message;
		$response['data'] = $data;

		$json_response = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
		return $json_response;
	}

	/**
	 * returns an array of customers the current user can access
	 *
	 * @param string $customer_hide_option
	 *        	optional, when called as customer, some options might be hidden due to the panel.customer_hide_options ettings
	 *        	
	 * @throws Exception
	 * @return array
	 */
	protected function getAllowedCustomerIds($customer_hide_option = '')
	{
		$customer_ids = array();
		if ($this->isAdmin()) {
			// if we're an admin, list all ftp-users of all the admins customers
			// or optionally for one specific customer identified by id or loginname
			$customerid = $this->getParam('customerid', true, 0);
			$loginname = $this->getParam('loginname', true, '');

			if (! empty($customerid) || ! empty($loginname)) {
				$_result = $this->apiCall('Customers.get', array(
					'id' => $customerid,
					'loginname' => $loginname
				));
				$custom_list_result = array(
					$_result
				);
			} else {
				$_custom_list_result = $this->apiCall('Customers.listing');
				$custom_list_result = $_custom_list_result['list'];
			}
			foreach ($custom_list_result as $customer) {
				$customer_ids[] = $customer['customerid'];
			}
		} else {
			if (! empty($customer_hide_option) && Settings::IsInList('panel.customer_hide_options', $customer_hide_option)) {
				throw new Exception("You cannot access this resource", 405);
			}
			$customer_ids = array(
				$this->getUserDetail('customerid')
			);
		}
		if (empty($customer_ids)) {
			throw new Exception("Required resource unsatisfied.", 405);
		}
		return $customer_ids;
	}

	/**
	 * returns an array of customer data for customer, or by customer-id/loginname for admin/reseller
	 *
	 * @param int $customerid
	 *        	optional, required if loginname is empty
	 * @param string $loginname
	 *        	optional, required of customerid is empty
	 * @param string $customer_resource_check
	 *        	optional, when called as admin, check the resources of the target customer
	 *        	
	 * @throws Exception
	 * @return array
	 */
	protected function getCustomerData($customer_resource_check = '')
	{
		if ($this->isAdmin()) {
			$customerid = $this->getParam('customerid', true, 0);
			$loginname = $this->getParam('loginname', true, '');
			$customer = $this->apiCall('Customers.get', array(
				'id' => $customerid,
				'loginname' => $loginname
			));
			// check whether the customer has enough resources
			if (! empty($customer_resource_check) && $customer[$customer_resource_check . '_used'] >= $customer[$customer_resource_check] && $customer[$customer_resource_check] != '-1') {
				throw new Exception("Customer has no more resources available", 406);
			}
		} else {
			$customer = $this->getUserData();
		}
		return $customer;
	}

	/**
	 * increase/decrease a resource field for customers/admins
	 *
	 * @param string $table
	 * @param string $keyfield
	 * @param int $key
	 * @param string $operator
	 * @param string $resource
	 * @param string $extra
	 */
	protected static function updateResourceUsage($table = null, $keyfield = null, $key = null, $operator = '+', $resource = null, $extra = null, $step = 1)
	{
		$stmt = Database::prepare("
			UPDATE `" . $table . "`
			SET `" . $resource . "` = `" . $resource . "` " . $operator . " " . (int) $step . " " . $extra . "
			WHERE `" . $keyfield . "` = :key
		");
		Database::pexecute($stmt, array(
			'key' => $key
		), true, true);
	}

	/**
	 * return email template content from database or global language file if not found in DB
	 *
	 * @param array $customerdata
	 * @param string $group
	 * @param string $varname
	 * @param array $replace_arr
	 * @param string $default
	 *
	 * @return string
	 */
	protected function getMailTemplate($customerdata = null, $group = null, $varname = null, $replace_arr = array(), $default = "")
	{
		// get template
		$stmt = Database::prepare("
			SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `adminid`= :adminid
			AND `language`= :lang AND `templategroup`= :group AND `varname`= :var
		");
		$result = Database::pexecute_first($stmt, array(
			"adminid" => $customerdata['adminid'],
			"lang" => $customerdata['def_language'],
			"group" => $group,
			"var" => $varname
		), true, true);
		$content = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $default), $replace_arr));
		return $content;
	}

	/**
	 * read user data from database by api-request-header fields
	 *
	 * @param array $header
	 *        	api-request header
	 *        	
	 * @throws Exception
	 * @return boolean
	 */
	private function readUserData($header = null)
	{
		$sel_stmt = Database::prepare("SELECT * FROM `api_keys` WHERE `apikey` = :ak AND `secret` = :as");
		$result = Database::pexecute_first($sel_stmt, array(
			'ak' => $header['apikey'],
			'as' => $header['secret']
		), true, true);
		if ($result) {
			// admin or customer?
			if ($result['customerid'] == 0 && $result['adminid'] > 0) {
				$this->is_admin = true;
				$table = 'panel_admins';
				$key = "adminid";
			} elseif ($result['customerid'] > 0 && $result['adminid'] > 0) {
				$this->is_admin = false;
				$table = 'panel_customers';
				$key = "customerid";
			} else {
				// neither adminid is > 0 nor customerid is > 0 - sorry man, no way
				throw new Exception("Invalid API credentials", 400);
			}
			$sel_stmt = Database::prepare("SELECT * FROM `" . $table . "` WHERE `" . $key . "` = :id");
			$this->user_data = Database::pexecute_first($sel_stmt, array(
				'id' => ($this->is_admin ? $result['adminid'] : $result['customerid'])
			), true, true);
			if ($this->is_admin) {
				$this->user_data['adminsession'] = 1;
			}
			return true;
		}
		throw new Exception("Invalid API credentials", 400);
	}
}
