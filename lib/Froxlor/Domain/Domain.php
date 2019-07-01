<?php
namespace Froxlor\Domain;

use Froxlor\Database\Database;

class Domain
{

	/**
	 * return an array of all enabled redirect-codes
	 *
	 * @return array array of enabled redirect-codes
	 */
	public static function getRedirectCodesArray()
	{
		$sql = "SELECT * FROM `" . TABLE_PANEL_REDIRECTCODES . "` WHERE `enabled` = '1' ORDER BY `id` ASC";
		$result_stmt = Database::query($sql);

		$codes = array();
		while ($rc = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$codes[] = $rc;
		}

		return $codes;
	}

	/**
	 * return an array of all enabled redirect-codes
	 * for the settings form
	 *
	 * @param bool $add_desc
	 *        	optional, default true, add the code-description
	 *        	
	 * @return array array of enabled redirect-codes
	 */
	public static function getRedirectCodes($add_desc = true)
	{
		global $lng;

		$sql = "SELECT * FROM `" . TABLE_PANEL_REDIRECTCODES . "` WHERE `enabled` = '1' ORDER BY `id` ASC";
		$result_stmt = Database::query($sql);

		$codes = array();
		while ($rc = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$codes[$rc['id']] = $rc['code'];
			if ($add_desc) {
				$codes[$rc['id']] .= ' (' . $lng['redirect_desc'][$rc['desc']] . ')';
			}
		}

		return $codes;
	}

