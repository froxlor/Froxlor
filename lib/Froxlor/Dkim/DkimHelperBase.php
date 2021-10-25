<?php

namespace Froxlor\Dkim;

use Froxlor\Settings;

abstract class DkimHelperBase
{
	protected $logger = null;

	private static $instance = null;

	public static function getInstanceOf($logger): DkimHelperBase
	{
		if (DkimHelperBase::$instance == null) {
			$dkimconfigure = '\\Froxlor\\Dkim\\' . Settings::Get('dkim.dkim_service_implementation');
			DkimHelperBase::$instance = new $dkimconfigure($logger);
		}

		return DkimHelperBase::$instance;
	}

	protected function __construct($logger)
	{
		$this->logger = $logger;
	}

	public abstract function getRecordName($domain);

	public static function createRecord($domain): array
	{
		$zone_dkim = array();

		if (Settings::Get('dkim.use_dkim') == '1' && $domain['dkim'] == '1' && $domain['dkim_pubkey'] != '') {
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
			$zone_dkim[] = $dkim_txt;
		}

		return $zone_dkim;
	}
}