<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2018 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2018-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    API-example
 * @since      0.10.0
 *
 */
class FroxlorAPI
{

	/**
	 * URL to api.php of your froxlor installation
	 *
	 * @var string
	 */
	private $host = "";

	/**
	 * your api-key
	 *
	 * @var string
	 */
	private $api_key = "";

	/**
	 * your api-secret
	 *
	 * @var string
	 */
	private $api_secret = "";

	/**
	 * last cURL error message
	 *
	 * @var string
	 */
	private $last_error = "";

	/**
	 * last response header received
	 *
	 * @var array
	 */
	private $last_header = array();

	/**
	 * last response data received
	 *
	 * @var array
	 */
	private $last_body = array();

	/**
	 * create FroxlorAPI object
	 *
	 * @param string $host
	 *        	URL to api.php of your froxlor installation
	 * @param string $api_key
	 *        	your api-key
	 * @param string $api_secret
	 *        	your api-secret
	 *
	 * @return FroxlorAPI
	 */
	public function __construct(string $host, string $api_key, string $api_secret)
	{
		$this->host = $host;
		$this->api_key = $api_key;
		$this->api_secret = $api_secret;
	}

	/**
	 * send request to froxlor api
	 *
	 * @param string $command
	 * @param array $params
	 *
	 * @return FroxlorAPI
	 */
	public function request(string $command, array $params = array()): FroxlorAPI
	{
		// build request array
		$request = [
			'header' => [
				'apikey' => $this->api_key,
				'secret' => $this->api_secret
			],
			'body' => [
				'command' => $command
			]
		];

		// add parameter to request-body if any
		if (! empty($params)) {
			$request['body']['params'] = $params;
		}

		// reset last data
		$this->last_header = array();
		$this->last_body = array();

		// send actual request
		$response = $this->requestCurl(json_encode($request));

		// decode response
		$resp = json_decode($response[1], true);
		// set body to data-part of response
		$this->last_body = $resp['data'];
		// set header of response
		$this->last_header = [
			'status' => $resp['status'],
			'status_message' => $resp['status_message']
		];

		// check for error in api response
		if (isset($this->last_header['status']) && $this->last_header['status'] >= 400) {
			// set last-error message
			$this->last_error .= "[" . $this->last_header['status'] . "] " . $this->last_header['status_message'];
		}

		return $this;
	}

	/**
	 * returns last response header
	 *
	 * @return array status|status_message
	 */
	public function getLastHeader(): array
	{
		return $this->last_header;
	}

	/**
	 * returns last response data
	 *
	 * @return array
	 */
	public function getLastResponse(): array
	{
		return $this->last_body;
	}

	/**
	 * return last known error message
	 *
	 * @return string
	 */
	public function getLastError(): string
	{
		return $this->last_error;
	}

	/**
	 * send cURL request to api
	 *
	 * @param string $data
	 *        	json array
	 *        	
	 * @return array header|body
	 */
	private function requestCurl(string $data): array
	{
		// reset last error message
		$this->last_error = "";

		$ch = curl_init($this->host);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-type: application/json'
		));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$verbose = fopen('php://temp', 'w+');
		curl_setopt($ch, CURLOPT_STDERR, $verbose);

		if (! $data = curl_exec($ch)) {
			$this->last_error = 'Curl execution error: ' . curl_error($ch) . "\n";
			rewind($verbose);
			$verboseLog = stream_get_contents($verbose);
			$this->last_error .= "Verbose information: " . htmlspecialchars($verboseLog) . "\n";
		}

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($data, 0, $header_size);
		$body = substr($data, $header_size);

		curl_close($ch);
		return array(
			$header,
			$body
		);
	}
}
