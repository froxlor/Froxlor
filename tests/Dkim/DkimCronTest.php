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
}