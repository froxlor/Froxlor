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
 * @since      0.10.0
 *
 */

/**
 * Abstract Class BulkAction to mass-import entities
 *
 * @author Michael Kaufmann (d00p) <d00p@froxlor.org>
 *        
 */
abstract class BulkAction
{

	/**
	 * complete path including filename of file to be imported
	 *
	 * @var string
	 */
	private $_impFile = null;

	/**
	 * customer id of the user the entity is being added to
	 *
	 * @var int
	 */
	private $_custId = null;

	/**
	 * array of customer data read from the database
	 *
	 * @var array
	 */
	private $_custData = null;

	/**
	 * api-function to call for addingg entity
	 *
	 * @var string
	 */
	private $api_call = null;

	/**
	 * api-function parameter names, read from import-file (first line)
	 *
	 * @var array
	 */
	private $api_params = null;

	/**
	 * errors while importing
	 *
	 * @var array
	 */
	private $errors = array();

	/**
	 * class constructor, optionally sets file and customer-id
	 *
	 * @param string $import_file
	 * @param int $customer_id
	 *
	 * @return object BulkAction instance
	 */
	protected function __construct($import_file = null, $customer_id = 0)
	{
		if (! empty($import_file)) {
			$this->_impFile = makeCorrectFile($import_file);
		}
		$this->_custId = $customer_id;
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
	abstract public function doImport($separator = ";", $offset = 0);

	/**
	 * setter for import-file
	 *
	 * @param string $import_file
	 *
	 * @return void
	 */
	public function setImportFile($import_file = null)
	{
		$this->_impFile = makeCorrectFile($import_file);
	}

	/**
	 * setter for customer-id
	 *
	 * @param int $customer_id
	 *
	 * @return void
	 */
	public function setCustomer($customer_id = 0)
	{
		$this->_custId = $customer_id;
	}

	/**
	 * return the list of errors
	 *
	 * @return array
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * setter for api_call
	 *
	 * @param string $api_call
	 *
	 * @return void
	 */
	protected function setApiCall($api_call = "")
	{
		$this->api_call = $api_call;
	}

	protected function importEntity($data_array = null)
	{
		global $userinfo;

		$module = substr($this->api_call, 0, strpos($this->api_call, "."));
		$function = substr($this->api_call, strpos($this->api_call, ".") + 1);

		$new_data = array();
		foreach ($this->api_params as $idx => $param) {
			if (isset($data_array[$idx]) && !empty($data_array[$idx]))
			{
				$new_data[$param] = $data_array[$idx];
			}
		}

		$result = null;
		try {
			$json_result = $module::getLocal($userinfo, $new_data)->$function();
			$result = json_decode($json_result, true)['data'];
		} catch (Exception $e) {
			$this->errors[] = $e->getMessage();
		}
		return !empty($result);
	}

	/**
	 * reads in the csv import file and returns an array with
	 * all the entites to be imported
	 *
	 * @param string $separator
	 *
	 * @return array
	 */
	protected function _parseImportFile($separator = ";")
	{
		if (empty($this->_impFile)) {
			throw new Exception("No file was given for import");
		}

		if (! file_exists($this->_impFile)) {
			throw new Exception("The file '" . $this->_impFile . "' could not be found");
		}

		if (! is_readable($this->_impFile)) {
			throw new Exception("Unable to read file '" . $this->_impFile . "'");
		}

		$file_data = array();
		$is_params_line = true;
		$fh = @fopen($this->_impFile, "r");
		if ($fh) {
			while (($line = fgets($fh)) !== false) {
				$tmp_arr = explode($separator, $line);
				$data_arr = array();
				foreach ($tmp_arr as $idx => $data) {
					if ($is_params_line) {
						$this->api_params[$idx] = $data;
					} else {
						$data_arr[$idx] = $data;
					}
				}
				if ($is_params_line) {
					$is_params_line = false;
					continue;
				}
				$file_data[] = array_map("trim", $data_arr);
			}
			$this->api_params = array_map("trim", $this->api_params);
		} else {
			throw new Exception("Unable to open file '" . $this->_impFile . "'");
		}
		fclose($fh);

		return $file_data;
	}

	/**
	 * to be called first in doImport() to read in customer and entity data
	 */
	protected function preImport()
	{
		$this->_readCustomerData();

		if ($this->_custId <= 0) {
			throw new Exception("Invalid customer selected");
		}

		if (is_null($this->_custData)) {
			throw new Exception("Failed to read customer data");
		}
	}

	/**
	 * reads customer data from panel_customer by $_custId
	 *
	 * @return bool
	 */
	protected function _readCustomerData()
	{
		$cust_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid` = :cid");
		$this->_custData = Database::pexecute_first($cust_stmt, array(
			'cid' => $this->_custId
		));
		if (is_array($this->_custData) && isset($this->_custData['customerid']) && $this->_custData['customerid'] == $this->_custId) {
			return true;
		}
		$this->_custData = null;
		return false;
	}
}
