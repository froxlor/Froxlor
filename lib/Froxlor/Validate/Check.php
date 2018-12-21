<?php
namespace Froxlor\Validate;

use Froxlor\Settings;

class Check
{

	public static function checkFcgidPhpFpm($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
	{
		$returnvalue = array(
			FORMFIELDS_PLAUSIBILITY_CHECK_OK
		);

		$check_array = array(
			'system_mod_fcgid_enabled' => array(
				'other_post_field' => 'system_phpfpm_enabled',
				'other_enabled' => 'phpfpm.enabled',
				'other_enabled_lng' => 'phpfpmstillenabled',
				'deactivate' => array(
					'phpfpm.enabled_ownvhost' => 0
				)
			),
			'system_phpfpm_enabled' => array(
				'other_post_field' => 'system_mod_fcgid_enabled',
				'other_enabled' => 'system.mod_fcgid',
				'other_enabled_lng' => 'fcgidstillenabled',
				'deactivate' => array(
					'system.mod_fcgid_ownvhost' => 0
				)
			)
		);

		// interface is to be enabled
		if ((int) $newfieldvalue == 1) {
			// check for POST value of the other field == 1 (active)
			if (isset($_POST[$check_array[$fieldname]['other_post_field']]) && (int) $_POST[$check_array[$fieldname]['other_post_field']] == 1) {
				// the other interface is activated already and STAYS activated
				if ((int) Settings::Get($check_array[$fieldname]['other_enabled']) == 1) {
					$returnvalue = array(
						FORMFIELDS_PLAUSIBILITY_CHECK_ERROR,
						$check_array[$fieldname]['other_enabled_lng']
					);
				} else {
					// fcgid is being validated before fpm -> "ask" fpm about its state
					if ($fieldname == 'system_mod_fcgid_enabled') {
						$returnvalue = self::checkFcgidPhpFpm('system_phpfpm_enabled', null, $check_array[$fieldname]['other_post_field'], null);
					} else {
						// not, bot are nogo
						$returnvalue = $returnvalue = array(
							FORMFIELDS_PLAUSIBILITY_CHECK_ERROR,
							'fcgidandphpfpmnogoodtogether'
						);
					}
				}
			}
			if (in_array(FORMFIELDS_PLAUSIBILITY_CHECK_OK, $returnvalue)) {
				// be sure to deactivate the other one for the froxlor-vhost
				// to avoid having a settings-deadlock
				foreach ($check_array[$fieldname]['deactivate'] as $setting => $value) {
					Settings::Set($setting, $value, true);
				}
			}
		}

		return $returnvalue;
	}

	public function checkMysqlAccessHost($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
	{
		$mysql_access_host_array = array_map('trim', explode(',', $newfieldvalue));

		foreach ($mysql_access_host_array as $host_entry) {

			if (Validate::validate_ip2($host_entry, true, 'invalidip', true, true) == false && Validate::validateDomain($host_entry) == false && Validate::validateLocalHostname($host_entry) == false && $host_entry != '%') {
				return array(
					FORMFIELDS_PLAUSIBILITY_CHECK_ERROR,
					'invalidmysqlhost',
					$host_entry
				);
			}
		}

		return array(
			FORMFIELDS_PLAUSIBILITY_CHECK_OK
		);
	}

	public static function checkHostname($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
	{
		if (0 == strlen(trim($newfieldvalue)) || Validate::validateDomain($newfieldvalue) === false) {
			return array(
				FORMFIELDS_PLAUSIBILITY_CHECK_ERROR,
				'invalidhostname'
			);
		} else {
			return array(
				FORMFIELDS_PLAUSIBILITY_CHECK_OK
			);
		}
	}

	/**
	 * check whether an email account is to be deleted
	 * reference: #1519
	 *
	 * @return bool true if the domain is to be deleted, false otherwise
	 *        
	 */
	public static function checkMailAccDeletionState($email_addr = null)
	{
		// example data of task 7: a:2:{s:9:"loginname";s:4:"webX";s:5:"email";s:20:"deleteme@example.tld";}

		// check for task
		$result_tasks_stmt = \Froxlor\Database\Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_TASKS . "` WHERE `type` = '7' AND `data` LIKE :emailaddr
		");
		\Froxlor\Database\Database::pexecute($result_tasks_stmt, array(
			'emailaddr' => "%" . $email_addr . "%"
		));
		$num_results = \Froxlor\Database\Database::num_rows();

		// is there a task for deleting this email account?
		if ($num_results > 0) {
			return true;
		}
		return false;
	}

	public static function checkPathConflicts($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
	{
		if ((int) Settings::Get('system.mod_fcgid') == 1) {
			// fcgid-configdir has changed -> check against customer-doc-prefix
			if ($fieldname == "system_mod_fcgid_configdir") {
				$newdir = \Froxlor\FileDir::makeCorrectDir($newfieldvalue);
				$cdir = \Froxlor\FileDir::makeCorrectDir(Settings::Get('system.documentroot_prefix'));
			} // customer-doc-prefix has changed -> check against fcgid-configdir
			elseif ($fieldname == "system_documentroot_prefix") {
				$newdir = \Froxlor\FileDir::makeCorrectDir($newfieldvalue);
				$cdir = \Froxlor\FileDir::makeCorrectDir(Settings::Get('system.mod_fcgid_configdir'));
			}

			// neither dir can be within the other nor can they be equal
			if (substr($newdir, 0, strlen($cdir)) == $cdir || substr($cdir, 0, strlen($newdir)) == $newdir || $newdir == $cdir) {
				$returnvalue = array(
					FORMFIELDS_PLAUSIBILITY_CHECK_ERROR,
					'fcgidpathcannotbeincustomerdoc'
				);
			} else {
				$returnvalue = array(
					FORMFIELDS_PLAUSIBILITY_CHECK_OK
				);
			}
		} else {
			$returnvalue = array(
				FORMFIELDS_PLAUSIBILITY_CHECK_OK
			);
		}

		return $returnvalue;
	}

	public static function checkPhpInterfaceSetting($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
	{
		$returnvalue = array(
			FORMFIELDS_PLAUSIBILITY_CHECK_OK
		);

		if ((int) Settings::Get('system.mod_fcgid') == 1) {
			// fcgid only works for apache and lighttpd
			if (strtolower($newfieldvalue) != 'apache2' && strtolower($newfieldvalue) != 'lighttpd') {
				$returnvalue = array(
					FORMFIELDS_PLAUSIBILITY_CHECK_ERROR,
					'fcgidstillenableddeadlock'
				);
			}
		}

		return $returnvalue;
	}

	public static function checkUsername($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
	{
		if (! isset($allnewfieldvalues['customer_mysqlprefix'])) {
			$allnewfieldvalues['customer_mysqlprefix'] = Settings::Get('customer.mysqlprefix');
		}

		$returnvalue = array();
		if (validateUsername($newfieldvalue, Settings::Get('panel.unix_names'), 14 - strlen($allnewfieldvalues['customer_mysqlprefix'])) === true) {
			$returnvalue = array(
				FORMFIELDS_PLAUSIBILITY_CHECK_OK
			);
		} else {
			$errmsg = 'accountprefixiswrong';
			if ($fieldname == 'customer_mysqlprefix') {
				$errmsg = 'mysqlprefixiswrong';
			}
			$returnvalue = array(
				FORMFIELDS_PLAUSIBILITY_CHECK_ERROR,
				$errmsg
			);
		}
		return $returnvalue;
	}
}