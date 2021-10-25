<?php

namespace Froxlor\Cron\Dkim;

use Froxlor\Database\Database;
use Froxlor\Settings;

class Rspamd extends DkimBase
{

	protected function makeCertificates(array $domain)
	{
		$pubkey_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . $domain['domain'] . '.dkim.public');
		$privkey_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . $domain['domain'] . '.dkim.key');
		if ($domain['dkim_privkey'] == '' || $domain['dkim_pubkey'] == '') {
			//$pubdns_zone = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . $domain['domain'] . '.txt');
			\Froxlor\FileDir::safe_exec('rspamadm dkim_keygen -b ' . Settings::Get('dkim.dkim_keylength') . ' -s dkim -d ' . $domain['domain'] . ' -k ' . escapeshellarg($privkey_filename));
			$domain['dkim_privkey'] = file_get_contents($privkey_filename);
			\Froxlor\FileDir::safe_exec("chmod 0640 " . escapeshellarg($privkey_filename));

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
	}
}