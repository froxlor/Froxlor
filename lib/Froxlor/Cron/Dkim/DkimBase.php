<?php

namespace Froxlor\Cron\Dkim;

use Froxlor\Database\Database;
use Froxlor\Settings;

abstract class DkimBase
{
	protected $logger = null;
	private static $instance = null;

	public static function getInstanceOf($logger): DkimBase
	{
		if (DkimBase::$instance == null) {
			$dkimconfigure = '\\Froxlor\\Cron\\Dkim\\' . Settings::Get('dkim.dkim_service_implementation');
			DkimBase::$instance = new $dkimconfigure($logger);
		}

		return DkimBase::$instance;
	}

	protected function __construct($logger)
	{
		$this->logger = $logger;
	}


	public function writeDKIMconfigs()
	{
		if (Settings::Get('dkim.use_dkim') == '1') {
			if (!file_exists(\Froxlor\FileDir::makeCorrectDir(Settings::Get('dkim.dkim_prefix')))) {
				$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'mkdir -p ' . escapeshellarg(\Froxlor\FileDir::makeCorrectDir(Settings::Get('dkim.dkim_prefix'))));
				\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg(\Froxlor\FileDir::makeCorrectDir(Settings::Get('dkim.dkim_prefix'))));
			}

			$result_domains_stmt = Database::query("
				SELECT `id`, `domain`, `dkim`, `dkim_id`, `dkim_pubkey`, `dkim_privkey`
				FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `dkim` = '1' ORDER BY `id` ASC
			");

			while ($domain = $result_domains_stmt->fetch(\PDO::FETCH_ASSOC)) {
				$this->makeCertificates($domain);
			}
			$this->updateConfig();
			$this->reloadService();
		}
	}

	abstract protected function makeCertificates(array $domain);

	protected function updateConfig()
	{

	}

	protected function writeCertsIfMissing(array $domain, string $privkey_filename, string $pubkey_filename)
	{
		if (!file_exists($privkey_filename) && $domain['dkim_privkey'] != '') {
			$privkey_file_handler = fopen($privkey_filename, "w");
			fwrite($privkey_file_handler, $domain['dkim_privkey']);
			fclose($privkey_file_handler);
			\Froxlor\FileDir::safe_exec("chmod 0640 " . escapeshellarg($privkey_filename));
		}

		if (!file_exists($pubkey_filename) && $domain['dkim_pubkey'] != '') {
			$pubkey_file_handler = fopen($pubkey_filename, "w");
			fwrite($pubkey_file_handler, $domain['dkim_pubkey']);
			fclose($pubkey_file_handler);
			\Froxlor\FileDir::safe_exec("chmod 0644 " . escapeshellarg($pubkey_filename));
		}
	}

	private function reloadService()
	{
		\Froxlor\FileDir::safe_exec(escapeshellcmd(Settings::Get('dkim.dkimrestart_command')));
		$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'Dkim-milter reloaded');
	}
}