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
}