<?php
namespace Froxlor\Domain;

use Froxlor\Database\Database;

class Domain
{

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
			$log->logAction(ADM_ACTION, LOG_INFO, "LetsEncrypt CSR triggered for domain ID " . $aliasDestinationDomainID);
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