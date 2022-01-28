<?php

use Froxlor\Settings;

/**
 * @covers \Froxlor\Cron\Dkim\DkimCron
 * @covers \Froxlor\Cron\Dkim\DkimFilter
 */
class DkimCronTest extends \Froxlor\UnitTest\FroxlorTestCase {

	public static function setUpBeforeClass() : void {
		Settings::Set('dkim.dkim_user', '');
		Settings::Set('dkim.dkim_group', '');
		parent::setUpBeforeClass();
	}
	
	public function testGenerateKeysDkimFilter() {
		$domain = $this->createFroxlorTestDomain(['dkim' => 1]);

		$this->assertEmpty($domain['dkim_selector'], 'domain dkim_selector should be empty');
		$dkimcron = new \Froxlor\Cron\Dkim\DkimFilter(\Froxlor\FroxlorLogger::getInstanceOf());
		$dkimcron->writeDKIMconfigs();
		
		$domain = $this->getFroxlorTestDomain($domain);

		$this->assertNotEmpty($domain['dkim_privkey'], 'DkimFilter domain dkim_privkey should be set');
		$this->assertNotEmpty($domain['dkim_pubkey'], 'DkimFilter domain dkim_pubkey should be set');
		$this->assertNotEmpty($domain['dkim_selector'], 'DkimFilter domain dkim_selector should be set');
	}

	public function testGenerateKeysRspamd() {
		$domain = $this->createFroxlorTestDomain(['dkim' => 1]);

		$dkimcron = new \Froxlor\Cron\Dkim\Rspamd(\Froxlor\FroxlorLogger::getInstanceOf());
		$dkimcron->writeDKIMconfigs();

		$domain = $this->getFroxlorTestDomain($domain);
		$this->assertNotEmpty($domain['dkim_privkey'], 'Rspamd domain dkim_privkey should be set');
		$this->assertNotEmpty($domain['dkim_pubkey'], 'Rspamd domain dkim_pubkey should be set');
		$this->assertNotEmpty($domain['dkim_selector'], 'Rspamd domain dkim_selector should be set');

	}

	public function testBrokenPrivateKey() {
		$domain = $this->createFroxlorTestDomain(['dkim' => 1]);

		// Currently we can't a dkim_privkey via domain api
		$domain['dkim_privkey'] =  'DEADBEAF';

		$this->assertEquals('DEADBEAF', $domain['dkim_privkey'], 'Domain dkim_privkey should be set');

		$this->expectExceptionMessage('Can\'t create public key');
		$dkimcron = new \Froxlor\Cron\Dkim\DkimFilter(\Froxlor\FroxlorLogger::getInstanceOf());
		$dkimcron->createCertificates($domain);
	}

	public function testDKIMZoneCreation() {
		$domain = $this->createFroxlorTestDomain(['dkim' => 1, 'isbinddomain' => '1', 'isemaildomain' => 1]);
		
		$dkimcron = new \Froxlor\Cron\Dkim\DkimFilter(\Froxlor\FroxlorLogger::getInstanceOf());
		$dkimcron->createCertificates($domain);

		$domain = $this->getFroxlorTestDomain($domain);

		$this->assertNotEmpty($domain['dkim_selector'], 'dim_selector should be set');
		$this->assertNotEmpty($domain['dkim_pubkey'], 'dkim_pubkey should be set');

		$dns = new \Froxlor\Dns\Dns();

		$domainkey_found = false;
		$domainkey_key = $domain['dkim_selector'].'._domainkey';
		$resultzone = $dns->createDomainZone($domain['id'], false, false);
		foreach($resultzone->records as $entry) {
			if ($entry->record === $domainkey_key) {
				$this->assertEquals('TXT', $entry->type, 'A domainkey should be a TXT record');
				$this->assertNotEmpty($entry->content, 'A domainkey entry should have data');
				$domainkey_found = true;
			}
		}
		$this->assertTrue($domainkey_found, 'A domainkey should be set');
	}

	public function testDKIMKeySizes() {

		$defaultkeysize = Settings::Get('dkim.dkim_keylength');

		$domain = $this->createFroxlorTestDomain(['dkim' => 1, 'isbinddomain' => '1', 'isemaildomain' => 1]);
		
		$dkimcron = new DkimCronTestObj(\Froxlor\FroxlorLogger::getInstanceOf());

		$keysizes = array(1024, 2048, 4096);

		foreach ($keysizes as $keysize) {
			$domain['dkim_privkey'] = '';
			$domain['dkim_pubkey'] = '';
			Settings::Set('dkim.dkim_keylength', $keysize);
			$dkimcron->createPrivateKey($domain);
			$this->assertNotEmpty($domain['dkim_privkey'], 'dkim_privkey should be set');

			if ($openssl_asymmetricKey = openssl_pkey_get_private($domain['dkim_privkey'])) {
				$key_details = openssl_pkey_get_details($openssl_asymmetricKey);
				$this->assertIsArray($key_details, 'openssl_pkey_get_private should give key details');
				if (is_array($key_details)) {
					$acualkeysize = $key_details['bits'];
					$this->assertEquals($keysize, $acualkeysize, 'Key size should be equal');
				}
			}
			$this->assertNotFalse($openssl_asymmetricKey, 'A private key should be created and read by openssl');
		}

		Settings::Set('dkim.dkim_keylength', $defaultkeysize);
	}	
}

/**
 * Class to access protected key functions
 */
class DkimCronTestObj extends \Froxlor\Cron\Dkim\DkimCron {
	protected function restartConfig() {
		throw new \Exception(__METHOD__.' not implemented');
	}

	public function createCertificates(array $domain) {
		throw new \Exception(__METHOD__.' not implemented');
	}

	public function updateConfig()
	{
		throw new \Exception(__METHOD__.' not implemented');
	}

	/**
	 * Creates private key
	 * Changes $domain['dkim_privkey'] and set $domain['dkim_pubkey'] = '' on success
	 * 
	 * @param array $domain
	 * @return boolean
	 * @throws \Exception
	 */
	public function createPrivateKey(array &$domain) {
		return parent::createPrivateKey($domain);
	}

	/**
	 * Creates public key
	 * Reads $domain['dkim_privkey'] and set $domain['dkim_pubkey'] to new public key
	 * 
	 * @param array $domain
	 * @return boolean
	 * @throws \Exception
	 */
	public function createPublicKey(array &$domain) {
		return parent::createPublicKey($domain);
	}
}