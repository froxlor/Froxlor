<?php

namespace Froxlor\Dkim;

use Froxlor\Settings;

abstract class Dkim
{
	/**
	 * @var \Froxlor\FroxlorLogger
	 */
	protected $logger = null;

	/**
	 * @var \Froxlor\Dkim\Dkim
	 */
	private static $instance = null;

	public static function getInstanceOf($logger): Dkim 
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

	protected function __construct($logger)
	{
		$this->logger = $logger;
	}

	/**
	 * Get all valid selectors for a domain
	 * (Valid means the dkim, dkim_selector, dkim_pubkey are known)
	 * 
	 * @param array $domain 
	 * @param bool $includeDNSRecordData
	 * @return array 
	 */
	public function getSelectorsForDomain($domain, bool $includeDNSRecordData = false) {
		$selectors = array();
		if ($domain['dkim'] == '1' && $domain['dkim_selector'] != '' && $domain['dkim_pubkey'] != '') {
			$selector = array(
				'domain' => $domain['domain'],
				'selector' => $domain['dkim_selector'], 
				'pubkey' => $domain['dkim_pubkey'],
				'notes' => Settings::Get('dkim.dkim_notes'),
				'servicetype' => (Settings::Get('dkim.dkim_servicetype') == '1') ? 'email' : '',
				'dnsrecord_name' => $domain['dkim_selector'].'._domainkey',
			);

			if ($includeDNSRecordData) {
				$dnsrecord_data = $this->createTXTRecordDataForSelector($selector);
				$selector['dnsrecord_data'] = $dnsrecord_data;
			}

			$selectors[] = $selector;
		}
		return $selectors;
	}

	/**
	 * Returns a list of dns records by "selector{$postfix}" => dkim data
	 * 
	 * @param array $domain
	 * @return array A list of dkim dns records 
	 */
	public function createRecords($domain): array
	{
		$zone_dkim = array();

		if (Settings::Get('dkim.use_dkim') == '1' && $domain['dkim'] == '1' && $domain['dkim_selector'] != '' && $domain['dkim_pubkey'] != '') {
			$selectors = $this->getSelectorsForDomain($domain, true);
			foreach ($selectors as $selector) {			
				$dkim_txt = $selector['dnsrecord_data'];
				$dkim_recordname = $selector['dnsrecord_name'];
				$zone_dkim[$dkim_recordname] = $dkim_txt;
			}
		}
		return $zone_dkim;
	}
	
	/**
	 * Create a text record data for selector
	 * @param array $selector 
	 * @return string 
	 */
	public function createTXTRecordDataForSelector($selector) {
			// start
			$dkim_txt = 'v=DKIM1;';

			// algorithm
			$algorithm = explode(',', Settings::Get('dkim.dkim_algorithm'));
			$alg = '';
			foreach ($algorithm as $a) {
				if ($a == 'all') {
					break;
				} else {
					$alg .= $a . ':';
				}
			}

			if ($alg != '') {
				$alg = substr($alg, 0, -1);
				$dkim_txt .= 'h=' . $alg . ';';
			}

			// notes
			$notes = trim($selector['notes']);
			if ($notes != '') {
				$dkim_txt .= 'n=' . $notes . ';';
			}

			// key
			$dkim_txt .= 'k=rsa;p=' . trim(preg_replace('/-----BEGIN PUBLIC KEY-----(.+)-----END PUBLIC KEY-----/s', '$1', str_replace("\n", '', $selector['pubkey']))) . ';';

			// service-type
			$servicetype = trim($selector['servicetype']);
			if ($servicetype != '') {
				$dkim_txt .= 's=' . $servicetype . ';';
			}

			// end-part
			$dkim_txt .= 't=s';
			return $dkim_txt;
	}
}
