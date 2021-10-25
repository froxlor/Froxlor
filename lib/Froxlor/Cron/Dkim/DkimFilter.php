<?php

namespace Froxlor\Cron\Dkim;

use Froxlor\Database\Database;
use Froxlor\Settings;

class DkimFilter extends DkimBase
{
	private $dkimdomains = "";
	private $dkimkeys = "";

	protected function makeCertificates(array $domain)
	{
		$privkey_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim' . $domain['dkim_id'] . Settings::Get('dkim.privkeysuffix'));
		$pubkey_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim' . $domain['dkim_id'] . '.public');

		if ($domain['dkim_privkey'] == '' || $domain['dkim_pubkey'] == '') {
			$max_dkim_id_stmt = Database::query("SELECT MAX(`dkim_id`) as `max_dkim_id` FROM `" . TABLE_PANEL_DOMAINS . "`");
			$max_dkim_id = $max_dkim_id_stmt->fetch(\PDO::FETCH_ASSOC);
			$domain['dkim_id'] = (int)$max_dkim_id['max_dkim_id'] + 1;
			$privkey_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim' . $domain['dkim_id'] . Settings::Get('dkim.privkeysuffix'));
			\Froxlor\FileDir::safe_exec('openssl genrsa -out ' . escapeshellarg($privkey_filename) . ' ' . Settings::Get('dkim.dkim_keylength'));
			$domain['dkim_privkey'] = file_get_contents($privkey_filename);
			\Froxlor\FileDir::safe_exec("chmod 0640 " . escapeshellarg($privkey_filename));
			$pubkey_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim' . $domain['dkim_id'] . '.public');
			\Froxlor\FileDir::safe_exec('openssl rsa -in ' . escapeshellarg($privkey_filename) . ' -pubout -outform pem -out ' . escapeshellarg($pubkey_filename));
			$domain['dkim_pubkey'] = file_get_contents($pubkey_filename);
			\Froxlor\FileDir::safe_exec("chmod 0664 " . escapeshellarg($pubkey_filename));
			$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
						`dkim_id` = :dkimid,
						`dkim_privkey` = :privkey,
						`dkim_pubkey` = :pubkey
						WHERE `id` = :id
					");
			$upd_data = array(
				'dkimid' => $domain['dkim_id'],
				'privkey' => $domain['dkim_privkey'],
				'pubkey' => $domain['dkim_pubkey'],
				'id' => $domain['id']
			);
			Database::pexecute($upd_stmt, $upd_data);
		}

		$this->writeCertsIfMissing($domain, $privkey_filename, $pubkey_filename);

		$this->dkimdomains .= $domain['domain'] . "\n";
		$this->dkimkeys .= "*@" . $domain['domain'] . ":" . $domain['domain'] . ":" . $privkey_filename . "\n";
	}

	protected function updateConfig()
	{
		parent::updateConfig();

		$dkimdomains_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . Settings::Get('dkim.dkim_domains'));
		$dkimdomains_file_handler = fopen($dkimdomains_filename, "w");
		fwrite($dkimdomains_file_handler, $this->dkimdomains);
		fclose($dkimdomains_file_handler);
		$dkimkeys_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . Settings::Get('dkim.dkim_dkimkeys'));
		$dkimkeys_file_handler = fopen($dkimkeys_filename, "w");
		fwrite($dkimkeys_file_handler, $this->dkimkeys);
		fclose($dkimkeys_file_handler);
	}
}