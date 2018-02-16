<?php

abstract class ApiCommand
{

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
	}

	private function initLang()
	{
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
	 * receive field from parameter-list
	 *
	 * @param string $param
	 * @param mixed $default
	 *        	set if param is not found
	 *        	
	 * @throws Exception
	 * @return mixed
	 */
	protected function getParam($param = null, $default = null)
	{
		if (isset($this->cmd_params[$param])) {
			return $this->cmd_params[$param];
		}
		return $default;
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

	public abstract function list();

	public abstract function get();

	public abstract function add();

	public abstract function update();

	public abstract function delete();

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
