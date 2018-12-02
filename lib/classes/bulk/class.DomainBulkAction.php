<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 *
 * @since      0.9.33
 *
 */

/**
 * Class DomainBulkAction to mass-import domains for a given customer
 *
 * @author Michael Kaufmann (d00p) <d00p@froxlor.org>
 *        
 */
class DomainBulkAction extends BulkAction
{

	/**
	 *
	 * @return object DomainBulkAction instance
	 */
	public function __construct($import_file = null, $customer_id = 0)
	{
		parent::__construct($import_file, $customer_id);
		$this->setApiCall('Domains.add');
	}

	/**
	 * import the parsed import file data with an optional separator other then semicolon
	 * and offset (maybe for header-line in csv or similar)
	 *
	 * @param string $separator
	 * @param int $offset
	 *
	 * @return array 'all' => amount of records processed, 'imported' => number of imported records
	 */
	public function doImport($separator = ";", $offset = 0)
	{
		$this->preImport();

		// get the admins userinfo to check for domains_used, etc.
		global $userinfo;

		if ($userinfo['domains'] == "-1") {
			$dom_unlimited = true;
		} else {
			$dom_unlimited = false;
		}

		$domains_used = (int) $userinfo['domains_used'];
		$domains_avail = (int) $userinfo['domains'];

		if (empty($separator) || strlen($separator) != 1) {
			throw new Exception("Invalid separator specified: '" . $separator . "'");
		}

		if (! is_int($offset) || $offset < 0) {
			throw new Exception("Invalid offset specified");
		}

		try {
			$domain_array = $this->_parseImportFile($separator);
		} catch (Exception $e) {
			throw $e;
		}

		if (count($domain_array) <= 0) {
			throw new Exception("No domains were read from the file.");
		}

		$global_counter = 0;
		$import_counter = 0;
		$note = '';
		foreach ($domain_array as $idx => $dom) {
			if ($idx >= $offset) {
				if ($dom_unlimited || (! $dom_unlimited && $domains_used < $domains_avail)) {

					$result = $this->importEntity($dom);
					if ($result) {
						$import_counter ++;
						$domains_used ++;
					}
				} else {
					$note .= 'You have reached your maximum allocation of domains (' . $domains_avail . ').';
					break;
				}
			}
			$global_counter ++;
		}

		return array(
			'all' => $global_counter,
			'imported' => $import_counter,
			'notice' => $note
		);
	}
}
