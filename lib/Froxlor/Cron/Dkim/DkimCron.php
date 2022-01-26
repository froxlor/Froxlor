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
				try {
					$this->createCertificates($domain);
				} catch(\Exception $e) {
					$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_ERR, $e->getMessage());
				}
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
	 * @throws \Exception
	 */
	abstract public function createCertificates(array $domain);


	/**
	 * Write any additonal config files, like domain to selector mappings
	 * @throws \Exception
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
	 * Write a file to filesystem if necessary and change permission and ownership
	 * 
	 * @param string $filename Full filename to file (processed already with makeCorrectFile)
	 * @param int $permissions File permissions to set, use octal, 0640 as example
	 * @param boolean $updateowner
	 * @return boolean success if file is same or has been written
	 */
	public function writeFileIfChanged(string $filename, string $newdata, int $permissions, bool $updateowner = false) {
		
		if ($permissions > 0777) {
			throw new \Exception("Error Processing permissions");
		}

		$olddata = false;
		$dir = dirname($filename);
		if (!is_dir($dir)) {
			$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Creating directory for '.$filename);
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg($dir));
		}

		if (file_exists($filename)) {
			$olddata = file_get_contents($filename);
		}
		
		if ($olddata === $newdata) {
			$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'Skipping writing '.$filename.', data is up to date');
		} else {
			if(file_put_contents($filename, $newdata) === false) {
				return false;
			}
		}
		
		$permissions_str = '0'.decoct($permissions);
		\Froxlor\FileDir::safe_exec('chmod '.$permissions_str .' '.escapeshellarg($filename));
		if ($updateowner) {
			$this->updateFileOwner($filename);
		}
		return true;
	}

	/**
	 * Creates private key
	 * Changes $domain['dkim_privkey'] and set $domain['dkim_pubkey'] = '' on success
	 * 
	 * @param array $domain
	 * @return boolean
	 * @throws \Exception
	 */
	protected function createPrivateKey(array &$domain) {
		$keylength = (int)Settings::Get('dkim.dkim_keylength');
		if ($keylength < 1024) {
			$keylength = 1024;
		}

		$keyconfig = array(
			"digest_alg" => "sha256",
			"private_key_bits" => $keylength,
			"private_key_type" => OPENSSL_KEYTYPE_RSA,

		);

		if ($openssl_asymmetricKey = openssl_pkey_new($keyconfig)) {
			if (openssl_pkey_export($openssl_asymmetricKey, $privkey, null)) {
				if (!empty($privkey)) {
					$domain['dkim_privkey'] = (string)$privkey;
					$domain['dkim_pubkey'] = '';
					return true;
				}
			}
		}

		$openssl_error = openssl_error_string();
		if ($openssl_error == false) {
			$openssl_error = '';
		}
		throw new \Exception('Can\'t create private key for domain id: '.$domain['id'].' domain:'.$domain['domain']. ' openssl:'.$openssl_error);
		return false;
	}

	/**
	 * Creates public key
	 * Reads $domain['dkim_privkey'] and set $domain['dkim_pubkey'] to new public key
	 * 
	 * @param array $domain
	 * @return boolean
	 * @throws \Exception
	 */
	protected function createPublicKey(array &$domain) {
		if (empty($domain['dkim_privkey'])) {
			$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_ERR, "Can\'t create public key for domain id ".$domain['id']. " private key is empty");
			return false;
		}

		if ($openssl_asymmetricKey = openssl_pkey_get_private($domain['dkim_privkey'])) {
			$key_details = openssl_pkey_get_details($openssl_asymmetricKey);
			if (is_array($key_details)) {
				$domain['dkim_pubkey'] = $key_details['key'];
				return true;
			}
		}

		$openssl_error = openssl_error_string();
		if ($openssl_error == false) {
			$openssl_error = '';
		}
		throw new \Exception('Can\'t create public key for domain id: '.$domain['id'].' domain:'.$domain['domain']. ' openssl:'.$openssl_error);
		return false;
	}


	/**
	 * Writes key files to filesystem if they gone missing
	 * @param array $domain
	 * @param string $privkey_filename Full filename to a private key file
	 * @param string $pubkey_filename Full filename for the generated public key file
	 * @throws \Exception
	 */
	protected function writeKeysIfMissing(array $domain, string $privkey_filename, string $pubkey_filename)
	{
		if (!empty($domain['dkim_privkey'])) {
			if (!$this->writeFileIfChanged($privkey_filename, $domain['dkim_privkey'], 0640, true)) {
				throw new \Exception('Can\'t write dkim private key for domain id '.$domain['id']. ' filename: '.$privkey_filename);
			}
		}

		if (!empty($domain['dkim_pubkey'])) {
			if (!$this->writeFileIfChanged($pubkey_filename, $domain['dkim_pubkey'], 0644, true)) {
				throw new \Exception('Can\'t write dkim public key for domain id '.$domain['id']. ' filename: '.$pubkey_filename);
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