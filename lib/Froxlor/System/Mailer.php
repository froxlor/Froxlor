<?php
namespace Froxlor\System;

use Froxlor\Settings;

class Mailer extends \PHPMailer\PHPMailer\PHPMailer
{

	/**
	 * class construtor
	 *
	 * @param string $exceptions
	 *        	whether to throw exceptions or not
	 *        	
	 */
	public function __construct($exceptions = false)
	{
		parent::__construct($exceptions);
		$this->CharSet = "UTF-8";

		if (Settings::Get('system.mail_use_smtp')) {
			$this->isSMTP();
			$this->Host = Settings::Get('system.mail_smtp_host');
			$this->SMTPAuth = Settings::Get('system.mail_smtp_auth') == '1' ? true : false;
			$this->Username = Settings::Get('system.mail_smtp_user');
			$this->Password = Settings::Get('system.mail_smtp_passwd');
			if (Settings::Get('system.mail_smtp_usetls')) {
				$this->SMTPSecure = 'tls';
			} else {
				$this->SMTPAutoTLS = false;
			}
			$this->Port = Settings::Get('system.mail_smtp_port');
		}

		if (self::ValidateAddress(Settings::Get('panel.adminmail')) !== false) {
			// set return-to address and custom sender-name, see #76
			$this->SetFrom(Settings::Get('panel.adminmail'), Settings::Get('panel.adminmail_defname'));
			if (Settings::Get('panel.adminmail_return') != '') {
				$this->AddReplyTo(Settings::Get('panel.adminmail_return'), Settings::Get('panel.adminmail_defname'));
			}
		}
	}
}