	/**
	 * returns the redirect-code for a given
	 * domain-id
	 *
	 * @param integer $domainid
	 *        	id of the domain
	 *        	
	 * @return string redirect-code
	 */
	public static function getDomainRedirectCode($domainid = 0)
	{

		// get system default
		$default = '301';
		if (\Froxlor\Settings::Get('customredirect.enabled') == '1') {
			$all_codes = self::getRedirectCodes(false);
			$_default = $all_codes[\Froxlor\Settings::Get('customredirect.default')];
			$default = ($_default == '---') ? $default : $_default;
		}
		$code = $default;
		if ($domainid > 0) {

			$result_stmt = Database::prepare("
				SELECT `r`.`code` as `redirect`
				FROM `" . TABLE_PANEL_REDIRECTCODES . "` `r`, `" . TABLE_PANEL_DOMAINREDIRECTS . "` `rc`
				WHERE `r`.`id` = `rc`.`rid` and `rc`.`did` = :domainid
			");
			$result = Database::pexecute_first($result_stmt, array(
				'domainid' => $domainid
			));

			if (is_array($result) && isset($result['redirect'])) {
				$code = ($result['redirect'] == '---') ? $default : $result['redirect'];
			}
		}
		return $code;
	}

	/**
	 * returns the redirect-id for a given
	 * domain-id
	 *
	 * @param integer $domainid
	 *        	id of the domain
	 *        	
	 * @return integer redirect-code-id
	 */
	public static function getDomainRedirectId($domainid = 0)
	{
		$code = 1;
		if ($domainid > 0) {
			$result_stmt = Database::prepare("
				SELECT `r`.`id` as `redirect`
				FROM `" . TABLE_PANEL_REDIRECTCODES . "` `r`, `" . TABLE_PANEL_DOMAINREDIRECTS . "` `rc`
				WHERE `r`.`id` = `rc`.`rid` and `rc`.`did` = :domainid
			");
			$result = Database::pexecute_first($result_stmt, array(
				'domainid' => $domainid
			));

			if (is_array($result) && isset($result['redirect'])) {
				$code = (int) $result['redirect'];
			}
		}
		return $code;
	}

	/**
	 * adds a redirectcode for a domain
	 *
	 * @param integer $domainid
	 *        	id of the domain to add the code for
	 * @param integer $redirect
	 *        	selected redirect-id
	 *        	
	 * @return null
	 */
	public static function addRedirectToDomain($domainid = 0, $redirect = 1)
	{
		if ($domainid > 0) {
			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_DOMAINREDIRECTS . "` SET `rid` = :rid, `did` = :did
			");
			Database::pexecute($ins_stmt, array(
				'rid' => $redirect,
				'did' => $domainid
			));
		}
	}

	/**
	 * updates the redirectcode of a domain
	 * if redirect-code is false, nothing happens
	 *
	 * @param integer $domainid
	 *        	id of the domain to update
	 * @param integer $redirect
	 *        	selected redirect-id or false
	 *        	
	 * @return null
	 */
	public static function updateRedirectOfDomain($domainid = 0, $redirect = false)
	{
		if ($redirect == false) {
			return;
		}

		if ($domainid > 0) {
			$del_stmt = Database::prepare("
				DELETE FROM `" . TABLE_PANEL_DOMAINREDIRECTS . "` WHERE `did` = :domainid
			");
			Database::pexecute($del_stmt, array(
				'domainid' => $domainid
			));

			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_DOMAINREDIRECTS . "` SET `rid` = :rid, `did` = :did
			");
			Database::pexecute($ins_stmt, array(
				'rid' => $redirect,
				'did' => $domainid
			));
		}
	}

	/**
	 * check whether a domain has subdomains added as full-domains
	 * #329
	 *
	 * @param int $id
	 *        	domain-id
	 *        	
	 * @return boolean
	 */
	public static function domainHasMainSubDomains($id = 0)
	{
		$result_stmt = Database::prepare("
		SELECT COUNT(`id`) as `mainsubs` FROM `" . TABLE_PANEL_DOMAINS . "`
		WHERE `ismainbutsubto` = :id");
		$result = Database::pexecute_first($result_stmt, array(
			'id' => $id
		));

		if (isset($result['mainsubs']) && $result['mainsubs'] > 0) {
			return true;
		}
		return false;
	}

	/**
	 * check whether a subof-domain exists
	 * #329
	 *
	 * @param int $id
	 *        	subof-domain-id
	 *        	
	 * @return boolean
	 */
	public static function domainMainToSubExists($id = 0)
	{
		$result_stmt = Database::prepare("
		SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `id` = :id");
		Database::pexecute($result_stmt, array(
			'id' => $id
		));
		$result = $result_stmt->fetch(\PDO::FETCH_ASSOC);

		if (isset($result['id']) && $result['id'] > 0) {
			return true;
		}
		return false;
	}

	/**
	 * Check whether a given domain has an ssl-ip/port assigned
	 *
	 * @param int $domainid
	 *
	 * @return boolean
	 */
	public static function domainHasSslIpPort($domainid = 0)
	{
		$result_stmt = Database::prepare("
			SELECT `dt`.* FROM `" . TABLE_DOMAINTOIP . "` `dt`, `" . TABLE_PANEL_IPSANDPORTS . "` `iap`
			WHERE `dt`.`id_ipandports` = `iap`.`id` AND `iap`.`ssl` = '1' AND `dt`.`id_domain` = :domainid;");
		Database::pexecute($result_stmt, array(
			'domainid' => $domainid
		));
		$result = $result_stmt->fetch(\PDO::FETCH_ASSOC);

		if (is_array($result) && isset($result['id_ipandports'])) {
			return true;
		}
		return false;
	}

	/**
	 * returns true or false whether a given domain id
	 * is the std-subdomain of a customer
	 *
	 * @param
	 *        	int domain-id
	 *        	
	 * @return boolean
	 */
	public static function isCustomerStdSubdomain($did = 0)
	{
		if ($did > 0) {
			$result_stmt = Database::prepare("
				SELECT `customerid` FROM `" . TABLE_PANEL_CUSTOMERS . "`
				WHERE `standardsubdomain` = :did
			");
			$result = Database::pexecute_first($result_stmt, array(
				'did' => $did
			));

			if (is_array($result) && isset($result['customerid']) && $result['customerid'] > 0) {
				return true;
			}
		}
		return false;
	}

	public static function triggerLetsEncryptCSRForAliasDestinationDomain($aliasDestinationDomainID, $log)
	{
		if (isset($aliasDestinationDomainID) && $aliasDestinationDomainID > 0) {
			$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_INFO, "LetsEncrypt CSR triggered for domain ID " . $aliasDestinationDomainID);
			$upd_stmt = Database::prepare("UPDATE
					`" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`
				SET
					`expirationdate` = null
				WHERE
					domainid = :domainid
			");
			Database::pexecute($upd_stmt, array(
				'domainid' => $aliasDestinationDomainID
			));
		}
	}

	public static function doLetsEncryptCleanUp($domainname = null)
	{
		// @ see \Froxlor\Cron\Http\LetsEncrypt\AcmeSh.php
		$acmesh = "/root/.acme.sh/acme.sh";
		if (file_exists($acmesh)) {
			$certificate_folder = dirname($acmesh) . "/" . $domainname;
			if (\Froxlor\Settings::Get('system.leecc') > 0) {
				$certificate_folder .= "_ecc";
			}
			$certificate_folder = \Froxlor\FileDir::makeCorrectDir($certificate_folder);
			if (file_exists($certificate_folder)) {
				$params = " --remove -d " . $domainname;
				if (\Froxlor\Settings::Get('system.leecc') > 0) {
					$params .= " -ecc";
				}
				// run remove command
				\Froxlor\FileDir::safe_exec($acmesh . $params);
				// remove certificates directory
				@unlink($certificate_folder);
			}
		}
		return true;
	}

	/**
	 * checks give path for security issues
	 * and returns a string that can be appended
	 * to a line for a open_basedir directive
	 *
	 * @param string $path
	 *        	the path to check and append
	 * @param boolean $first
	 *        	if true, no ':' will be prefixed to the path
	 *        	
	 * @return string
	 */
	public static function appendOpenBasedirPath($path = '', $first = false)
	{
		if ($path != '' && $path != '/' && (! preg_match("#^/dev#i", $path) || preg_match("#^/dev/urandom#i", $path)) && ! preg_match("#^/proc#i", $path) && ! preg_match("#^/etc#i", $path) && ! preg_match("#^/sys#i", $path) && ! preg_match("#:#", $path)) {

			if (preg_match("#^/dev/urandom#i", $path)) {
				$path = \Froxlor\FileDir::makeCorrectFile($path);
			} else {
				$path = \Froxlor\FileDir::makeCorrectDir($path);
			}

			// check for php-version that requires the trailing
			// slash to be removed as it does not allow the usage
			// of the subfolders within the given folder, fixes #797
			if ((PHP_MINOR_VERSION == 2 && PHP_VERSION_ID >= 50216) || PHP_VERSION_ID >= 50304) {
				// check trailing slash
				if (substr($path, - 1, 1) == '/') {
					// remove it
					$path = substr($path, 0, - 1);
				}
			}

			if ($first) {
				return $path;
			}

			return ':' . $path;
		}
		return '';
	}
}
