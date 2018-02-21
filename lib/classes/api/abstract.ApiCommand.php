<?php

abstract class ApiCommand
{

	private $debug = true;

	private $is_admin = false;

	private $user_data = null;

	private $logger = null;

	private $mail = null;

	private $cmd_params = null;

	public function __construct($header = null, $params = null, $userinfo = null)
	{
		global $lng;
		
		$this->cmd_params = $params;
		if (! empty($header)) {
			$this->readUserData($header);
		} elseif (! empty($userinfo)) {
			$this->user_data = $userinfo;
			$this->is_admin = (isset($userinfo['adminsession']) && $userinfo['adminsession'] == 1 && $userinfo['adminid'] > 0) ? true : false;
		} else {
			throw new Exception("Invalid user data", 500);
		}
		$this->logger = FroxlorLogger::getInstanceOf($this->user_data);
		
		$this->initLang();
		$this->initMail();
		
		if ($this->debug) {
			$this->logger()->logAction(LOG_ERROR, LOG_DEBUG, "[API] " . get_called_class() . ": " . json_encode($params, JSON_UNESCAPED_SLASHES));
		}
	}

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
		
		if (isset($this->user_data['language']) && isset($languages[$this->user_data['language']])) {
			// default: use language from session, #277
			$language = $this->user_data['language'];
		} elseif (isset($this->user_data['def_language'])) {
			$language = $this->user_data['def_language'];
		}
		
		// include every english language file we can get
		foreach ($langs['English'] as $key => $value) {
			include_once makeSecurePath($value['file']);
		}
		
		// now include the selected language if its not english
		if ($language != 'English') {
			foreach ($langs[$language] as $key => $value) {
				include_once makeSecurePath($value['file']);
			}
		}
		
		// last but not least include language references file
		include_once makeSecurePath(FROXLOR_INSTALL_DIR . '/lng/lng_references.php');
	}

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
		
		if (PHPMailer::ValidateAddress(Settings::Get('panel.adminmail')) !== false) {
			// set return-to address and custom sender-name, see #76
			$this->mail->SetFrom(Settings::Get('panel.adminmail'), Settings::Get('panel.adminmail_defname'));
			if (Settings::Get('panel.adminmail_return') != '') {
				$this->mail->AddReplyTo(Settings::Get('panel.adminmail_return'), Settings::Get('panel.adminmail_defname'));
			}
		}
	}

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
	 * get specific parameter from the parameterlist;
	 * check for existence and != empty if needed.
	 * Maybe more in the future
	 *
	 * @param string $param
	 *        	parameter to get out of the request-parameter list
	 * @param bool $optional
	 *        	default: false
	 * @param mixed $default
	 *        	value which is returned if optional=true and param is not set
	 *        	
	 * @throws Exception
	 * @return mixed
	 */
	protected function getParam($param = null, $optional = false, $default = '')
	{
		// does it exist?
		if (! isset($this->cmd_params[$param])) {
			if ($optional === false) {
				// get module + function for better error-messages
				$inmod = $this->getModFunctionString();
				throw new Exception('Requested parameter "' . $param . '" could not be found for "' . $inmod . '"', 404);
			}
			return $default;
		}
		// is it empty? - test really on string, as value 0 is being seen as empty by php
		if ($this->cmd_params[$param] === "") {
			if ($optional === false) {
				// get module + function for better error-messages
				$inmod = $this->getModFunctionString();
				throw new Exception('Requested parameter "' . $param . '" is empty where it should not be for "' . $inmod . '"', 406);
			}
			return '';
		}
		// everything else is fine
		return $this->cmd_params[$param];
	}

	/**
	 * get specific parameter which also has and unlimited-field
	 *
	 * @param string $param
	 *        	parameter to get out of the request-parameter list
	 * @param string $ul_field
	 *        	parameter to get out of the request-parameter list
	 * @param bool $optional
	 *        	default: false
	 * @param mixed $default
	 *        	value which is returned if optional=true and param is not set
	 *        	
	 * @return mixed
	 */
	protected function getUlParam($param = null, $ul_field = null, $optional = false, $default = 0)
	{
		$param_value = intval_ressource($this->getParam($param, $optional, $default));
		$ul_field_value = $this->getParam($ul_field, true, 0);
		if ($ul_field_value != 0) {
			$param_value = - 1;
		}
		return $param_value;
	}

	/**
	 * returns "module::function()" for better error-messages (missing parameter etc.)
	 * makes debugging a whole lot more comfortable
	 *
	 * @return string
	 */
	private function getModFunctionString()
	{
		$_c = get_called_class();
		
		$level = 2;
		if (version_compare(PHP_VERSION, "5.4.0", "<")) {
			$t = debug_backtrace();
		} else {
			$t = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		}
		while (true) {
			$c = $t[$level]['class'];
			$f = $t[$level]['function'];
			if ($c != get_called_class()) {
				$level ++;
				if ($level > 5) {
					break;
				}
				continue;
			}
			return $c . ':' . $f;
		}
	}

	/**
	 * update value of parameter
	 *
	 * @param string $param
	 * @param mixed $value
	 *
	 * @throws Exception
	 * @return boolean
	 */
	protected function updateParam($param, $value = null)
	{
		if (isset($this->cmd_params[$param])) {
			$this->cmd_params[$param] = $value;
			return true;
		}
		throw new Exception("Unable to update parameter '" . $param . "' as it does not exist", 500);
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

	protected function response($status, $status_message, $data = null)
	{
		header("HTTP/1.1 " . $status);
		
		$response['status'] = $status;
		$response['status_message'] = $status_message;
		$response['data'] = $data;
		
		$json_response = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
		return $json_response;
	}

	private function readUserData($header = null)
	{
		$sel_stmt = Database::prepare("SELECT * FROM `api_keys` WHERE `apikey` = :ak AND `secret` = :as");
		$result = Database::pexecute_first($sel_stmt, array(
			'ak' => $header['apikey'],
			'as' => $header['secret']
		), true, true);
		if ($result) {
			// admin or customer?
			if ($result['customerid'] == 0) {
				$this->is_admin = true;
				$table = 'panel_admins';
				$key = "adminid";
			} else {
				$this->is_admin = false;
				$table = 'panel_customers';
				$key = "customerid";
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
