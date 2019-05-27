<?php
namespace Froxlor\Cron\Http\LetsEncrypt;

use Froxlor\FroxlorLogger;
use Froxlor\Settings;
use Froxlor\Database\Database;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Florian Aders <kontakt-froxlor@neteraser.de>
 * @author Froxlor team <team@froxlor.org> (2016-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 * @since 0.9.35
 *       
 */
class AcmeSh extends \Froxlor\Cron\FroxlorCron
{

	private static $apiserver = "";

	private static $acmesh = "/root/.acme.sh/acme.sh";

	/**
	 *
	 * @var \PDOStatement
	 */
	private static $updcert_stmt = null;

	/**
	 *
	 * @var \PDOStatement
	 */
	private static $upddom_stmt = null;

	private static $do_update = true;

	public static function run()
	{
		self::checkInstall();

		self::$apiserver = 'https://acme-v0' . \Froxlor\Settings::Get('system.leapiversion') . '.api.letsencrypt.org/directory';

		FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Updating Let's Encrypt certificates");

		$certificates_stmt = Database::query("
			SELECT
				domssl.`id`,
				domssl.`domainid`,
				domssl.expirationdate,
				domssl.`ssl_cert_file`,
				domssl.`ssl_key_file`,
				domssl.`ssl_ca_file`,
				domssl.`ssl_csr_file`,
				dom.`domain`,
				dom.`wwwserveralias`,
				dom.`documentroot`,
				dom.`id` AS 'domainid',
				dom.`ssl_redirect`,
				cust.`leprivatekey`,
				cust.`lepublickey`,
				cust.`leregistered`,
				cust.`customerid`,
				cust.`loginname`
			FROM
				`" . TABLE_PANEL_CUSTOMERS . "` AS cust,
				`" . TABLE_PANEL_DOMAINS . "` AS dom
			LEFT JOIN
				`" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` AS domssl ON
					dom.`id` = domssl.`domainid`
			WHERE
				dom.`customerid` = cust.`customerid`
				AND cust.deactivated = 0
				AND dom.`letsencrypt` = 1
				AND dom.`aliasdomain` IS NULL
				AND dom.`iswildcarddomain` = 0
				AND (
					domssl.`expirationdate` < DATE_ADD(NOW(), INTERVAL 30 DAY)
					OR domssl.`expirationdate` IS NULL
				)
		");

		$aliasdomains_stmt = Database::prepare("
			SELECT
				dom.`id` as domainid,
				dom.`domain`,
				dom.`wwwserveralias`
			FROM `" . TABLE_PANEL_DOMAINS . "` AS dom
			WHERE
				dom.`aliasdomain` = :id
				AND dom.`letsencrypt` = 1
				AND dom.`iswildcarddomain` = 0
		");

		self::$updcert_stmt = Database::prepare("
			REPLACE INTO
				`" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`
			SET
				`id` = :id,
				`domainid` = :domainid,
				`ssl_cert_file` = :crt,
				`ssl_key_file` = :key,
				`ssl_ca_file` = :ca,
				`ssl_cert_chainfile` = :chain,
				`ssl_csr_file` = :csr,
				`ssl_fullchain_file` = :fullchain,
				`expirationdate` = :expirationdate
		");

		self::$upddom_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `ssl_redirect` = '1' WHERE `id` = :domainid");

		// flag for re-generation of vhost files
		$changedetected = 0;

		// first - generate LE for system-vhost if enabled
		if (Settings::Get('system.le_froxlor_enabled') == '1') {

			$certrow = array(
				'loginname' => 'froxlor.panel',
				'domain' => Settings::Get('system.hostname'),
				'domainid' => 0,
				'documentroot' => \Froxlor\Froxlor::getInstallDir(),
				'leprivatekey' => Settings::Get('system.leprivatekey'),
				'lepublickey' => Settings::Get('system.lepublickey'),
				'leregistered' => Settings::Get('system.leregistered'),
				'ssl_redirect' => Settings::Get('system.le_froxlor_redirect'),
				'expirationdate' => null,
				'ssl_cert_file' => null,
				'ssl_key_file' => null,
				'ssl_ca_file' => null,
				'ssl_csr_file' => null,
				'id' => null
			);

			$froxlor_ssl_settings_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`
				WHERE `domainid` = '0' AND
				(`expirationdate` < DATE_ADD(NOW(), INTERVAL 30 DAY) OR `expirationdate` IS NULL)
			");
			$froxlor_ssl = Database::pexecute_first($froxlor_ssl_settings_stmt);

			$cert_mode = 'issue';
			if ($froxlor_ssl) {
				$cert_mode = 'renew';
				$certrow['id'] = $froxlor_ssl['id'];
				$certrow['expirationdate'] = $froxlor_ssl['expirationdate'];
				$certrow['ssl_cert_file'] = $froxlor_ssl['ssl_cert_file'];
				$certrow['ssl_key_file'] = $froxlor_ssl['ssl_key_file'];
				$certrow['ssl_ca_file'] = $froxlor_ssl['ssl_ca_file'];
				$certrow['ssl_csr_file'] = $froxlor_ssl['ssl_csr_file'];
			} else {
				// check whether we have an entry with valid certificates which just does not need
				// updating yet, so we need to skip this here
				$froxlor_ssl_settings_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid` = '0'
				");
				$froxlor_ssl = Database::pexecute_first($froxlor_ssl_settings_stmt);
				if ($froxlor_ssl && ! empty($froxlor_ssl['ssl_cert_file'])) {
					$cert_mode = false;
				}
			}

			if ($cert_mode) {
				$domains = array(
					$certrow['domain']
				);

				$froxlor_aliases = Settings::Get('system.froxloraliases');
				if (!empty($froxlor_aliases)) {
					$froxlor_aliases = explode(",", $froxlor_aliases);
					foreach ($froxlor_aliases as $falias) {
						if (\Froxlor\Validate\Validate::validateDomain(trim($falias))) {
							$domains[] = trim($falias);
						}
					}
				}

				// Only renew let's encrypt certificate if no broken ssl_redirect is enabled
				// - this temp. deactivation of the ssl-redirect is handled by the webserver-cronjob
				if ($cert_mode == 'renew') {
					FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Creating certificate for " . $certrow['domain']);
				} else {
					FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Updating certificate for " . $certrow['domain']);
				}

				$cronlog = FroxlorLogger::getInstanceOf(array(
					'loginname' => $certrow['loginname'],
					'adminsession' => 0
				));

				self::runAcmeSh($certrow, $domains, $cert_mode, $cronlog, $changedetected);
			}
		}

		// customer domains
		$certrows = $certificates_stmt->fetchAll(\PDO::FETCH_ASSOC);
		$cert_mode = 'issue';
		foreach ($certrows as $certrow) {

			// set logger to corresponding loginname for the log to appear in the users system-log
			$cronlog = FroxlorLogger::getInstanceOf(array(
				'loginname' => $certrow['loginname'],
				'adminsession' => 0
			));

			// Only renew let's encrypt certificate if no broken ssl_redirect is enabled
			if ($certrow['ssl_redirect'] != 2) {

				if (! empty($certrow['ssl_cert_file'])) {
					$cert_mode = 'renew';
					$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Updating certificate for " . $certrow['domain']);
				} else {
					$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Creating certificate for " . $certrow['domain']);
				}

				$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Adding SAN entry: " . $certrow['domain']);
				$domains = array(
					$certrow['domain']
				);
				// add www.<domain> to SAN list
				if ($certrow['wwwserveralias'] == 1) {
					$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Adding SAN entry: www." . $certrow['domain']);
					$domains[] = 'www.' . $certrow['domain'];
				}

				// add alias domains (and possibly www.<aliasdomain>) to SAN list
				Database::pexecute($aliasdomains_stmt, array(
					'id' => $certrow['domainid']
				));
				$aliasdomains = $aliasdomains_stmt->fetchAll(\PDO::FETCH_ASSOC);
				foreach ($aliasdomains as $aliasdomain) {
					$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Adding SAN entry: " . $aliasdomain['domain']);
					$domains[] = $aliasdomain['domain'];
					if ($aliasdomain['wwwserveralias'] == 1) {
						$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Adding SAN entry: www." . $aliasdomain['domain']);
						$domains[] = 'www.' . $aliasdomain['domain'];
					}
				}

				self::runAcmeSh($certrow, $domains, $cert_mode, $cronlog, $changedetected);
			} else {
				$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_WARNING, "Skipping Let's Encrypt generation for " . $certrow['domain'] . " due to an enabled ssl_redirect");
			}
		}

		// If we have a change in a certificate, we need to update the webserver - configs
		// This is easiest done by just creating a new task ;)
		if ($changedetected) {
			\Froxlor\System\Cronjob::inserttask(1);
		}

		FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Let's Encrypt certificates have been updated");
	}

	private static function runAcmeSh($certrow = array(), $domains = array(), $cert_mode = 'issue', &$cronlog = null, &$changedetected = 0)
	{
		if (! empty($domains)) {

			if (self::$do_update) {
				self::checkUpgrade();
				self::$do_update = false;
			}

			$acmesh_cmd = self::$acmesh . " --auto-upgrade 0 --server " . self::$apiserver . " --" . $cert_mode . " -d " . implode(" -d ", $domains);

			if ($cert_mode == 'issue') {
				$acmesh_cmd .= " -w " . Settings::Get('system.letsencryptchallengepath');
			}
			if (Settings::Get('system.leecc') > 0) {
				$acmesh_cmd .= " --keylength ec-" . Settings::Get('system.leecc');
			} else {
				$acmesh_cmd .= " --keylength " . Settings::Get('system.letsencryptkeysize');
			}
			if (Settings::Get('system.letsencryptreuseold') != '1') {
				$acmesh_cmd .= " --always-force-new-domain-key";
			}
			if (Settings::Get('system.letsencryptca') == 'testing') {
				$acmesh_cmd .= " --staging";
			}

			$acme_result = \Froxlor\FileDir::safe_exec($acmesh_cmd);

			$return = array();
			self::readCertificateToVar($certrow['domain'], $return);

			if (! empty($return['crt'])) {

				$newcert = openssl_x509_parse($return['crt']);

				// Store the new data
				Database::pexecute(self::$updcert_stmt, array(
					'id' => $certrow['id'],
					'domainid' => $certrow['domainid'],
					'crt' => $return['crt'],
					'key' => $return['key'],
					'ca' => $return['chain'],
					'chain' => $return['chain'],
					'csr' => $return['csr'],
					'fullchain' => $return['fullchain'],
					'expirationdate' => date('Y-m-d H:i:s', $newcert['validTo_time_t'])
				));

				if ($certrow['ssl_redirect'] == 3) {
					Database::pexecute(self::$upddom_stmt, array(
						'domainid' => $certrow['domainid']
					));
				}

				$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Updated Let's Encrypt certificate for " . $certrow['domain']);
				$changedetected = 1;
			} else {
				$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_ERR, "Could not get Let's Encrypt certificate for " . $certrow['domain'] . ":\n" . implode("\n", $acme_result));
			}
		}
	}

	private static function readCertificateToVar($domain, &$return)
	{
		$certificate_folder = dirname(self::$acmesh) . "/" . $domain;
		if (Settings::Get('system.leecc') > 0) {
			$certificate_folder .= "_ecc";
		}
		$certificate_folder = \Froxlor\FileDir::makeCorrectDir($certificate_folder);

		if (is_dir($certificate_folder)) {
			$return['crt'] = file_get_contents(\Froxlor\FileDir::makeCorrectFile($certificate_folder . '/' . $domain . '.cer'));
			$return['key'] = file_get_contents(\Froxlor\FileDir::makeCorrectFile($certificate_folder . '/' . $domain . '.key'));
			$return['chain'] = file_get_contents(\Froxlor\FileDir::makeCorrectFile($certificate_folder . '/ca.cer'));
			$return['fullchain'] = file_get_contents(\Froxlor\FileDir::makeCorrectFile($certificate_folder . '/fullchain.cer'));
			$return['csr'] = file_get_contents(\Froxlor\FileDir::makeCorrectFile($certificate_folder . '/' . $domain . '.csr'));
		}
	}

	private static function checkInstall()
	{
		if (! file_exists(self::$acmesh)) {
			FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Could not find acme.sh - installing it to /root/.acme.sh/");
			$return = false;
			\Froxlor\FileDir::safe_exec("wget -O - https://get.acme.sh | sh", $return, array(
				'|'
			));
		}
	}

	private static function checkUpgrade()
	{
		$acmesh_result = \Froxlor\FileDir::safe_exec(self::$acmesh . " --upgrade");
		FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, "Checking for LetsEncrypt client upgrades before renewing certificates:\n" . implode("\n", $acmesh_result));
	}
}
