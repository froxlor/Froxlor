<?php

namespace Froxlor\Cron\Dkim;

use Froxlor\Database\Database;
use Froxlor\Settings;

class DkimFilter extends DkimCron
{
	private $dkimdomains = '';
	private $dkimkeys = '';


	protected function restartConfig() {
		$this->dkimdomains = '';
		$this->dkimkeys = '';
	}

	public function createCertificates(array $domain)
	{
		if ($domain['dkim_id'] == 0 || empty($domain['dkim_selector'])) {
			// switched from other dkim system, dkim_id may be 0, create new unique dkim id;
			if ($domain['dkim_id'] == 0) {
				$domain['dkim_id'] = $this->createNextId();
			}
			$domain['dkim_selector'] = 'dkim'.$domain['dkim_id'];
			$this->updateDomainDkimRecord($domain);
		}
		$dkim_selector = $domain['dkim_selector'];

		$privkey_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/'. $dkim_selector . Settings::Get('dkim.privkeysuffix'));
		$pubkey_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . $dkim_selector . '.public');

		if ($domain['dkim_privkey'] == '' || $domain['dkim_pubkey'] == '') {
			if ($domain['dkim_privkey'] != '') {
				// don't use any old public key, if private key is missing!
				$domain['dkim_pubkey'] = '';
			}

			if (empty($domain['dkim_privkey'])) {
				if (!$this->createPrivateKey($domain)) {
					return;
				}
			}

			if (!$this->createPublicKey($domain)) {
				return;
			}

			$this->updateDomainDkimRecord($domain);
		}

		$this->writeKeysIfMissing($domain, $privkey_filename, $pubkey_filename);

		$this->dkimdomains .= $domain['domain'] . "\n";
		$this->dkimkeys .= "*@" . $domain['domain'] . ":" . $domain['domain'] . ":" . $privkey_filename . "\n";
	}

	protected function updateConfig()
	{
		if (!empty(Settings::Get('dkim.dkim_domains'))) {
			// Write out dkim filter configuration
			$dkimdomains_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . Settings::Get('dkim.dkim_domains'));
			file_put_contents($dkimdomains_filename, $this->dkimdomains);
		}

		if (!empty(Settings::Get('dkim.dkim_dkimkeys'))) {
			$dkimkeys_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . Settings::Get('dkim.dkim_dkimkeys'));
			file_put_contents($dkimkeys_filename, $this->dkimkeys);
		}
	}
}