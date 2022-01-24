<?php

namespace Froxlor\Cron\Dkim;

use Exception;
use Froxlor\Database\Database;
use Froxlor\Settings;

abstract class DkimCron
{
	/**
	 * @var \Froxlor\FroxlorLogger
	 */
	protected $logger = null;

	/**
	 * @var \Froxlor\Cron\DkimCron
	 */
	private static $instance = null;

	public static function getInstanceOf($logger): DkimCron 
	{
		if (self::$instance == null) {
			$dkimBackend = Settings::Get('dkim.dkim_service_implementation');
			if (empty($dkimBackend)) {
				$dkimBackend = 'DkimFilter';
			}
			$classPath = __NAMESPACE__.'\\' . $dkimBackend;
			self::$instance = new $classPath($logger);
		}

		return self::$instance;
	}

	public function __construct($logger)
	{
		$this->logger = $logger;
	}

	/**
	 * Creates all DKIM certs for all domains
	 */
	public function writeDKIMconfigs()
	{
		if (Settings::Get('dkim.use_dkim') == '1') {
			$this->createDkimDirectory();

			$this->restartConfig();
			$result_domains_stmt = Database::query("
				SELECT `id`, `domain`, `dkim`, `dkim_id`, `dkim_selector`, `dkim_pubkey`, `dkim_privkey`
				FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `dkim` = '1' ORDER BY `id` ASC
			");

			while ($domain = $result_domains_stmt->fetch(\PDO::FETCH_ASSOC)) {
				$this->createCertificates($domain);
			}
			$this->updateConfig();
			$this->reloadService();
		}
	}

	/**
	 * Reset internal state for config generation
	 */
	abstract protected function restartConfig();

	/**
	 * Generates all certifcates for a domain entry
	 * @param array $domain
	 */
	abstract protected function createCertificates(array $domain);


	/**
	 * Write any additonal config files, like domain to selector mappings
	 */
	abstract protected function updateConfig();


	/**
	 * Create directory to store all dkim certs
	 */
	protected function createDkimDirectory() {
		$dkim_prefix_dir = \Froxlor\FileDir::makeCorrectDir(Settings::Get('dkim.dkim_prefix'));
		if (!file_exists($dkim_prefix_dir)) {
			$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'mkdir -p ' . escapeshellarg($dkim_prefix_dir));
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg($dkim_prefix_dir));
		}
	}

	/**
	 * Return the next free dkim_id
	 * TODO: switch to settings, so dkim_id won't be reused after domain delete, domain add cycle
	 * @return int next free id
	 */
	protected function createNextId() {
		$max_dkim_id_stmt = Database::query("SELECT MAX(`dkim_id`) as `max_dkim_id` FROM `" . TABLE_PANEL_DOMAINS . "`");
		$max_dkim_id = $max_dkim_id_stmt->fetch(\PDO::FETCH_ASSOC);
		return (int)$max_dkim_id+1;
	}

	/**
	 * Update dkim relevant domain data in Database
	 * @param array $domain
	 */
	protected function updateDomainDkimRecord(array $domain)
	{
		$upd_stmt = Database::prepare("
		UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
			`dkim_id` = :dkimid,
			`dkim_selector` = :selector,
			`dkim_privkey` = :privkey,
			`dkim_pubkey` = :pubkey
			WHERE `id` = :id
		");
		$upd_data = array(
			'id' => $domain['id'],
			'dkimid' => $domain['dkim_id'],
			'selector' => $domain['dkim_selector'],
			'privkey' => $domain['dkim_privkey'],
			'pubkey' => $domain['dkim_pubkey']
		);
		Database::pexecute($upd_stmt, $upd_data);
	}



	/**
	 * Change file to have owner and group as defined by settings
	 * @param $filename
	 */
	protected function updateFileOwner($filename) {
		$user = Settings::Get('dkim.dkim_user');
		$group = Settings::Get('dkim.dkim_group');

		if (!empty($user) && !empty($group)) {
			$escaped_usergroup = escapeshellarg($user.':'.$group);
			\Froxlor\FileDir::safe_exec('chown '.$escaped_usergroup.' '.escapeshellarg($filename));
		}
	}


	/**
	 * Creates a public key file from a private key file, changes $domain['dkim_pubkey'] and overwrites public key file
	 * 
	 * @param array $domain
	 * @param string $privkey_filename Full filename to a private key file
	 * @param string $pubkey_filename Full filename for the generated public key file (overwritten)
	 */
	protected function createPublicKeyByPrivateKey(array $domain, string $privkey_filename, string $pubkey_filename) {
		$escaped_pupkey_filename = escapeshellarg($pubkey_filename);

		\Froxlor\FileDir::safe_exec('openssl rsa -in ' . escapeshellarg($privkey_filename) . ' -pubout -outform pem -out ' . $escaped_pupkey_filename);
		
		$pubkey = file_get_contents($pubkey_filename);
		if ($pubkey == false) {
			$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_ERR, "Can\'t create or read public dkim key for domain id: ".$domain['id']);
			return;
		}

		$domain['dkim_pubkey'] = $pubkey;
		\Froxlor\FileDir::safe_exec('chmod 0664 ' .$escaped_pupkey_filename);
		$this->updateFileOwner($pubkey_filename);
	}


	/**
	 * Writes key files to filesystem if they gone missing
	 * @param array $domain
	 * @param string $privkey_filename Full filename to a private key file
	 * @param string $pubkey_filename Full filename for the generated public key file
	 */
	protected function writeKeysIfMissing(array $domain, string $privkey_filename, string $pubkey_filename)
	{
		if (!file_exists($privkey_filename) && $domain['dkim_privkey'] != '') {
			if(file_put_contents($privkey_filename, $domain['dkim_privkey']) !== false) {
				\Froxlor\FileDir::safe_exec("chmod 0640 " . escapeshellarg($privkey_filename));
				$this->updateFileOwner($privkey_filename);
			} else {
				$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_ERR, 'Can\'t write dkim private key for domain id '.$domain['id']);
			}
		}

		if (!file_exists($pubkey_filename) && $domain['dkim_pubkey'] != '') {
			if (file_put_contents($pubkey_filename, $domain['dkim_pubkey']) !== false) {
				\Froxlor\FileDir::safe_exec("chmod 0644 " . escapeshellarg($pubkey_filename));
				$this->updateFileOwner($pubkey_filename);
			} else {
				$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_ERR, 'Can\'t write dkim public key for domain id '.$domain['id']);
			}
		}
	}



	protected function reloadService()
	{
		$cmd = Settings::Get('dkim.dkimrestart_command');
		if (!empty($cmd)) {
			\Froxlor\FileDir::safe_exec(escapeshellcmd($cmd));
			$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'Dkim-milter reloaded');
		}
	}

}