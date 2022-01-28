<?php

namespace Froxlor\Cron\Dkim;

use Froxlor\Database\Database;
use Froxlor\Settings;

class Rspamd extends DkimCron
{
	private $use_rspamadm_dkim_keygen = false;

	private $rspamd_dkim_selectors_map = '';
	private $rspamd_dkim_paths_map = '';

	protected function restartConfig() {
		$this->rspamd_dkim_selectors_map = '';
		$this->rspamd_dkim_paths_map = '';
	}


	public function createCertificates(array $domain)
	{
		// force a proper dkim selector, reset dkim_id 
		if (empty($domain['dkim_selector'])) {
			$domain['dkim_selector'] = 'dkim';
			$domain['dkim_id'] = 0;
			$this->updateDomainDkimRecord($domain);
		}

		$dkim_selector = $domain['dkim_selector'];
		
		// Create a base filename to attach selector and key or public suffix
		$base_filename = \Froxlor\FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . $domain['domain']);

		$pubkey_filename = $base_filename . '.' . $dkim_selector . '.public';
		$privkey_filename = $base_filename . '.' . $dkim_selector . '.key';

		// Written to dkim_paths.map as it, variable expansion is done by rspamd!
		$privkey_filename_variselector = $base_filename . ".\$selector.key";

		if ($domain['dkim_privkey'] == '' || $domain['dkim_pubkey'] == '') {
			if ($domain['dkim_privkey'] != '') {
				// don't use any old public key, if private key is missing!
				$domain['dkim_pubkey'] = '';
			}

			if ($this->use_rspamadm_dkim_keygen) {
				// Don't use any old key
				file_put_contents($privkey_filename, '');
				\Froxlor\FileDir::safe_exec('rspamadm dkim_keygen -b ' . Settings::Get('dkim.dkim_keylength') . ' -s '.escapeshellarg($dkim_selector).' -d ' . escapeshellarg($domain['domain']) . ' -k ' . escapeshellarg($privkey_filename));
				if (!file_exists($privkey_filename)) {
					$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_ERR, "rspamadm dkim_keygen Can\'t read private dkim key for domain id: ".$domain['id']);
					return;
				}
				
				\Froxlor\FileDir::safe_exec("chmod 0640 " . escapeshellarg($privkey_filename));
				$this->updateFileOwner($privkey_filename);
				
				$privkey = file_get_contents($privkey_filename);
				if ($privkey === false or $privkey == '') {
					$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_ERR, "Can\'t create or read private dkim key for domain id: ".$domain['id']);
					return;
				}
				$domain['dkim_privkey'] = $privkey;
			} else {
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

		$this->rspamd_dkim_selectors_map = $domain['domain']. ' '.$dkim_selector."\n";
		$this->rspamd_dkim_paths_map = $domain['domain']. ' '.$privkey_filename_variselector."\n";
	}

	protected function updateConfig() 
	{
		// Write out dkim_selectors.map
		$rspamd_selector_map_setting = Settings::Get('dkim.rspamd_dkim_selector_map');
		if (!empty($rspamd_selector_map_setting)) {
			
			$rspamd_selector_map_filename = \Froxlor\FileDir::makeCorrectFile($rspamd_selector_map_setting);
			if (!$this->writeFileIfChanged($rspamd_selector_map_filename, $this->rspamd_dkim_selectors_map, 0644)) {
				throw new \Exception("Write to dkim.rspamd_dkim_selector_map failed. Filename: ". $this->rspamd_selector_map_filename);
			}
		}

		// Write out dkim_paths.map
		$rspamd_paths_map_setting = Settings::Get('dkim.rspamd_dkim_paths_map');
		if (!empty($rspamd_paths_map_setting)) {
			$rspamd_paths_map_filename = \Froxlor\FileDir::makeCorrectFile($rspamd_paths_map_setting);
			if (!$this->writeFileIfChanged($rspamd_paths_map_filename, $this->rspamd_dkim_paths_map, 0644)) {
				throw new \Exception("Write dkim.rspamd_dkim_paths_map failed Filename: ". $this->rspamd_paths_map_filename);
			}
			\Froxlor\FileDir::safe_exec("chmod 0644 " . escapeshellarg($rspamd_paths_map_filename));
		}
	}
}