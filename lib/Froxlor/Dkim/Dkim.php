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
	 * Returns a list of dns records by "selector{$postfix}" => dkim data
	 * 
	 * @param array $domain
	 * @param string $postfix The postfix for keys, usally '._domainkey'
	 * @return array A list of dkim dns records 
	 */
	public function createRecords($domain, $postfix): array
	{
		$zone_dkim = array();

		if (Settings::Get('dkim.use_dkim') == '1' && $domain['dkim'] == '1' && $domain['dkim_selector'] != '' && $domain['dkim_pubkey'] != '') {

			// Maybe store selector in database and support more then one dkim selector per domain?
			$dkim_recordname = $domain['dkim_selector'].$postfix; //'._domainkey';
			
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
			if (trim(Settings::Get('dkim.dkim_notes') != '')) {
				$dkim_txt .= 'n=' . trim(Settings::Get('dkim.dkim_notes')) . ';';
			}

			// key
			$dkim_txt .= 'k=rsa;p=' . trim(preg_replace('/-----BEGIN PUBLIC KEY-----(.+)-----END PUBLIC KEY-----/s', '$1', str_replace("\n", '', $domain['dkim_pubkey']))) . ';';

			// service-type
			if (Settings::Get('dkim.dkim_servicetype') == '1') {
				$dkim_txt .= 's=email;';
			}

			// end-part
			$dkim_txt .= 't=s';

			// dkim-entry
			$zone_dkim[$dkim_recordname] = $dkim_txt;
		}
		return $zone_dkim;
	}
}
